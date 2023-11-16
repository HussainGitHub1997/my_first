<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('records')->insert([
            'name' =>'ggtt' ,
            'subject_id' => 1,
            'description' => 'dszf',
            'is_subscribed' => true,
            'expries_at' => 'today',
            'is_free'=> true,
            ]);
    }
}
