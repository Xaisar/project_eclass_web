 <h2 style="text-align:center;">Daftar Siswa
     {{ getClassroomInfo()->classGroup->degree->degree . ' ' . getClassroomInfo()->classGroup->name . '_' . getClassroomInfo()->subject->name }}
 </h2>
 <h4>Tahun Ajaran : {{ getStudyYear()->year . ' / ' . (getStudyYear()->year + 1) }} Semester
     {{ getStudyYear()->semester == 1 ? 'Ganjil' : 'Genap' }}</h4>
 <br>
 <br>
 <table>
     <thead>
         <tr>
             <th style="background-color: #A9A9A9; font-weight:bold;">NO</th>
             <th style="background-color: #A9A9A9; font-weight:bold;">NIS / NISN</th>
             <th style="background-color: #A9A9A9; font-weight:bold;">NAMA SISWA</th>
             <th style="background-color: #A9A9A9; font-weight:bold; ">JENIS KELAMIN</th>
             <th style="background-color: #A9A9A9; font-weight:bold;">TEMPAT TANGGAL LAHIR</th>
             <th style="background-color: #A9A9A9; font-weight:bold;">KELAS</th>
             <th style="background-color: #A9A9A9; font-weight:bold;">STATUS </th>
         </tr>
     </thead>
     <tbody>
         @foreach ($students as $item)
             <tr>
                 <td>{{ $loop->iteration }}</td>
                 <td>{{ $item->student->identity_number }}</td>
                 <td>{{ $item->student->name }}</td>
                 <td>{{ $item->student->gender == 'male' ? 'Laki-Laki' : 'Perempuan' }}</td>
                 <td>{{ $item->student->birthplace . ', ' . $item->student->birthdate }}</td>
                 <td>{{ $item->classGroup->degree->degree . ' ' . $item->classGroup->name }}</td>
                 <td>{{ $item->status == true ? 'Aktif' : 'Tidak Aktif' }}</td>
             </tr>
         @endforeach
     </tbody>
 </table>
