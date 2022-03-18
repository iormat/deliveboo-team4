<?php

use Illuminate\Database\Seeder;
use App\Category;

use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $categories = ['Antipasti', 'Primi', 'Secondi', 'Contorni','Dolci', 'Hosomaki', 'Uramaki', 'Temaki', 'Nigiri', 'Sashimi', 'Pollo', 'Pesce e Gamberi', 'Bevande', 'Pizze', 'Pancakes',
                        'Waffles'
    ];


        for($i = 0; $i < count($categories); $i++) {
            DB::table('categories') -> insert([
                ['category_name' => $categories[$i]]
            ]);
        }
    }
}
