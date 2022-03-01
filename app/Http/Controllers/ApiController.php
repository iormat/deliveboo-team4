<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Dish;
use App\Category;
use App\User;

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

    // public function saveImg(Request $request) {

    //     global $imageName;

    //     $data = $request -> validate ([
    //         'dishes_img' => 'required | image',
    //     ]);

    //     $imageFile = $request -> file('dishes_img');

    //     $imageName = rand(100000, 999999) . '_' . time() . '.' . $imageFile -> getClientOriginalExtension();

    //     $imageFile -> storeAs('/dishes/', $imageName, 'public');
    //     $data['dishes_img'] = $imageName;    

    //     return json_encode($data);
    // }


    public function addDish(Request $request) {

        global $imageName;

        $data = $request -> validate ([
            'dish_name' => 'required | string | min:4 | max:50',
            'description' => 'required | string',
            'price' => 'required',
            'ingredients' => 'required | string',      
            'dishes_img' => 'required',      
        ]);
        
        $data['available'] = true;

        $imageFile = $request -> file('dishes_img');

        $data['dishes_img'] = $imageFile;
        


        $imageName = rand(100000, 999999) . '_' . time() . '.' . $imageFile -> getClientOriginalExtension();

        $imageFile -> storeAs('/dishes/', $imageName, 'public');
        $data['dishes_img'] = $imageName;

        $dish = Dish::make($data);

        $user = User::findOrFail(Auth::user()->id);
        $dish -> user() -> associate($user);
        $dish -> save();
    
        $category = Category::findOrFail($request -> get('category'));
        
        $dish -> category() -> associate($category);
        $dish -> save();

        return json_encode($dish);

    }

   
    
}
