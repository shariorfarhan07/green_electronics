<?php

namespace App\Http\Controllers;

use App\ContactMessage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function show()
    {
        return Inertia::render('Contact');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:190',
            'subject' => 'required|string|max:190',
            'message' => 'required|string|max:5000',
        ]);

        $ip = $request->ip();

        // Two messages per IP per rolling 24 hours. Counted against the stored rows
        // rather than the cache so the limit survives a cache clear.
        if (ContactMessage::sentFromIpToday($ip) >= ContactMessage::DAILY_LIMIT) {
            return back()
                ->withInput()
                ->withErrors(['message' => 'You have already sent '.ContactMessage::DAILY_LIMIT.' messages today. Please try again tomorrow, or call us if it is urgent.']);
        }

        ContactMessage::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
            'ip_address' => $ip,
        ]);

        return back()->withsuccess('Thanks for getting in touch — we will reply as soon as we can.');
    }
}
