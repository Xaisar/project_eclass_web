<?php

namespace Database\Seeders;

use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Shift::create([
            'name' => 'Shift 1',
            'start_entry' => '05:00:00',
            'start_time_entry' => '08:00:00',
            'last_time_entry' => '12:00:00',
            'start_exit' => '14:30:00',
            'start_time_exit' => '15:00:00',
            'last_time_exit' => '17:00:00',
            'created_at' => Carbon::now(),
        ]);
    }
}
