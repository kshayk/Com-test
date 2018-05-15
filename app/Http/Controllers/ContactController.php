<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\CvsToTable;
use App\Contact;
use App\Submitter;
use Illuminate\Support\Facades\Log;

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
        //get all the contact tickets and show them on the main page
        $contact_details = Contact::with('submitter')->get();

        print_r($contact_details);

        return view('form', ['data' => $contact_details]);
    }

    public function submitForm(Request $request)
    {
        $form_data = $request->all();

        //laravel validator
        $validatedData = $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|max:50',
            'subject' => 'required|max:255',
            'content' => 'required|max:1000'
        ]);

        //Email validator
        if( ! filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
            return response()->json('Failed', 400);
        }

        $random_string = $this->randomString(5);

        //check if user with that email exists. if not, create one.
        $user = Submitter::firstOrNew(['email' => $form_data['email']]);
        $user->email = $form_data['email'];
        $user->save();

        //create new file that the data will be inserted to
        try {
            $file = fopen("/var/www/tmp/csv_{$random_string}.csv", "w+");
        } catch(\Exception $e) {
            Log::info('Failed to create a new CSV file. Error: ' . $e->getMesaage());
            return response()->json('Failed', 400);
        }

        //creating the data structure to be inserted into the CSV file
        $data_array = [
            ['name', 'email', 'subject', 'content'],
            [$form_data['name'], $form_data['email'], $form_data['subject'], $form_data['content']]
        ];

        //inserting the data into the CSV file
        foreach($data_array as $field) {
            try {
                fputcsv($file, $field);
            } catch(\Exception $e) {
                Log::info('Failed to insert data into the CSV file. Error: ' . $e->getMesaage());
                return response()->json('Failed', 400);
            }
        }

        //Adding a new job to the queue.
        //this job will insert the data inside the CSV file to the database
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
