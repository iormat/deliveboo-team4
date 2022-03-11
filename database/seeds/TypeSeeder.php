<?php

use Illuminate\Database\Seeder;
use App\Type;
use App\User;
use Illuminate\Support\Facades\DB;


class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Type::class, 5) -> create();
        
        for($i = 0; $i < 10; $i++) {
            DB::table('type_user') -> insert([
                ['type_id' => rand(1,5), 'user_id' => rand(1,5)]
            ]);
        }

        //  -> each(function($type) {

        //     $users = User::inRandomOrder() -> limit(rand(1,10)) -> get();
        //     $type -> users() -> attach($users);

        //     $type -> save();
        // });
            
    }
}


