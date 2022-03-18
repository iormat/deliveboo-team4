<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table -> id();
            $table -> string("business_name");
            $table -> string('name');
            $table -> string('surname');
            $table -> string('email')->unique();
            $table -> timestamp('email_verified_at')->nullable();
            $table -> string('password');
            $table -> string('p_iva') -> unique();
            $table -> string('img_rest') -> nullable();
            $table -> string('img_profile') -> nullable();
            $table -> text('business_description') -> nullable();
            $table -> rememberToken();
            $table -> timestamps();
            $table -> softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
