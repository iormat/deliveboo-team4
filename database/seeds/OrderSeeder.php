<?php

use Illuminate\Database\Seeder;
use App\Order;
use App\Dish;
use App\Customer;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Order::class, 10) -> make() -> each(function($order) {

            $customer = Customer::inRandomOrder() -> limit(1) -> first();
            $order -> customer() -> associate($customer);

            $order -> save();
        });

        for ($i = 0; $i < 10; $i++) {
            DB::table('dish_order')->insert([
                ['dish_id' => rand(1, 10), 'order_id' => rand(1, 10), 'amount' => rand(1,10)]
            ]);
        }


    }
}
