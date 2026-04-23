<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::latest()->paginate(10);
        return view('admin.contacts', compact('contacts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|unique:contacts',
            'role' => 'required|string'
        ]);

        // Pastikan format nomor HP berawalan 62 untuk WhatsApp Gateway nanti
        $phone = $request->phone_number;
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        Contact::create([
            'name' => $request->name,
            'phone_number' => $phone,
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', 'Kontak berhasil ditambahkan!');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->back()->with('success', 'Kontak berhasil dihapus!');
    }
}