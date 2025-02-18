<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function createGuest()
    {
        return view('guest/contactUsGuest');
    }

    public function storeGuest(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'email_address' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        try {
            Contact::create($validatedData);
            return redirect()->route('contact.guestCreate')->with('success', 'Your message has been sent!');
        } catch (\Exception $e) {
            return redirect()->route('contact.guestCreate')->withErrors(['error' => 'Failed to save data: ' . $e->getMessage()]);
        }
    }
    public function storeUser(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'email_address' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        try {
            Contact::create($validatedData);
            return redirect('/contact-us-auth')->with('success', 'Your message has been sent!');
        } catch (\Exception $e) {
            return redirect('/contact-us-auth')->withErrors(['error' => 'Failed to save data: ' . $e->getMessage()]);
        }
    }

    public function deleteContact(Contact $contact){
        $contact -> delete();
        return redirect('/contacts');
    }
}
