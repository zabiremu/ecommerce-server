<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    public function index()
    {
        $notifications = AdminNotification::latest()->limit(30)->get()->map(function ($n) {
            $meta = AdminNotification::meta($n->type);
            return [
                'id'      => $n->id,
                'type'    => $n->type,
                'title'   => $n->title,
                'message' => $n->message,
                'link'    => $n->link,
                'read'    => $n->isRead(),
                'icon'    => $meta['icon'],
                'bg'      => $meta['bg'],
                'fg'      => $meta['fg'],
                'time'    => $n->created_at->diffForHumans(),
            ];
        });

        return response()->json([
            'notifications' => $notifications,
            'unread_count'  => AdminNotification::unread()->count(),
        ]);
    }

    public function markAllRead()
    {
        AdminNotification::unread()->update(['read_at' => now()]);
        return response()->json(['success' => true]);
    }

    public function markRead(AdminNotification $notification)
    {
        $notification->update(['read_at' => now()]);
        return response()->json(['success' => true]);
    }
}
