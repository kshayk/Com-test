<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contact';

    public $timestamps = false;

    public function submitter()
    {
        return $this->belongsTo('App\Submitter', 'email', 'email');
    }
}
