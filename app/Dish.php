<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    protected $fillable = [

        "name",
        "description",
        "price",
        "dishes_img",
        "available",
        "ingredients",
    ];
    public function user() {
        return $this -> belongsTo(User::class);
    }
}
