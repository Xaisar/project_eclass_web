@if($students->count() > 0)
<div class="table-container table-wrapper mt-3" style="overflow-x: scroll;">
    <table id="table-presence" class="table table-bordered table-hover table-sm mt-2"
        style="width: 100%;">
        <thead class="table-light">
            <tr>
                <th class="text-center first-col-no-header">NO</th>
                <th class="text-center first-col-header">NAMA SISWA</th>
                @for($i = 1;$i <= date('t', strtotime($studyYear->year .'-'. str_pad($month, 2, 0, STR_PAD_LEFT) .'-01'));$i++)
                    <th>{{ $i }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td class="first-col-no text-center">{{ $loop->iteration }}</td>
                <td class="first-col">{{ $student->name }}</td>
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
        </tbody>
    </table>
</div>
@else
<img src="{{ asset('assets/images/illustration/empty.svg') }}" class="mx-auto d-block"
    style="max-width: 400px" alt="">
<h4 class="text-center">Opps! Tidak ada data untuk ditampilkan</h4>
@endif