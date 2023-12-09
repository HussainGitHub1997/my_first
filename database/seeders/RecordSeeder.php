<?php

namespace Database\Seeders;

use App\Models\Record;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Record::insert([
            'name' =>'record1' ,
            'section_id' => 1,
            'description' => 'dszf',
            'is_subscribed' => true,
            'expired_at' => now(),
            'is_free'=> true,
            'path'=>'www.hussain.com'
            ]);
    }
}
