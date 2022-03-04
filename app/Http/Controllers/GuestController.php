<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Dish;

class GuestController extends Controller
{
    public function home() {
        $restaurants = User::all();

        return view('pages.homepage', compact('restaurants'));
    }

    public function loginRegister() {
        return view('pages.login-register');
    }

    public function getRestaurant($id) {
        $user = User::findOrFail($id);

        return view('pages.restaurant-menu', compact('user'));
    }

}
