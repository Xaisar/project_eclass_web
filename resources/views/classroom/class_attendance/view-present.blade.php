@if($students->count() > 0)
<div class="mt-3" style="">
    <table id="" class="table table-bordered table-sm mt-2"
        style="width: 100%;">
        <thead class="table-light">
            <tr>
                <th class="text-center first-col-no-header">NO</th>
                <th class="text-center first-col-header">NAMA SISWA</th>
                <th class="text-center">Pertemuan</th>
                <th class="text-center">Status Absensi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td class="first-col-no text-center">{{ $loop->iteration }}</td>
                <td class="first-col">{{ $student->name }}</td>
                <td class="text-center">Pertemuan {{ $numberOfMeeting }}</td>
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
        </tbody>
    </table>
</div>
@else
<img src="{{ asset('assets/images/illustration/empty.svg') }}" class="mx-auto d-block"
    style="max-width: 400px" alt="">
<h4 class="text-center">Opps! Tidak ada data untuk ditampilkan</h4>
@endif