<?php

namespace Database\Seeders;

use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subject::insert([
            [
                'major_id' => null,
                'degree_id' => null,
                'code' => 'MPL001',
                'name' => 'Bahasa Indonesia',
                'grade' => 75,
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'major_id' => null,
                'degree_id' => null,
                'code' => 'MPL002',
                'name' => 'Bahasa Inggris',
                'grade' => 75,
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'major_id' => null,
                'degree_id' => null,
                'code' => 'MPL003',
                'name' => 'Matematika',
                'grade' => 75,
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'major_id' => null,
                'degree_id' => null,
                'code' => 'MPL004',
                'name' => 'Seni Budaya',
                'grade' => 75,
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'major_id' => null,
                'degree' => null,
                'code' => 'MPL005',
                'name' => 'Pendidikan Agama',
                'grade' => 75,
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'major_id' => null,
                'degree' => null,
                'code' => 'MPL006',
                'name' => 'Pendidikan Kewarganegaraan',
                'grade' => 75,
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'major_id' => 1,
                'degree' => 1,
                'code' => 'MPL007',
                'name' => 'Pemrograman Dasar',
                'grade' => 80,
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'major_id' => 1,
                'degree' => 1,
                'code' => 'MPL009',
                'name' => 'Sistem Komputer',
                'grade' => 80,
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'major_id' => 1,
                'degree' => 2,
                'code' => 'MPL010',
                'name' => 'Database',
                'grade' => 80,
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'major_id' => 2,
                'degree' => 1,
                'code' => 'MPL011',
                'name' => 'Komputer dan Jaringan Dasar',
                'grade' => 80,
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'major_id' => 2,
                'degree' => 3,
                'code' => 'MPL012',
                'name' => 'Administrasi Infrastruktur Jaringan',
                'grade' => 80,
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'major_id' => 2,
                'degree_id' => 3,
                'code' => 'MPL013',
                'name' => 'Teknologi Layanan Jaringan',
                'grade' => 80,
                'status' => true,
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
