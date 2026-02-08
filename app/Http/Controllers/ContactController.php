<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        // Here you can:
        // 1. Send email to admin
        // 2. Save to database
        // 3. Send confirmation email to user

        // For now, we'll just log it and redirect with success
        // In a real scenario, you'd send an email like:
        // Mail::to(config('mail.from.address'))
        //     ->send(new ContactFormMail($validated));

        return redirect()->route('contact')
            ->with('success', 'Thank you for your message! We\'ll get back to you soon.');
    }
}
