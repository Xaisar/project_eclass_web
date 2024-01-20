<?php

namespace Database\Seeders;

use App\Models\PresenceToken;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PresenceTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PresenceToken::insert([
            [
                'type' => 'a',
                'token' => Str::random(16),
                'created_at' => Carbon::now()
            ],
            [
                'type' => 'b',
                'token' => Str::random(16),
                'created_at' => Carbon::now()
            ],
        ]);
    }
}
