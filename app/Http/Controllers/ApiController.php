<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Dish;
use App\Category;

class ApiController extends Controller
{
    public function getMenu() {
        $user = Auth::user();
        $menu = Dish::where('user_id', $user -> id) -> get();
        
        return json_encode($menu);
    }

    public function getCategories()  {
        $categories = Category::all();
        return json_encode($categories);
    }
}
