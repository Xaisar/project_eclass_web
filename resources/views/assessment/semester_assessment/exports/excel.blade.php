 <h2 style="text-align:center;">Nilai Semester Kelas
     {{ $course->classGroup->degree->degree . ' ' . $course->classGroup->name }}
 </h2>
 <h4 style="text-align:center;">Tahun Ajaran {{ $studyYear->year . '/' . ($studyYear->year + 1) }}
     {{ $semester == '1' ? 'Ganjil' : 'Genap' }}
 </h4>
 <br>
 <br>
 <table>
     <thead>
         <tr>
             <th style="background-color: #A9A9A9; font-weight:bold;">NO</th>
             <th style="background-color: #A9A9A9; font-weight:bold;">NIS/NISN</th>
             <th style="background-color: #A9A9A9; font-weight:bold;">NAMA SISWA</th>
             <th style="background-color: #A9A9A9; font-weight:bold;">NILAI </th>
         </tr>
     </thead>
     <tbody>
         {{-- @php
             return dd($data);
         @endphp --}}
         @foreach ($data as $item)
             <tr>
                 <td>{{ $loop->iteration }}</td>
                 <td>{{ $item->student->identity_number }}</td>
                 <td>{{ $item->student->name }}</td>
                 <td>{{ $item->score }}</td>
             </tr>
         @endforeach
     </tbody>
 </table>
