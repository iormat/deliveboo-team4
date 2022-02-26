<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request) {

        $data = $request -> validate ([
            'name' => 'required | string',
            'description' => 'required | string',
            'price' => 'required',
            'dishes-img' => 'required | string',
            'ingredients' => 'required | string',
            'category_id' => 'required | string',
        ]);

        // $comic = comic::create($data);
        // return redirect() -> route('home');
        
    }
    

}
