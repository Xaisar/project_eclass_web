<table cellpadding="4" width="100%">
    <tr>
        <th style="text-align: center;font-weight: bold" colspan="{{ $course->number_of_meetings }}">
            Presensi Kelas Ajar {{ '(' . $course->classGroup->degree->degree . ')  ' . $course->classGroup->name }}
        </th>
    </tr>
    <tr>
        <th style="text-align: center;font-weight: bold" colspan="{{ $course->number_of_meetings }}">
            Tahun Ajaran {{ $studyYear->year . '/' . ($studyYear->year + 1) }}
        </th>
    </tr>
    <tr>
        <th style="text-align: center;font-weight: bold" colspan="{{ $course->number_of_meetings }}">
            Semester {{ $studyYear->semester == 1 ? 'Ganjil' : 'Genap' }}
        </th>
    </tr>
    <tr>
        <th style="text-align: center;font-weight: bold" colspan="{{ $course->number_of_meetings }}">
            Pelajaran {{ $course->subject->name }}
        </th>
    </tr>
    <tr>
        <th style="text-align: center" colspan="{{ $course->number_of_meetings }}"></th>
    </tr>
    <tr>
        <th style="text-align: center;font-weight: bold">No</th>
        <th style="text-align: center;font-weight: bold">Nama</th>
        @for ($i = 1; $i <= $course->number_of_meetings; $i++)
            <th style="text-align: center;font-weight: bold">Pertemuan {{ $i }}</th>
        @endfor
    </tr>
    @foreach($students as $student)
        <tr style="margin-top: 5px">
            <td>{{ $loop->iteration }}</td>
            <td>{{ $student->name }}</td>
            @for ($i = 1; $i <= $course->number_of_meetings; $i++)
                @if ($student->attendance->count() > 0)
                    @php $rowStatus = true; @endphp
                    @foreach ($student->attendance as $item)
                        @if ($item->type == 'course' && $item->number_of_meetings == $i)
                            @switch($item->status)
                                @case('present')
                                    @php $rowStatus = false; @endphp
                                    <td class="text-center">H</td>
                                @break

                                @case('permission')
                                    @php $rowStatus = false; @endphp
                                    <td class="text-center">I</td>
                                @break

                                @case('sick')
                                    @php $rowStatus = false; @endphp
                                    <td class="text-center">S</td>
                                @break

                                @case('absent')
                                    @php $rowStatus = false; @endphp
                                    <td class="text-center">A</td>
                                @break

                                @case('late')
                                    @php $rowStatus = false; @endphp
                                    <td class="text-center">T</td>
                                @break
                                @case('forget')
                                    @php $rowStatus = false; @endphp
                                    <td class="text-center">LA</td>
                                @break
                                @case('holiday')
                                    @php $rowStatus = false; @endphp
                                    <td class="text-center">L</td>
                                @break

                                @default
                                    @php $rowStatus = false; @endphp
                                    <td class="text-center">-</td>
                            @endswitch
                        @endif
                    @endforeach
                    @if ($rowStatus)
                        <td class="text-center">-</td>
                    @endif
                @else
                    <td class="text-center">-</td>
                @endif
            @endfor
        </tr>
    @endforeach
</table>