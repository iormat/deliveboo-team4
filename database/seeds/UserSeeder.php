<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Type;
use App\Dish;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 10) -> create();
    //     -> each(function($user) {

    //         $types = Type::inRandomOrder() -> limit(rand(1,5)) -> get();
    //         $user -> types() -> attach($types);

    //         $user -> save();  
    //     });
    }

    
}
