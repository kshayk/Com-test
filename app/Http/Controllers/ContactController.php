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
        print_r($request->all());

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
