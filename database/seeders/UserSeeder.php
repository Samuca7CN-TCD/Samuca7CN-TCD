<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Samuel Correia Nascimento',
            'username' => 'Samuca7CN',
            'email' => 'samuca.7cn@gmail.com',
            'password' => Hash::make('Lms1928$&chicagoeventos'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
