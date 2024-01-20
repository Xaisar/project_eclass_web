<table cellpadding="5" width="100%">
    <tr>
        <th style="text-align: center;font-weight: bold" colspan="4">
            Presensi Kelas {{ '(' . $classGroup->classGroup->degree->degree . ')  ' . $classGroup->classGroup->name }}<br>
            Tahun Ajaran {{ $studyYear->year . '/' . ($studyYear->year + 1) }}
        </th>
    </tr>
    <tr>
        <th style="text-align: center;font-weight: bold" colspan="4">
            Pertemuan {{ $numberOfMeeting }}
        </th>
    </tr>
    <tr>
        <th style="text-align: center" colspan="4"></th>
    </tr>
    <tr>
        <th style="text-align: center;font-weight: bold">No.</th>
        <th style="text-align: center;font-weight: bold">Nama</th>
        <th style="text-align: center;font-weight: bold">Pertemuan</th>
        <th style="text-align: center;font-weight: bold">Status Absensi</th>
    </tr>
    @foreach($students as $student)
        <tr style="margin-top: 5px">
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
                    <td style="text-align: center">-</td>
                @endif
        </tr>
    @endforeach
</table>