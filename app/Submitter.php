<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submitter extends Model
{
    protected $fillable = [
        'email'
    ];

    protected $table = 'submitters';

    public $timestamps = false;

    public function contact()
    {
        return $this->hasMany('App\contact', 'email', 'email');
    }
}
