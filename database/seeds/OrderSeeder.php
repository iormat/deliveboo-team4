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
        factory(Order::class, 300) -> make() -> each(function($order) {

            $customer = Customer::inRandomOrder() -> limit(1) -> first();
            $order -> customer() -> associate($customer);

            $order -> save();
        });

        for ($i = 0; $i < 100; $i++) {
            DB::table('dish_order')->insert([
                ['dish_id' => rand(1, 10), 'order_id' => rand(1, 300)]
            ]);
        }


    }
}
