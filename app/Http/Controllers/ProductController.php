<?php

namespace App\Http\Controllers;
use App\Dish;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getDishes() {
        
        $menu = Dish::all();

        return response()-> json($menu);
    }
}
