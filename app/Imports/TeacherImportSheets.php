<?php

namespace App\Imports;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;

class TeacherImportSheets implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $value) {
            if ($key > 0) {
                $gender = 'other';
                if ($value[2] == 'male' || $value[2] == 'L' || $value[2] == 'Laki-Laki' || $value[2] == 'Pria') {
                    $gender = 'male';
                } else if ($value[2] == 'female' || $value[2] == 'P' || $value[2] == 'Perempuan' || $value[2] == 'Wanita') {
                    $gender = 'female';
                }
                $data = [
                    'position_id' => $value[10],
                    'identity_number' => $value[0],
                    'name' => $value[1],
                    'gender' => $gender,
                    'phone_number' => $value[4],
                    'email' => $value[3],
                    'birthplace' => $value[5],
                    'birthdate' => date('Y-m-d', $value[6]),
                    'address' => $value[9],
                    'year_of_entry' => $value[7],
                    'last_education' => $value[8],
                ];
                $getTeacher = Teacher::where(['identity_number' => $value[0]]);
                if ($getTeacher->count() > 0) {
                    $getUser = User::where(['userable_type' => Teacher::class, 'userable_id' => $getTeacher->id])->first();
                    $getTeacher->update($data);
                    $getUser->update([
                        'name' => $value[1],
                        'email' => $value[3],
                    ]);
                } else {
                    $teacher = Teacher::create($data);
                    $user = User::create([
                        'userable_type' => Teacher::class,
                        'userable_id' => $teacher->id,
                        'name' => $value[1],
                        'email' => $value[3],
                        'username' => $teacher->identity_number,
                        'password' => Hash::make($teacher->identity_number),
                    ]);
                    $user->assignRole('Guru');
                }
            }
        }
    }
}
