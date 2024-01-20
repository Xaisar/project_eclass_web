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
<table cellpadding="5" width="100%">
    <tr>
        <th style="text-align: center;font-weight: bold" colspan="{{ date('t', strtotime($studyYear->year .'-'. str_pad($month, 2, 0, STR_PAD_LEFT) .'-01')) + 2 }}">
            Presensi Sekolah Kelas {{ '(' . $classGroup->degree->degree . ')  ' . $classGroup->name }}<br>
            Tahun Ajaran {{ $studyYear->year . '/' . ($studyYear->year + 1) }}
        </th>
    </tr>
    <tr>
        <th style="text-align: center;font-weight: bold" colspan="{{ date('t', strtotime($studyYear->year .'-'. str_pad($month, 2, 0, STR_PAD_LEFT) .'-01')) + 2 }}">
            Bulan {{ $monthArray[$month] }}
        </th>
    </tr>
    <tr>
        <th style="text-align: center" colspan="{{ date('t', strtotime($studyYear->year .'-'. str_pad($month, 2, 0, STR_PAD_LEFT) .'-01')) + 2 }}"></th>
    </tr>
    <tr>
        <th style="text-align: center" colspan="{{ date('t', strtotime($studyYear->year .'-'. str_pad($month, 2, 0, STR_PAD_LEFT) .'-01')) + 2 }}"></th>
    </tr>
    <tr>
        <th style="text-align: center;font-weight: bold">No.</th>
        <th style="text-align: center;font-weight: bold">Nama</th>
        @for($i = 1;$i <= date('t', strtotime($studyYear->year .'-'. str_pad($month, 2, 0, STR_PAD_LEFT) .'-01'));$i++)
            <th style="text-align: center;font-weight: bold">{{ $i }}</th>
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
                    <td style="text-align: center">-</td>
                @endif
            @endfor
        </tr>
    @endforeach
</table>