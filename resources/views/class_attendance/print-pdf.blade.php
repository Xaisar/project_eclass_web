<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>

    <style>
        .text-center {
            text-align: center;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table th, .table td {
            border: 1px solid #373737;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <h2 class="text-center">
        Presensi Kelas {{ '(' . $course->classGroup->degree->degree . ')  ' . $course->classGroup->name }}<br>
        Tahun Ajaran {{ $studyYear->year . '/' . ($studyYear->year + 1) }}<br>
        Semester {{ $studyYear->semester == 1 ? 'Ganjil' : 'Genap' }}
    </h2>
    <hr style="margin: 2px 0px">
    <h2 class="text-center">Pelajaran {{ $course->subject->name }}</h2>
    <table class="table text-center" cellpadding="4" width="100%">
        <tr>
            <th>No.</th>
            <th>Nama </th>
            @for ($i = 1; $i <= $course->number_of_meetings; $i++)
                <th>Pertemuan ke-{{ $i }}</th>
            @endfor
        </tr>
        @foreach($students as $student)
            <tr>
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
</body>
</html>