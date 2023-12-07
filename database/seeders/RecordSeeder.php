<?php

namespace Database\Seeders;

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
        DB::table('records')->insert([
            'name' =>'record1' ,
            'section_id' => 1,
            'description' => 'dszf',
            'is_subscribed' => true,
            'expries_at' => now(),
            'is_free'=> true,
            'url'=>'www.hussain.com'
            ]);
    }
}
