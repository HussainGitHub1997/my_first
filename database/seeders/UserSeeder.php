<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::insert([
            'name' => 'hussain',
            'password' => Hash::make('12345678'),
            'phone_number' => '0956978759',
            'device_id' => 1,
            'role' => 'admin',
        ]);
        User::insert([
            'name' => 'admad',
            'password' => Hash::make('12345678'),
            'phone_number' => '0933626606',
            'device_id' => 2,
            'role' => 'client',
        ]);
        User::insert([
            'name' => 'adel',
            'password' => Hash::make('12345678'),
            'phone_number' => '0996585332',
            'device_id' => 3,
            'role' => 'client',
        ]);
    }
}
