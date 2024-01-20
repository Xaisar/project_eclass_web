<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $developer = User::create([
            'name' => 'Developer',
            'email' => 'root@gmail.com',
            'username' => 'root',
            'password' => Hash::make('root'),
            'created_at' => Carbon::now(),
        ]);
        $administrator = User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'created_at' => Carbon::now(),
        ]);

        $student = User::insert([
            [
                'userable_type' => Student::class,
                'userable_id' => 1,
                'name' => 'Ridho Pijak Imana',
                'email' => 'ridho@gmail.com',
                'username' => 'ridho',
                'password' => Hash::make('siswa'),
                'created_at' => Carbon::now(),
            ],
            [
                'userable_type' => Student::class,
                'userable_id' => 2,
                'name' => 'Sindy Rahayu',
                'email' => 'sindy@gmail.com',
                'username' => 'sindy',
                'password' => Hash::make('siswa'),
                'created_at' => Carbon::now(),
            ],
            [
                'userable_type' => Student::class,
                'userable_id' => 3,
                'name' => 'Dimas Anggara',
                'email' => 'dimas@gmail.com',
                'username' => 'dimas',
                'password' => Hash::make('siswa'),
                'created_at' => Carbon::now(),
            ],
            [
                'userable_type' => Student::class,
                'userable_id' => 4,
                'name' => 'Edy Saputra',
                'email' => 'edysaputra@gmail.com',
                'username' => 'edysaputra',
                'password' => Hash::make('siswa'),
                'created_at' => Carbon::now(),
            ],
            [
                'userable_type' => Student::class,
                'userable_id' => 5,
                'name' => 'Niki Lestari',
                'email' => 'niki@gmail.com',
                'username' => 'niki',
                'password' => Hash::make('siswa'),
                'created_at' => Carbon::now(),
            ],
            [
                'userable_type' => Student::class,
                'userable_id' => 6,
                'name' => 'Riko Dermawan',
                'email' => 'riko@gmail.com',
                'username' => 'riko',
                'password' => Hash::make('siswa'),
                'created_at' => Carbon::now(),
            ],
        ]);
        $teacher = User::insert([
            [
                'userable_type' => Teacher::class,
                'userable_id' => 1,
                'name' => 'Suyono, S.Kom',
                'email' => 'suyono@gmail.com',
                'username' => 'suyono',
                'password' => Hash::make('guru'),
                'created_at' => Carbon::now(),
            ],
            [
                'userable_type' => Teacher::class,
                'userable_id' => 2,
                'name' => 'Edy Pramono, S.Pd., M.Kom',
                'email' => 'edypram@gmail.com',
                'username' => 'edypram',
                'password' => Hash::make('guru'),
                'created_at' => Carbon::now(),
            ],
            [
                'userable_type' => Teacher::class,
                'userable_id' => 3,
                'name' => 'Rina Indrawati, S.T',
                'email' => 'rina@gmail.com',
                'username' => 'rina',
                'password' => Hash::make('guru'),
                'created_at' => Carbon::now(),
            ],
            [
                'userable_type' => Teacher::class,
                'userable_id' => 4,
                'name' => 'Sri Rahayu, S.Pd',
                'email' => 'sri@gmail.com',
                'username' => 'sri',
                'password' => Hash::make('guru'),
                'created_at' => Carbon::now(),
            ],
        ]);

        $developer->assignRole('Developer');
        $administrator->assignRole('Administrator');
        $getTeacher = User::where('userable_type', Teacher::class)->get();
        $getStudent = User::where('userable_type', Student::class)->get();
        foreach ($getTeacher as $key => $value) {
            $value->assignRole('Guru');
        }
        foreach ($getStudent as $key => $value) {
            $value->assignRole('Siswa');
        }
    }
}
