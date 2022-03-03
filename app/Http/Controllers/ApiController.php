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
    // get all menu
    public function getMenu() {
        $user = Auth::user();
        $menu = Dish::where('user_id', $user -> id) -> get();

        return json_encode($menu);
    }

    // get all dish categories
    public function getCategories()  {
        $categories = Category::all();

        return json_encode($categories);
    }

    // add new dish
    public function addDish(Request $request) {
        // validate required dish data
        $data = $request -> validate ([
            'dish_name' => 'required | string | min:4 | max:50',
            'description' => 'required | string',
            'price' => 'required',
            'ingredients' => 'required | string',      
        ]);
        // validate dish img if present
        if ($request -> file('dishes_img') != '') {
            $imageFile = $request -> file('dishes_img');
            $data['dishes_img'] = $request -> validate([
                'dishes_img' => 'image',      
            ]);
            $data['dishes_img'] = $imageFile;
            // rename and store dish img
            $imageName = rand(100000, 999999) . '_' . time() . '.' . $imageFile -> getClientOriginalExtension();
            $imageFile -> storeAs('/dishes/', $imageName, 'public');
            $data['dishes_img'] = $imageName;
        }
        // default to true dish availability
        $data['available'] = true;

        $dish = Dish::make($data);
        // relate dish to user
        $user = User::findOrFail(Auth::user()->id);
        $dish -> user() -> associate($user);

        // relate dish to category
        $category = Category::findOrFail($request -> get('category'));       
        $dish -> category() -> associate($category);
        $dish -> save();

        return json_encode($dish);
    } 

    // update existing dish
    public function updateDish(Request $request, $id) {
        //  validate required dish data
        $data = $request -> validate([
            'dish_name' => 'required | string | min:4 | max:50',
            'description' => 'required | string',
            'price' => 'required',
            'ingredients' => 'required | string',
            // 'available' => 'boolean'
        ]);
        // validate dish img if present
        if ($request -> file('dishes_img') != '') {
            $imageFile = $request -> file('dishes_img');
            $data['dishes_img'] = $request -> validate([
                'dishes_img' => 'image',      
            ]);
            $data['dishes_img'] = $imageFile;
            // rename and store dish img
            $imageName = rand(100000, 999999) . '_' . time() . '.' . $imageFile -> getClientOriginalExtension();
            $imageFile -> storeAs('/dishes/', $imageName, 'public');
            $data['dishes_img'] = $imageName;
        }
        // dish availability
        // if ($request -> get('available') == true || $request -> get('available') == 1) {
        //     $data['available'] = 1;
        // } else {
        //     $data['available'] = 0;
        // }
        $data['available'] = $request -> get('available');
        // dd($request -> get('available'));


        $dish = Dish::findOrFail($id);
        // relate dish to user
        $user = User::findOrFail(Auth::user()->id);
        $dish -> user() -> associate($user);

        // relate dish to category
        $category = Category::findOrFail($request -> get('category'));       
        $dish -> category() -> associate($category);
        
        $dish -> update($data);

        return json_encode($dish);
    }

    // delete dish
    public function deleteDish($id) {
        $dish = Dish::findOrFail($id);
        $dish -> delete();
        return json_encode($dish);
    }
}
