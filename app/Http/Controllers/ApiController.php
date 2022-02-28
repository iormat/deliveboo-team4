<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Dish;
use App\Category;

class ApiController extends Controller
{
    public function getMenu() {
        $user = Auth::user();

        $menu = Dish::where('user_id', $user -> id)
                // -> where('category_id', 'categories.id')        
                -> get();
        // $menu = DB::table('dishes')
        //     -> where('user_id')
        //     -> select('dishes.id', 'dishes.dish_name', 'categories.category_name')
        //     -> join('categories', 'dishes.category_id', '=', 'categories.id')
        //     -> get();
        
        return json_encode($menu);
    }

    public function getCategories()  {
        $categories = Category::all();
        return json_encode($categories);
    }

    public function addDish(Request $request) {
        $data = $request -> validate ([
            'dish_name' => 'required | string | min:4 | max:50',
            'description' => 'required | string',
            'price' => 'required',
            'ingredients' => 'required | string',
        ]);
        $data['user_id'] = Auth::user() -> id;


        return json_encode($data);
    }
}
