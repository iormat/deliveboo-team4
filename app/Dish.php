<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    protected $fillable = [

        "dish_name",
        "description",
        "price",
        "dishes_img",
        "available",
        "ingredients",
    ];

    
    public function user() {
        return $this -> belongsTo(User::class);
    }
    public function category() {
        return $this -> belongsTo(Category::class);
    }
    public function orders() {
        return $this -> belongsToMany(Order::class)
            -> withPivot('amount');
    }
}
