<?php

use Illuminate\Database\Seeder;
use App\Dish;
use App\User;
use App\Category;

class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Dish::class, 25) -> make() -> each(function($dish) {

            $user = User::inRandomOrder() -> limit(1) -> first();
            $dish -> user() -> associate($user);


            $category = Category::inRandomOrder() -> limit(1) -> first();
            $dish -> category() -> associate($category);

            $dish -> save();
        });
            

  

    }
}
