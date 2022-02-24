<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [

        "date",
        "total_price",
        "confirmed",
        "payment_confirmation",
        "confirmation_date",
    ];
}
