<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

        return view('form');
    }

    public function submitForm(Request $request)
    {
        print_r($request->all());

        $random_string = $this->randomString(5);

        //TODO: try catch this
        $file = fopen("/var/tmp/csv_{$random_string}.csv", "r+");

        $data_array = [
            ['name', 'email', 'subject', 'content'],
            [$request->input('name'), $request->input('email'), $request->input('subject'), $request->input('content')]
        ];

        //TODO: try catch this
        fputcsv($file ,$data_array);

        return response()->json('success', [], 200);
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
