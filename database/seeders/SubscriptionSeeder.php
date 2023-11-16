<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
            'expiry' => 'lknn',
            'code' => 'code',
            ]);
    }
}
