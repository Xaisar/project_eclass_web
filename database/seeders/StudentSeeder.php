<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use Carbon\Carbon;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Student::insert([
            [
                'major_id' => 1,
                'uid' => 'a1b2c3d4',
                'identity_number' => '1710110001',
                'name' => 'Ridho Pijak Imana',
                'gender' => 'male',
                'birthplace' => 'Banyuwangi',
                'birthdate' => '2002-01-02',
                'email' => 'ridho@gmail.com',
                'phone_number' => '085635425635',
                'parent_phone_number' => '087635524516',
                'picture' => 'default.png',
                'address' => 'Banyuwangi',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'major_id' => 1,
                'uid' => 'b2c3d4e5',
                'identity_number' => '1710110002',
                'name' => 'Sindy Rahayu',
                'gender' => 'female',
                'birthplace' => 'Malang',
                'birthdate' => '2002-01-08',
                'email' => 'sindy@gmail.com',
                'phone_number' => '085635425635',
                'parent_phone_number' => '087635524516',
                'picture' => 'default.png',
                'address' => 'Rogojampi',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'major_id' => 1,
                'uid' => 'c3d4e5f6',
                'identity_number' => '1710110003',
                'name' => 'Dimas Anggara',
                'gender' => 'male',
                'birthplace' => 'Banyuwangi',
                'birthdate' => '2002-11-01',
                'email' => 'dimas@gmail.com',
                'phone_number' => '085635425635',
                'parent_phone_number' => '087635524516',
                'picture' => 'default.png',
                'address' => 'Songgon',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'major_id' => 2,
                'uid' => 'd4e5f6g7',
                'identity_number' => '1710110004',
                'name' => 'Edy Saputra',
                'gender' => 'male',
                'birthplace' => 'Jember',
                'birthdate' => '2002-09-12',
                'email' => 'edy@gmail.com',
                'phone_number' => '085635425635',
                'parent_phone_number' => '087635524516',
                'picture' => 'default.png',
                'address' => 'Songgon',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'major_id' => 2,
                'uid' => 'e5f6g7h8',
                'identity_number' => '1710110005',
                'name' => 'Niki Lestari',
                'gender' => 'female',
                'birthplace' => 'Banyuwangi',
                'birthdate' => '2002-03-26',
                'email' => 'niki@gmail.com',
                'phone_number' => '085635425635',
                'parent_phone_number' => '087635524516',
                'picture' => 'default.png',
                'address' => 'Blimbingsari',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'major_id' => 3,
                'uid' => 'bc3d4e5f6',
                'identity_number' => '1710110006',
                'name' => 'Riko Darmawan',
                'gender' => 'male',
                'birthplace' => 'jember',
                'birthdate' => '2001-05-27',
                'email' => 'riko@gmail.com',
                'phone_number' => '085635425635',
                'parent_phone_number' => '087635524516',
                'picture' => 'default.png',
                'address' => 'Banyuwangi',
                'status' => true,
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
