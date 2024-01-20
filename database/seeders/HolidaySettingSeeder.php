<?php

namespace Database\Seeders;

use App\Models\HolidaySetting;
use Illuminate\Database\Seeder;

class HolidaySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HolidaySetting::create([
            'day_1' => 'Sunday'
        ]);
    }
}
