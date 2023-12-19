<?php

namespace Database\Seeders;

use App\Models\Subscription;
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
        Subscription::insert([
            'model_type' => 'App\Models\unit',
            'model_id' => 3,
            'user_id' => 1,
            'note' => 'no note',
            'expire_duration' => 1,
            'code' => 'code',
        ]);
        Subscription::insert([
            'model_type' => 'App\Models\unit',
            'model_id' => 2,
            'user_id' => 2,
            'note' => 'no note',
            'expire_duration' => 1,
            'code' => 'nocode',
        ]);
        Subscription::insert([
            'model_type' => 'App\Models\subject',
            'model_id' => 3,
            'user_id' => 1,
            'note' => 'no note',
            'expire_duration' => 1,
            'code' => 'ddcode',
        ]);
        Subscription::insert([
            'model_type' => 'App\Models\subject',
            'model_id' => 4,
            'user_id' => 2,
            'note' => 'no note',
            'expire_duration' => 30,
            'code' => 'ddcode',
        ]);
    }
}
