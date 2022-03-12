<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Dish;
use App\Order;
use Illuminate\Support\Facades\DB;


class GuestController extends Controller
{
    public function home() {
        $restaurants = User::with('types') -> get();
        return view('pages.homepage', compact('restaurants'));
    }

    public function loginRegister() {
        return view('pages.login-register');
    }

    public function register() {
        return view('pages.register');
    }

    public function getRestaurant($id) {
        $user = User::findOrFail($id);

        return view('pages.restaurant-menu', compact('user'));
    }

    public function menu(){
        return view('pages.dashboard');
    }


    // test 
    public function test() {
        // $orders = DB::table('orders')
        //     -> select('orders.id as ordini_id', 'dishes.*')
        //     -> join('dish_order', 'orders.id', '=', 'dish_order.order_id')
        //     -> join('dishes', 'dish_order.dish_id', '=', 'dishes.id')
        //     // -> where('dishes.user_id', 1)
        //     -> where('orders.id', 304)
        //     -> groupBy('ordini_id')
        //     -> get();
        
        $orders = Order::with('dishes')
            -> where('orders.id', 304)
            -> whereHas('dishes', function($query) {
                $query->where('user_id', '=', 1);
            })
            -> get();

        return response() -> json($orders);

    }
}
