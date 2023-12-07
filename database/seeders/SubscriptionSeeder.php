<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subscriptions')->insert([
            'model_type' =>1 ,
            'model_id' => 3,
            'user_id' => 1,
            'note' => 'no note',
            'expire_duration' => 1,
            'code' => 'code',
            'started_at'=>now(),
            ]);
    }
}
