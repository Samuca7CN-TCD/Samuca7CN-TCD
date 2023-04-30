<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Buffet;
use App\Models\BuffetPlate;
use App\Models\PlateIngredient;

class PlateIngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 3,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 3,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 3,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 3,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 4,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 4,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 5,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 5,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 5,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 5,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 5,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 6,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 6,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 6,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 7,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 7,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 7,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 7,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 7,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 7,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 7,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 8,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 9,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 9,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 9,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 9,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 9,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 9,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 9,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 9,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 9,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 9,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 10,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 10,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 10,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 10,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 11,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 11,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 12,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 12,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 13,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 14,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 14,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 14,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 14,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 14,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 15,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 15,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 15,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 15,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 16,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 17,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 18,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);
        
        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 19,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 19,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 20,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 21,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 22,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 23,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 24,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 25,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 26,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 27,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 28,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 29,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 30,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 31,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 32,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 33,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 34,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 35,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 36,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 36,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 37,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 37,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 38,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 38,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 39,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 39,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 40,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 40,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 41,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 41,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 42,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 42,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 43,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 43,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 44,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 44,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 45,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 45,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 46,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 46,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 47,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 47,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 48,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        DB::table('plate_ingredients')->insert([
            'name' => 'Ingrediente X',
            'description' => null,
            'quantity' => 5,
            'measure_unity' => 'unidades',
            'cost' => 2.5,
            'buffet_plate_id' => 48,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s') 
        ]);

        $this->calculate_costs();
    }

    private function calculate_costs(){
        $plates = BuffetPlate::all();
        foreach($plates as $plate){
            $cost = PlateIngredient::select(DB::raw('SUM(cost * quantity) AS total_value'))
                ->where('buffet_plate_id', $plate->id)
                ->get();
            $plate->cost = $cost[0]->total_value;
            $plate->save();
        }

        $buffets = Buffet::all();
        foreach($buffets as $buffet){
            $cost = BuffetPlate::select(DB::raw('SUM(cost * qtd_per_ten_people) AS total_value'))
                ->where('buffet_id', $buffet->id)
                ->get();
            $buffet->cost = $cost[0]->total_value;
            $buffet->save();
        }
    }
}
