<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $fillable = [
        "date",
        "total_price",
        "confirmed",
        "payment_confirmation",
        "confirmation_date",
    ];

    public function dishes() {
        return $this -> belongsToMany(Dish::class)
            -> withPivot('amount');
    }

    public function customer() {
        return $this -> belongsTo(Customer::class);
    }

    public function getCreatedAtFormattedAttribute() {
        return $this-> created_at -> format('H:i d, G M Y');
    }
}
