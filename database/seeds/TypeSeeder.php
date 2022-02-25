<?php

use Illuminate\Database\Seeder;
use App\Type;
use App\User;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Type::class, 5) -> create() -> each(function($type) {

            $users = User::inRandomOrder() -> limit(rand(1,10)) -> get();
            $type -> users() -> attach($users);

            $type -> save();
        });

    }
}
