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
        factory(Order::class, 100) -> make() -> each(function($order) {
            // link customers to orders
            $customer = Customer::inRandomOrder() -> limit(1) -> first();
            $order -> customer() -> associate($customer);
            $order -> save();

            // link dishes to order
            $dishes = Dish::where('user_id', rand(1, 5)) -> limit(rand(1, 50)) -> get();
            $order -> dishes() -> attach($dishes);
            $order -> update(); 

            // get amount value
            foreach ($dishes as $dish) {
                DB::table('dish_order') 
                    -> where('dish_order.dish_id', $dish -> id)
                    -> update([
                        'amount' => rand(1, 5)
                    ]);
            };

            // get real total price based on dishes
            $totalPrice = DB::table('orders')
                -> join('dish_order', 'orders.id', 'dish_order.order_id')
                -> join('dishes', 'dish_order.dish_id', 'dishes.id')
                -> groupBy('orders.id')
                -> where('dish_order.order_id', $order -> id)
                -> sum('dishes.price', '*', 'dish_order.amount');
            // save total
            $order['total_price'] = $totalPrice; 

            $order -> update();
        });
    }
}
