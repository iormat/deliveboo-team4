<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    public $timestamps = false;
    protected $fillable = [

        "category_name",
    ];
    public function dishes() {
        return $this -> hasMany(Dish::class);
    }
}
