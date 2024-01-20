<?php

namespace Database\Seeders;

use App\Models\ClassGroup;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ClassGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClassGroup::insert([
            [
                'degree_id' => 1,
                'major_id' => 1,
                'code' => 'RPL-A10',
                'name' => 'RPL-A',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'degree_id' => 1,
                'major_id' => 1,
                'code' => 'RPL-B10',
                'name' => 'RPL-B',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'degree_id' => 2,
                'major_id' => 1,
                'code' => 'RPL-A11',
                'name' => 'RPL-A',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'degree_id' => 3,
                'major_id' => 1,
                'code' => 'RPL-A12',
                'name' => 'RPL-A',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'degree_id' => 1,
                'major_id' => 2,
                'code' => 'TKJ-A10',
                'name' => 'TKJ-A',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'degree_id' => 2,
                'major_id' => 2,
                'code' => 'TKJ-A11',
                'name' => 'TKJ-A',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'degree_id' => 2,
                'major_id' => 2,
                'code' => 'TKJ-B11',
                'name' => 'TKJ-B',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'degree_id' => 3,
                'major_id' => 2,
                'code' => 'TKJ-A12',
                'name' => 'TKJ-A',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'degree_id' => 1,
                'major_id' => 3,
                'code' => 'TEI-A10',
                'name' => 'TEI-A',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'degree_id' => 2,
                'major_id' => 3,
                'code' => 'TEI-A11',
                'name' => 'TEI-A',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'degree_id' => 3,
                'major_id' => 3,
                'code' => 'TEI-A12',
                'name' => 'TEI-A',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'degree_id' => 1,
                'major_id' => 4,
                'code' => 'TE-A10',
                'name' => 'TE-A',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'degree_id' => 2,
                'major_id' => 4,
                'code' => 'TE-A11',
                'name' => 'TE-A',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'degree_id' => 3,
                'major_id' => 4,
                'code' => 'TE-A12',
                'name' => 'TE-A',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'degree_id' => 1,
                'major_id' => 5,
                'code' => 'TKR-A10',
                'name' => 'TKR-A',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'degree_id' => 2,
                'major_id' => 5,
                'code' => 'TKR-A11',
                'name' => 'TKR-A',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'degree_id' => 3,
                'major_id' => 5,
                'code' => 'TKR-A12',
                'name' => 'TKR-A',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'degree_id' => 1,
                'major_id' => 6,
                'code' => 'AP-A10',
                'name' => 'AP-A',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'degree_id' => 2,
                'major_id' => 6,
                'code' => 'AP-A11',
                'name' => 'AP-A',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'degree_id' => 3,
                'major_id' => 6,
                'code' => 'AP-A12',
                'name' => 'AP-A',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
