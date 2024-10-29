<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    // Display a listing of all contact submissions
    public function index()
    {
        // Fetch all contact records
        $allContactInfo = ContactUs::all();

        // Pass the data to the index view
        return view('admin.contact_us.index', compact('allContactInfo'));
    }

    // Show the form for creating a new contact submission
    public function create()
    {
        //return view('admin.contact_us');
        return view('admin.contact_us.create'); // Return the view for the contact form
    }

    // Store a new contact submission
    public function store(Request $request)
    {

        // Validate the request data
        $request->validate([
            'company_name' => 'required|max:255',
            'company_address' => 'required',
            'company_phone_number' => 'required|max:15',
            'company_email' => 'required|email',
        ]);

        //Fetch all records again to pass to the index view
        $allContactInfo = ContactUs::all();
        // Create a new ContactUs record
        $contactUs = new ContactUs();
        $contactUs->company_name = $request->company_name;
        $contactUs->company_address = $request->company_address;
        $contactUs->company_phone_number = $request->company_phone_number;
        $contactUs->company_email = $request->company_email;

        // Save the record to the database
        $contactUs->save();

        return view('admin.contact_us.create', compact('allContactInfo'))->with('success', 'Contact added successfully.');
        // // Redirect back to the form with a success message
        // return redirect()->route('admin.contact_us.create')->with('success', 'Contact information saved successfully!');
    }

    // Show a specific contact submission
    public function show($id)
    {
        $contact = ContactUs::findOrFail($id);
        return view('admin.contact_us.show', compact('contact'));
    }

    // Show the form for editing a specific contact submission
    public function edit($id)
    {
        // Retrieve the contact info from the database using the provided id
        $contactInfo = ContactUs::findOrFail($id);

        // Pass the retrieved data to the view
        return view('admin.contact_us.edit', compact('contactInfo'))->with('success', 'You have successfully Updated');
    }

    // Update the specified contact submission
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'company_name' => 'required|max:255',
            'company_address' => 'required',
            'company_phone_number' => 'required|max:15',
            'company_email' => 'required|email',
        ]);

        // Find the contact_us record by id
        $contactInfo = ContactUs::findOrFail($id);

        // Update the record with new data
        $contactInfo->update([
            'company_name' => $request->input('company_name'),
            'company_address' => $request->input('company_address'),
            'company_phone_number' => $request->input('company_phone_number'),
            'company_email' => $request->input('company_email'),
        ]);

        // Fetch all records again to pass to the index view
        $allContactInfo = ContactUs::all();

        // Redirect to index view with updated data
        return view('admin.contact_us.index', compact('allContactInfo'))->with('success', 'Contact information updated successfully.');
    }

    // Delete the specified contact submission
    public function destroy($id)
    {
        $contact = ContactUs::findOrFail($id);
        $contact->delete();

        // Redirect with a success message
        return redirect()->route('admin.contact_us.index')->with('success', 'Contact deleted successfully.');
    }
}
