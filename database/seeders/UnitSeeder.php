<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unit::insert([
            'name' => 'doctor',
            'description' => 'no description',
        ]);

        Unit::insert([
            'name' => 'engineer',
            'description' => 'description',
        ]);

        Unit::insert([
            'name' => 'teacher',
            'description' => 'nodescription',
        ]);
    }
}
