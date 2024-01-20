<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Teacher::insert([
            [
                'position_id' => 1,
                'identity_number' => '190302123456789',
                'name' => 'Suyono, S.Kom',
                'gender' => 'male',
                'phone_number' => '085673637261',
                'email' => 'suyono@gmail.com',
                'birthplace' => 'Banyuwangi',
                'birthdate' => '1987-12-09',
                'address' => 'Sukorejo',
                'year_of_entry' => '2016',
                'picture' => 'default.png',
                'status' => true,
                'last_education' => 'S1',
                'created_at' => Carbon::now(),
            ],
            [
                'position_id' => 1,
                'identity_number' => '200302123456789',
                'name' => 'Edy Pramono, S.Pd., M.Kom',
                'gender' => 'male',
                'phone_number' => '085673637261',
                'email' => 'edypram@gmail.com',
                'birthplace' => 'Banyuwangi',
                'birthdate' => '1977-11-10',
                'address' => 'Banyuwangi',
                'year_of_entry' => '2016',
                'picture' => 'default.png',
                'status' => true,
                'last_education' => 'S2',
                'created_at' => Carbon::now(),
            ],
            [
                'position_id' => 1,
                'identity_number' => '200302123456790',
                'name' => 'Rina Indrawati, S.T',
                'gender' => 'female',
                'phone_number' => '085673637261',
                'email' => 'rina@gmail.com',
                'birthplace' => 'Surabaya',
                'birthdate' => '1992-11-10',
                'address' => 'Blimbingsari',
                'year_of_entry' => '2016',
                'picture' => 'default.png',
                'status' => true,
                'last_education' => 'S1',
                'created_at' => Carbon::now(),
            ],
            [
                'position_id' => 1,
                'identity_number' => '300302123456789',
                'name' => 'Sri Rahayu, S.Pd',
                'gender' => 'female',
                'phone_number' => '085673637261',
                'email' => 'srirahayu@gmail.com',
                'birthplace' => 'Banyuwangi',
                'birthdate' => '1982-01-12',
                'address' => 'Blimbingsari',
                'year_of_entry' => '2016',
                'picture' => 'default.png',
                'status' => true,
                'last_education' => 'S1',
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
