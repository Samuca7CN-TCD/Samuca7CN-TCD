<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            'name' => 'Eperando',
            'code' => 'waiting',
            'color' => 'yellow',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('tags')->insert([
            'name' => 'Fazer logo',
            'code' => 'do_soon',
            'color' => 'orange',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('tags')->insert([
            'name' => 'Urgente',
            'code' => 'urgent',
            'color' => 'red',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
