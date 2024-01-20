<div class="table-container table-wrapper mt-3" style="overflow-x: scroll">
    <table id="table-presence" class="table table-bordered table-hover table-sm mt-2" style="width: 100%;">
        <thead class="table-light">
            <tr>
                <th class="text-center first-col-no-header">No</th>
                <th class="text-center first-col-header">Nama</th>
                @for ($i = 1; $i <= $course->number_of_meetings; $i++)
                    <th>Pertemuan ke-{{ $i }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr>
                    <td class="first-col-no text-center">{{ $loop->iteration }}</td>
                    <td class="first-col"><a href="javascript:void(0)"><span class="search-siswa" data-nisn="5724"
                                style="cursor:pointer;">{{ $student->name }}</span></a></td>
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
        </tbody>
    </table>
</div>