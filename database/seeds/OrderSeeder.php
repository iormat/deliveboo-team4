<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Order;
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
        factory(Order::class, 2000) -> make() -> each(function($order) {

            $customer = Customer::inRandomOrder() -> limit(1) -> first();
            $order -> customer() -> associate($customer);

            $order -> save();
        });

        for ($i = 1; $i < 2001; $i++) {
            DB::table('dish_order')->insert([
                ['dish_id' => rand(1, 45), 'order_id' => $i, 'amount' => rand(1,5)]
            ]);
        }


    }
}
