@extends('Admin.Layout.app')

@section('title', 'Database Backup')
@section('page_title', 'Database Backup')

@push('styles')
@include('Admin.accounts._styles')
@endpush

@section('content')
@php
    $admin = Auth::guard('admin')->user();
    $tz = \App\Models\DealsBanner::LOCAL_TZ;
    $size = fn ($b) => $b >= 1048576 ? number_format($b / 1048576, 1) . ' MB' : number_format($b / 1024, 0) . ' KB';
    $typeLabel = ['auto' => 'Automatic', 'manual' => 'Manual', 'pre-restore' => 'Before restore', 'upload' => 'Uploaded'];
    $latest = $backups[0]['created_at'] ?? null;
    $stale = !$latest || $latest->lt(now()->subDay());
@endphp

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif
@if ($errors->any())
    <div class="mb-4 px-4 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">{{ $errors->first() }}</div>
@endif

<div class="flex flex-wrap items-center justify-between gap-3 mb-4">
    <div>
        <h1 class="wp-h1">Database Backup</h1>
        <p class="text-[13px] text-[#50575e] mt-1">A full copy of all data — products, orders, customers, accounts. Taken automatically every day; the newest {{ \App\Services\DatabaseBackupService::KEEP }} are kept.</p>
    </div>
    @if ($admin->hasPermission('backups.create'))
    <form method="POST" action="{{ route('admin.backups.store') }}">
        @csrf
        <button type="submit" class="wp-btn wp-btn-primary"><i class="fas fa-database mr-1"></i> Back up now</button>
    </form>
    @endif
</div>

<div class="grid grid-cols-2 lg:grid-cols-3 gap-3 mb-4">
    <div class="summary-card {{ $stale ? 'net-neg' : 'net-pos' }}">
        <div class="lbl">Last Backup</div>
        <div class="val" style="font-size:17px">{{ $latest ? $latest->copy()->setTimezone($tz)->format('d M Y, h:i A') : 'Never' }}</div>
        <div class="sub">{{ $latest ? $latest->diffForHumans() : 'Click “Back up now”' }}</div>
    </div>
    <div class="summary-card"><div class="lbl">Backups Kept</div><div class="val">{{ count($backups) }}</div></div>
    <div class="summary-card col-span-2 lg:col-span-1"><div class="lbl">Total Size</div><div class="val">{{ $size(array_sum(array_column($backups, 'size'))) }}</div></div>
</div>

<div class="acc-warn mb-4">
    <i class="fas fa-circle-info mr-1"></i>
    Backups are stored on this server. <strong>Download one regularly</strong> (e.g. weekly) and keep it on your computer or Google Drive — if the server itself is lost, only an off-server copy can save the data.
</div>

<div class="grid grid-cols-12 gap-5">
    <div class="col-span-12 {{ $canRestore ? 'lg:col-span-8' : '' }}">
        <div class="wp-panel">
            <div class="wp-panel-h">Backups</div>
            <div class="wp-panel-body" style="padding:0">
                <div style="overflow-x:auto">
                <table class="wp-list-table" style="border:0">
                    <thead><tr><th>Date</th><th>Type</th><th class="text-right">Size</th><th class="text-right"></th></tr></thead>
                    <tbody>
                        @forelse ($backups as $b)
                            <tr>
                                <td>
                                    <strong>{{ $b['created_at']->copy()->setTimezone($tz)->format('d M Y, h:i A') }}</strong>
                                    <div class="text-[11px] text-[#646970] font-mono">{{ $b['name'] }}</div>
                                </td>
                                <td class="text-[12px]">{{ $typeLabel[$b['type']] ?? $b['type'] }}</td>
                                <td class="text-right text-[12px]">{{ $size($b['size']) }}</td>
                                <td class="text-right whitespace-nowrap">
                                    <a href="{{ route('admin.backups.download', $b['name']) }}" class="wp-btn" title="Download"><i class="fas fa-download"></i></a>
                                    @if ($canRestore)
                                        <form method="POST" action="{{ route('admin.backups.restore', $b['name']) }}" class="inline" onsubmit="return askRestore(this, '{{ $b['created_at']->copy()->setTimezone($tz)->format('d M Y, h:i A') }}')">
                                            @csrf
                                            <input type="hidden" name="confirm" value="">
                                            <button type="submit" class="wp-btn" title="Restore" style="color:#b45309"><i class="fas fa-clock-rotate-left"></i> Restore</button>
                                        </form>
                                    @endif
                                    @if ($admin->hasPermission('backups.delete'))
                                        <form method="POST" action="{{ route('admin.backups.destroy', $b['name']) }}" class="inline" onsubmit="return confirm('Delete this backup?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="wp-btn" title="Delete" style="color:#b32d2e"><i class="fas fa-trash"></i></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-[#646970] py-10">No backups yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

    @if ($canRestore)
    <div class="col-span-12 lg:col-span-4">
        <div class="wp-panel">
            <div class="wp-panel-h"><span><i class="fas fa-upload mr-1"></i> Restore from a File</span></div>
            <div class="wp-panel-body">
                <form method="POST" action="{{ route('admin.backups.upload') }}" enctype="multipart/form-data" onsubmit="return askRestore(this, 'the uploaded file')">
                    @csrf
                    <input type="hidden" name="confirm" value="">
                    <div class="wp-field">
                        <label>Backup file (.sql.gz)</label>
                        <input type="file" name="backup_file" accept=".gz" class="wp-input" required>
                        <p class="wp-help">A file downloaded from this page earlier.</p>
                    </div>
                    <button type="submit" class="wp-btn w-full" style="color:#b45309"><i class="fas fa-clock-rotate-left mr-1"></i> Upload &amp; Restore</button>
                </form>
                <p class="wp-help mt-3"><strong>Restore replaces all current data</strong> with the backup. A safety backup of the current data is taken first, so a restore can be undone.</p>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
    function askRestore(form, label) {
        const typed = prompt('Restore the database to ' + label + '?\n\nEverything entered after that will be replaced. Type RESTORE to continue.');
        if (typed === null) return false;
        form.querySelector('input[name=confirm]').value = typed.trim();
        return true;
    }
</script>

@endsection
