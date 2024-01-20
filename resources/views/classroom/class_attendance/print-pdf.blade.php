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
        Presensi Kelas {{ '(' . $classGroup->classGroup->degree->degree . ')  ' . $classGroup->classGroup->name }}<br>
        Tahun Ajaran {{ $studyYear->year . '/' . ($studyYear->year + 1) }}
    </h2>
    <hr style="margin: 2px 0px"><hr style="margin: 2px 0px">
    <h4 class="text-center">Pertemuan {{ $numberOfMeeting }}</h4>
    <table class="table" cellpadding="5" width="100%">
        <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Pertemuan</th>
            <th>Status Absensi</th>
        </tr>
        @foreach($students as $student)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $student->name }}</td>
                <td>Pertemuan {{ $numberOfMeeting }}</td>
                    @if($student->attendance->count() > 0)
                        @php $rowStatus = true; @endphp
                        @foreach($student->attendance as $item)
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
                        @endforeach
                        @if($rowStatus)
                            <td class="text-center">-</td>
                        @endif
                    @else
                        <td class="text-center">-</td>
                    @endif
            </tr>
        @endforeach
    </table>
</body>
</html>