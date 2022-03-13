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
        // factory(Type::class, 5) -> create();
        
        $types = ['Cinese', 'Giapponese', 'Italiano', 'Gelato','Pizza',];
        
        for($i = 0; $i < count($types); $i++) {
            DB::table('types') -> insert([
                ['type_name' => $types[$i]]
            ]);
        }

        for($i = 1; $i < 6; $i++) {
            DB::table('type_user') -> insert([
                ['type_id' => $i, 'user_id' => $i]
            ]);
        }
    }
}
