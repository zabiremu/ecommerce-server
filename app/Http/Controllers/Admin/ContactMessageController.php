<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');
        $search = trim((string) $request->query('s', ''));

        $query = ContactMessage::query()->latest('id');

        if (in_array($status, ContactMessage::STATUSES, true)) {
            $query->where('status', $status);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $messages = $query->paginate(20)->withQueryString();

        $counts = [
            'all'      => ContactMessage::count(),
            'new'      => ContactMessage::where('status', 'new')->count(),
            'read'     => ContactMessage::where('status', 'read')->count(),
            'replied'  => ContactMessage::where('status', 'replied')->count(),
            'archived' => ContactMessage::where('status', 'archived')->count(),
        ];

        return view('Admin.contact_messages.index', compact('messages', 'counts', 'status', 'search'));
    }

    public function show(ContactMessage $contactMessage)
    {
        if ($contactMessage->status === 'new') {
            $contactMessage->update([
                'status'  => 'read',
                'read_at' => now(),
            ]);
        }
        return view('Admin.contact_messages.show', ['msg' => $contactMessage]);
    }

    public function updateStatus(Request $request, ContactMessage $contactMessage)
    {
        $data = $request->validate([
            'status' => 'required|in:' . implode(',', ContactMessage::STATUSES),
        ]);

        $contactMessage->update([
            'status'  => $data['status'],
            'read_at' => $contactMessage->read_at ?: ($data['status'] !== 'new' ? now() : null),
        ]);

        return back()->with('success', 'Status updated.');
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        return redirect()->route('admin.contact-messages.index')->with('success', 'Message deleted.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:read,replied,archived,delete',
            'ids'    => 'required|array|min:1',
            'ids.*'  => 'integer|exists:contact_messages,id',
        ]);

        $ids = $request->ids;
        if ($request->action === 'delete') {
            ContactMessage::whereIn('id', $ids)->delete();
            return back()->with('success', count($ids) . ' message(s) deleted.');
        }

        ContactMessage::whereIn('id', $ids)->update([
            'status'  => $request->action,
            'read_at' => now(),
        ]);
        return back()->with('success', count($ids) . ' message(s) marked as ' . $request->action . '.');
    }
}
