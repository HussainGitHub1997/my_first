<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
        'name' =>'hussain' ,
        'password' => Hash::make('password'),
        'user_name'=> 'adoAli',
        'phone_number' => '0956978759',
        'device_id' => 1,
        'role' => 'admin',
        ]);
        DB::table('users')->insert([
            'name' =>'admad' ,
            'password' => Hash::make('password'),
            'phone_number' => '0991965818',
            'device_id' => 2,
            'role' => 'custmer',
            'user_name' => 'ahmad',
            ]);
    }
}
