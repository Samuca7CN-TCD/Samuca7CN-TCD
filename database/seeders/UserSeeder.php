<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
            'name' => 'Samuel',
            'surname' => 'Correia Nascimento',
            'username' => 'Samuca7CN',
            'email' => 'samuca.7cn@gmail.com',
            'profile_photo' => base64_encode(file_get_contents('/storage/app/public/profile_photo/default.png')),
            'password' => Hash::make('Lms1928$&chicagoeventos'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'name' => 'Villy',
            'surname' => 'Capozzi',
            'username' => 'Villy',
            'email' => 'vilycapozzi@gmail.com',
            'profile_photo' => base64_encode(file_get_contents('storage/app/public/profile_photo/default.png')),
            'password' => Hash::make('Liz0420*'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'name' => 'Leile',
            'surname' => 'Castellazzo',
            'username' => 'Leile',
            'email' => 'chicagoeventos2021@gmail.com',
            'profile_photo' => base64_encode(file_get_contents('storage/app/public/profile_photo/default.png')),
            'password' => Hash::make('Liz0420*'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
