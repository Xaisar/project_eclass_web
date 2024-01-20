<?php

namespace Database\Seeders;

use App\Models\Major;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Major::insert([
            [
                'name' => 'Rekayasa Perangkat Lunak',
                'short_name' => 'RPL',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Teknik Komputer Jaringan',
                'short_name' => 'TKJ',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Teknik Elektronika Industri',
                'short_name' => 'TEI',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Teknik Elektronika',
                'short_name' => 'TE',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Teknik Kendaraan Ringan',
                'short_name' => 'TKR',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Administrasi Perkantoran',
                'short_name' => 'AP',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
