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
        $restaurants = Restaurant::all('id');

        foreach ($restaurants as $key => $restaurantId){
            $number_of_tables = rand(5, 10);

            for($i = 1; $i <= $number_of_tables; $i++){
                DB::table('tables')->insert([
                    'restaurant_id' => $restaurantId->id,
                    'table_number' => $i,
                    'capacity' => 2,
                ]);
            }
        }
    }
}
