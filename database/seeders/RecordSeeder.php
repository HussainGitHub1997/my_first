<?php

namespace Database\Seeders;

use App\Models\Record;
use Illuminate\Database\Seeder;

class RecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Record::insert([
            'name' => 'record1',
            'section_id' => 1,
            'description' => 'description',
            'is_free' => true,
            'path' => 'www.hussain.com'
        ]);

        Record::insert([
            'name' => 'record2',
            'section_id' => 2,
            'description' => 'description 2',
            'is_free' => false,
            'path' => 'www.hussain.com'
        ]);

        Record::insert([
            'name' => 'record3',
            'section_id' => 3,
            'description' => 'description 3',
            'is_free' => false,
            'path' => 'www.hussain.com'
        ]);
    }
}
