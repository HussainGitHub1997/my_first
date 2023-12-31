<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Section::insert([
            'subject_id' => 1,
            'description' => 'description one',
            'name' => 'one',
        ]);
        Section::insert([
            'subject_id' => 2,
            'description' => 'description 2',
            'name' => 'two',
        ]);
        Section::insert([
            'subject_id' => 3,
            'description' => 'description 3',
            'name' => 'three',
        ]);
    }
}
