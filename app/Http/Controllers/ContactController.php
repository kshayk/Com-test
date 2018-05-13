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
    }
}
