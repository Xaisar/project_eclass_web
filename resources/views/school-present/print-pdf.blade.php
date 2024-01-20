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
    @php
        $monthArray = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];
    @endphp
    <h2 class="text-center">
        Presensi Sekolah Kelas {{ '(' . $classGroup->degree->degree . ')  ' . $classGroup->name }}<br>
        Tahun Ajaran {{ $studyYear->year . '/' . ($studyYear->year + 1) }}
    </h2>
    <hr style="margin: 2px 0px"><hr style="margin: 2px 0px">
    <h4 class="text-center">Bulan {{ $monthArray[$month] }}</h4>
    <table class="table" cellpadding="5" width="100%">
        <tr>
            <th>No.</th>
            <th>Nama</th>
            @for($i = 1;$i <= date('t', strtotime($studyYear->year .'-'. str_pad($month, 2, 0, STR_PAD_LEFT) .'-01'));$i++)
                <th>{{ $i }}</th>
            @endfor
        </tr>
        @foreach($students as $student)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $student->name }}</td>
                @for($i = 1;$i <= date('t', strtotime($studyYear->year .'-'. str_pad($month, 2, 0, STR_PAD_LEFT) .'-01'));$i++)
                    @if($student->attendance->count() > 0)
                        @php $rowStatus = true; @endphp
                        @foreach($student->attendance as $item)
                            @if($item->type == 'school' && date('d', strtotime($item->date)) == $i)
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
                                    @default
                                        @php $rowStatus = false; @endphp
                                        <td class="text-center">-</td>
                                @endswitch
                            @endif
                        @endforeach
                        @if($rowStatus)
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