 <h2 style="text-align:center;">Daftar Kejadian Siswa
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
             <th style="background-color: #A9A9A9; font-weight:bold;">WAKTU</th>
             <th style="background-color: #A9A9A9; font-weight:bold;">NAMA SISWA</th>
             <th style="background-color: #A9A9A9; font-weight:bold; ">PERILAKU</th>
             <th style="background-color: #A9A9A9; font-weight:bold;">BUTIR SIKAP</th>
             <th style="background-color: #A9A9A9; font-weight:bold;">POSITIF / NEGATIF</th>
             <th style="background-color: #A9A9A9; font-weight:bold;">TINDAKAN </th>
         </tr>
     </thead>
     <tbody>
         @foreach ($students as $item)
             <tr>
                 <td>{{ $loop->iteration }}</td>
                 <td>{{ localDateFormat($item->date) }}</td>
                 <td>{{ $item->student->name }}</td>
                 <td>{{ $item->incident }}</td>
                 <td>
                     @switch($item->attitude_item)
                         @case('responsibility')
                             {{ 'Tanggung Jawab' }}
                         @break
                         @case('honest')
                             {{ 'Jujur' }}
                         @break
                         @case('mutual_cooperation')
                             {{ 'Gotong Royong' }}
                         @break
                         @case('self_confident')
                             {{ 'Percaya Diri' }}
                         @break
                         @case('discipline')
                             {{ 'Disiplin' }}
                         @break
                         @default
                             {{ '-' }}
                     @endswitch
                 </td>
                 <td>{{ $item->attitude_value == 'positive' ? 'Positif (+)' : 'Negatif (-)' }}</td>
                 <td>{{ $item->follow_up }}</td>
             </tr>
         @endforeach
     </tbody>
 </table>
