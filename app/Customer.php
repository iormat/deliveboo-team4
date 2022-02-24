<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        
        "name",
        "surname",
        "address",
        "note",
        "cap",
        "telephone",
    ];
}
