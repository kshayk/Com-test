<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/form', function () {
//     return view('form');
// });

Route::get('/form', array('uses' => 'ContactController@showForm'));
Route::post('/submit-form', ['uses' => 'ContactController@submitForm']);
