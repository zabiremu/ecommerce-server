<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DatabaseBackupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use RuntimeException;

/** Database backups: list, create, download, delete — and restore (Super Admin only). */
class BackupController extends Controller
{
    public function __construct(private DatabaseBackupService $backups)
    {
    }

    public function index()
    {
        $backups = $this->backups->list();
        $canRestore = Auth::guard('admin')->user()->isSuperAdmin();

        return view('Admin.backups.index', compact('backups', 'canRestore'));
    }

    public function store()
    {
        $name = $this->backups->create('manual');

        return redirect()->route('admin.backups.index')->with('success', "Backup created: {$name}");
    }

    public function download(string $name)
    {
        try {
            return response()->download($this->backups->path($name));
        } catch (RuntimeException) {
            abort(404);
        }
    }

    public function destroy(string $name)
    {
        try {
            $this->backups->delete($name);
        } catch (RuntimeException) {
            abort(404);
        }

        return redirect()->route('admin.backups.index')->with('success', 'Backup deleted.');
    }

    public function restore(Request $request, string $name)
    {
        $this->authorizeRestore($request);

        try {
            return $this->runRestore($this->backups->path($name), $name);
        } catch (RuntimeException $e) {
            return back()->withErrors(['backup' => $e->getMessage()]);
        }
    }

    /** Restore from a backup file downloaded earlier (e.g. moved from another computer). */
    public function upload(Request $request)
    {
        $this->authorizeRestore($request);
        $request->validate(['backup_file' => 'required|file|max:512000']);

        $file = $request->file('backup_file');
        try {
            $this->backups->assertBackupFile($file->getRealPath());
        } catch (RuntimeException $e) {
            return back()->withErrors(['backup_file' => $e->getMessage()]);
        }

        $name = 'backup-' . now()->format('Ymd-His') . '-upload.sql.gz';
        $file->move($this->backups->dir(), $name);

        return $this->runRestore($this->backups->path($name), $file->getClientOriginalName());
    }

    private function authorizeRestore(Request $request): void
    {
        abort_unless(Auth::guard('admin')->user()->isSuperAdmin(), 403, 'Only a Super Admin can restore a backup.');
        $request->validate(['confirm' => 'required|in:RESTORE'], ['confirm.in' => 'Type RESTORE (capital letters) to confirm.']);
    }

    private function runRestore(string $path, string $label)
    {
        try {
            $safety = $this->backups->restore($path);
        } catch (\Throwable $e) {
            Log::error('Backup restore failed', ['file' => $label, 'error' => $e->getMessage()]);

            return redirect()->route('admin.backups.index')
                ->withErrors(['backup' => 'Restore failed: ' . $e->getMessage() . ' — a safety backup was taken just before; restore it to undo any partial change.']);
        }

        Log::info('Database restored from backup', ['file' => $label, 'admin' => Auth::guard('admin')->id()]);

        return redirect()->route('admin.backups.index')
            ->with('success', "Database restored from {$label}. The data as it was just before is saved as {$safety}.");
    }
}
