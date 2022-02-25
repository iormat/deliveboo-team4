<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('type_user', function (Blueprint $table) {
            
            $table -> foreign('type_id', 'type_id_user') -> references('id') -> on('types');
            $table -> foreign('user_id', 'user_id_type') -> references('id') -> on('users');

        });

        Schema::table('dishes', function (Blueprint $table) {
            
            $table -> foreign('user_id', 'dish_id_user') -> references('id') -> on('users');
            $table -> foreign('category_id', 'category_id_dish') -> references('id') -> on('categories');

        });

        Schema::table('dish_order', function (Blueprint $table) {
            
            $table -> foreign('order_id', 'order_id_dish') -> references('id') -> on('orders');
            $table -> foreign('dish_id', 'dish_id_order') -> references('id') -> on('dishes');

        });
        Schema::table('orders', function (Blueprint $table) {
            
            $table -> foreign('customer_id', 'customer_id_order') -> references('id') -> on('customers');

        });

        // Schema::table('type_user', function (Blueprint $table) {
            
        //     $table -> foreign('user_id', 'user_id_type') -> references('id') -> on('users');

        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('type_user', function(Blueprint $table) {
            $table -> dropForeign('type_id_user');
            $table -> dropForeign('user_id_type');

        });
        Schema::table('dishes', function(Blueprint $table) {
            $table -> dropForeign('dish_id_user');
            $table -> dropForeign('category_id_dish');
        });
        Schema::table('dish_order', function(Blueprint $table) {
            $table -> dropForeign('order_id_dish');
            $table -> dropForeign('dish_id_order');
        });
        Schema::table('orders', function(Blueprint $table) {
            $table -> dropForeign('customer_id_order');
        });
    }
}
