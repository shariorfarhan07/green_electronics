<?php

namespace App\Http\Controllers\Admin;

use App\ContactMessage;
use App\Http\Controllers\Controller;

class AdminMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(20);

        return view('admin.messages', [
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

        return view('admin.messageDetail', ['message' => $message]);
    }

    public function destroy($id)
    {
        ContactMessage::findOrFail($id)->delete();

        return redirect()->route('admin.messages.index')->withsuccess('Message deleted.');
    }
}
