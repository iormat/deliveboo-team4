<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dishes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("user_id") ->unsigned();
            $table->bigInteger('category_id') -> unsigned();
            $table->string("name", 50);
            $table->text("description") -> nullable();
            $table->decimal("price", 5,2) -> unsigned();
            $table->string("dishes_img");
            $table->boolean("available");
            $table->text("ingredients");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dishes');
    }
}
