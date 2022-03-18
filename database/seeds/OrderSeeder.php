<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Order;
use App\Customer;
use App\Dish;

class OrderSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        factory(Order::class, 10) -> make() -> each(function($order) {
            // link customers to orders
            $customer = Customer::inRandomOrder() -> limit(1) -> first();
            $order -> customer() -> associate($customer);

            $order -> save();

            // link dishes to order
            $dishes = Dish::where('user_id', rand(1, 5)) -> limit(rand(1, 20)) -> get();
            $order -> dishes() -> attach($dishes);
            $order -> save(); 

            // // get amount value
            DB::table('dish_order') -> update([
                'amount' => rand(1, 4)
            ]);            
        });
    }
}
