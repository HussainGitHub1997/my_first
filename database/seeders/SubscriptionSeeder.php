<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subscription::insert([
            'model_type' => 'App\Models\unit',
            'model_id' => 1,
            'user_id' => 2,
            'note' => 'no note',
            'expire_duration' => 1,
            'code' => 'asdfghjk',
        ]);
        Subscription::insert([
            'model_type' => 'App\Models\unit',
            'model_id' => 2,
            'user_id' => 3,
            'note' => 'no note',
            'expire_duration' => 2,
            'code' => 'qwertyui',
        ]);
        Subscription::insert([
            'model_type' => 'App\Models\subject',
            'model_id' => 3,
            'user_id' => 2,
            'note' => 'no note',
            'expire_duration' => 1,
            'code' => 'zxcvbnm,',
        ]);
        Subscription::insert([
            'model_type' => 'App\Models\subject',
            'model_id' => 4,
            'user_id' => 3,
            'note' => 'no note',
            'expire_duration' => 4,
            'code' => 'qazwsxed',
        ]);
    }
}
