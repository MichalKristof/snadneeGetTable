<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $restaurants = Restaurant::all('id','capacity');

        $tableCapacities = [2, 4, 8];

        foreach ($restaurants as $restaurant){
            for($i = 1; $i <= $restaurant->capacity; $i++){
                DB::table('tables')->insert([
                    'restaurant_id' => $restaurant->id,
                    'table_number' => $i,
                    'table_capacity' => $tableCapacities[array_rand($tableCapacities)],
                ]);
            }
        }
    }
}
