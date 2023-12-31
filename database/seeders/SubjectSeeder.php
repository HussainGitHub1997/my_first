<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subject::insert([
            'name' => 'doctor',
            'unit_id' => 1,
            'description' => 'unit one day',
        ]);

        Subject::insert([
            'name' => 'engineer',
            'unit_id' => 2,
            'description' => 'no,des',
        ]);
        Subject::insert([
            'name' => 'teacher',
            'unit_id' => 3,
            'description' => 'no,des',
        ]);
    }
}
