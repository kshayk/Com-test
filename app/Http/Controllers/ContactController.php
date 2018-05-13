<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\CvsToTable;
use App\Contact;

class ContactController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function showForm(Request $request)
    {
        $contact_details = Contact::all();

        return view('form', ['data' => $contact_details]);
    }

    public function submitForm(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|max:50',
            'subject' => 'required|max:255',
            'content' => 'required|max:1000'
        ]);

        if( ! filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)) {
            return response()->json('Failed', 400);
        }

        $random_string = $this->randomString(5);

        //TODO: try catch this
        $file = fopen("/var/www/tmp/csv_{$random_string}.csv", "w+");

        $data_array = [
            ['name', 'email', 'subject', 'content'],
            [$request->input('name'), $request->input('email'), $request->input('subject'), $request->input('content')]
        ];

        //TODO: try catch this
        foreach($data_array as $field) {
            fputcsv($file, $field);
        }

        CvsToTable::dispatch($random_string);

        return response()->json('success', 200);
    }

    public function deleteRecord($id)
    {
        $contact = Contact::where('id', $id)->first();

        if( ! empty($contact)) {
            $contact->delete();
        } else {
            return response()->json("The requested record was not found", 400);
        }

        return response()->json("Deleted the record successfully", 200);
    }

    private function randomString($length = 5)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
