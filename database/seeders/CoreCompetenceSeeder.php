<?php

namespace Database\Seeders;

use App\Models\CoreCompetence;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CoreCompetenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CoreCompetence::insert([
            [
                'code' => 3,
                'key' => 'pengetahuan',
                'name' => 'Pengetahuan',
                'created_at' => Carbon::now(),
            ],
            [
                'code' => 4,
                'key' => 'keterampilan',
                'name' => 'Keterampilan',
                'created_at' => Carbon::now(),
            ]
        ]);
    }
}
