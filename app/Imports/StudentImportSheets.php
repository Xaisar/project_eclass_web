<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentImportSheets implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (isset($row['id_jurusan'])) {
                $check = Student::where('identity_number', $row['nomor_identitas']);
                if ($check->count() > 0) {
                    $check->update([
                        'major_id' => $row['id_jurusan'],
                        'identity_number' => $row['nomor_identitas'],
                        'name' => $row['nama'],
                        'gender' => ($row['jenis_kelamin_lp'] == 'L') ? 'male' : 'female',
                        'birthplace' => $row['tempat_lahir'],
                        'birthdate' => date('Y-m-d', strtotime($row['tanggal_lahir'])),
                        'email' => $row['email'],
                        'phone_number' => $row['nomor_telepon'],
                        'parent_phone_number' => $row['nomor_telepon_ortu'],
                        'address' => $row['alamat'],
                    ]);
                } else {
                    // return dd($row);
                    $student = Student::create([
                        'major_id' => $row['id_jurusan'],
                        'uid' => Str::random(30),
                        'identity_number' => $row['nomor_identitas'],
                        'name' => $row['nama'],
                        'gender' => ($row['jenis_kelamin_lp'] == 'L') ? 'male' : 'female',
                        'birthplace' => $row['tempat_lahir'],
                        'birthdate' => date('Y-m-d', strtotime($row['tanggal_lahir'])),
                        'email' => $row['email'],
                        'phone_number' => $row['nomor_telepon'],
                        'parent_phone_number' => $row['nomor_telepon_ortu'],
                        'picture' => 'default.png',
                        'address' => $row['alamat'],
                    ]);
                    // return dd($student);

                    $user = User::create([
                        'userable_type' => Student::class,
                        'userable_id' => $student->id,
                        'picture' => 'default.png',
                        'name' => $row['nama'],
                        'email' => $row['email'],
                        'username' => $row['nomor_identitas'],
                        'password' => Hash::make($row['nomor_identitas'])
                    ]);
                    $user->assignRole('Siswa');
                }
            }
        }
    }
}
