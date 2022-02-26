<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function home() {
        return view('pages.homepage');
    }

    public function loginRegister() {
        return view('pages.login-register');
    }
}
