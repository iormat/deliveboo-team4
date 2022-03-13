<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Dish;
use App\Category;
use App\User;
use App\Type;

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

    // retrive restaurant menu for guests
    public function getRestaurantMenu($id) {
        $menu = Dish::where('user_id', $id) -> get();

        return json_encode($menu);
    }

    // checkout
    public function checkout() {
        return view('pages.cart-checkout');
    }

    // public function guestRestautanMenu($id) {
    //     $restaurant = User::findOrFail($id);
    //     return response() -> json($restaurant);
    // }

    public function getTypes() {
        $types = Type::All();
        return response() -> json($types);
    }

    // get user chosen restaurants types
    public function chosenRestaurants(Request $request) {
        
        $type = key($request->all());

        $restaurant = DB::table('users')
                ->select('users.*')
                ->join('type_user', 'users.id', '=', 'type_user.user_id')
                ->join('types', 'type_user.type_id', '=', 'types.id')
                ->where('types.type_name', $type)
                ->get();
        return response() -> json($restaurant);
    }

    // get fav restaurants
    public function favRestaurants() {
        $restaurants = User::inRandomOrder() -> limit(4) -> get();
        return response() -> json($restaurants);
    }

    public function allRestaurants() {
        
        $restaurants = User::with('types')
                           ->orderBy('business_name', 'asc')
                           ->get();
                           
        return response() -> json($restaurants);
    }

    public function restaurants(){
        return view('pages.restaurants');
    }
}
