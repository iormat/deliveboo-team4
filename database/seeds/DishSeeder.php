<?php

use Illuminate\Database\Seeder;
use App\Dish;
use App\User;
use App\Category;
use App\Order;

class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Dish::class, 50) -> make() -> each(function($dish) {
            // link user to dishes
            $user = User::inRandomOrder() -> limit(1) -> first();
            $dish -> user() -> associate($user);
            // link category to dishes
            $category = Category::inRandomOrder() -> limit(1) -> first();
            $dish -> category() -> associate($category);
            // link orders to dishes
            $orders = Order::inRandomOrder() -> limit(rand(1, 10)) -> get();
            $dish -> orders() -> attach($orders);

            $dish -> save();
        });
            

  

    }
}
