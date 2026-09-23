<?php

namespace App\Http\Controllers\Admin;

use App\ContactMessage;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class AdminMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(20);

        return Inertia::render('Admin/Messages', [
            'messages' => $messages,
            'unreadCount' => ContactMessage::unread()->count(),
        ]);
    }

    public function show($id)
    {
        $message = ContactMessage::findOrFail($id);

        // Assigned directly rather than mass-assigned: read_at is never user input,
        // so it is deliberately kept out of the model's $fillable.
        if ($message->isUnread()) {
            $message->read_at = now();
            $message->save();
        }

        return Inertia::render('Admin/MessageDetail', ['message' => $message]);
    }

    public function destroy($id)
    {
        ContactMessage::findOrFail($id)->delete();

        return redirect()->route('admin.messages.index')->withsuccess('Message deleted.');
    }
}
