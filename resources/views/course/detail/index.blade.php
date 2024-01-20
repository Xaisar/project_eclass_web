@extends('layouts.ajax')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{ getSetting('web_name') }}</li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" data-toggle="ajax">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('course') }}" data-toggle="ajax">Course</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="mb-3">
            <button class="btn btn-light waves-effect waves-light mx-1" data-toggle="ajax"
                data-target="{{ route('course') }}"><i class="fa fa-arrow-left"></i> Kembali</button>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#home" role="tab" aria-selected="true">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Home</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#absensi" role="tab" aria-selected="false">
                                <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                <span class="d-none d-sm-block">Absensi Kelas</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#basic_competence" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                <span class="d-none d-sm-block">Kompetensi Dasar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#rpp" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                <span class="d-none d-sm-block">RPP</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#student_incident" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                <span class="d-none d-sm-block">Kejadian Siswa</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#teaching_material" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                <span class="d-none d-sm-block">Materi / Bahan Ajar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#student_list" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                <span class="d-none d-sm-block">Daftar Siswa</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane active" id="home" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-8 offset-lg-2">
                                    <div class="card author-box mb-2">
                                        <div class="card-body">
                                            <div class="author-box-details text-center mt-2">
                                                <div class="author-box-name">
                                                    <h5 style="color:#6777ef;"><b>{{ $title }}</b></h5>
                                                    <br>
                                                    <h6 class="text-muted">
                                                        {{ $course->teacher->name }} </h6>
                                                    <p class="text-muted">Mata Pelajaran {{ $course->subject->name }}
                                                        Kelas {{ $course->classGroup->degree->degree }}
                                                        {{ $course->number_of_meetings }}
                                                        Pertemuan</p>
                                                </div>
                                                <p class="text-center mb-0" style="font-weight: 700; font-size: 16px;">
                                                    Siswa {{ $studentCount }} | Jumlah KD :
                                                    {{ $course->basicComptence->count() }} | KKM :
                                                    {{ $course->subject->grade }}
                                                </p>
                                                <center>
                                                    <small>
                                                        Kelas dibuat pada
                                                        {{ $course->created_at->locale('id')->isoFormat('LLLL') }}
                                                    </small>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 offset-lg-2">
                                    <h5 class="section-title text-primary my-3">Statistik Kelas</h5>
                                </div>
                                <div class="col-lg-8 offset-lg-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>KD</th>
                                                            <th>Jumlah Materi</th>
                                                            <th>Jumlah Penilaian Pengetahuan</th>
                                                            <th>Jumlah Penilaian Keterampilan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($basicComptenceWithCount as $item)
                                                            <tr>
                                                                <td>KD {{ $item['code'] }}</td>
                                                                <td>{{ $item['teachingMaterial'] }}</td>
                                                                <td>{{ $item['knowledge'] }}</td>
                                                                <td>{{ $item['skill'] }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="absensi" role="tabpanel">
                            <h5 class="mb-0 mt-3">Absensi Kelas</h5>
                            <p>Daftar Absensi Kelas</p>
                            <div class="table-container table-wrapper mt-3" style="overflow-x: scroll;">
                                <table id="table-presence" class="table table-bordered table-hover table-sm mt-2"
                                    style="width: 100%;">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center first-col-no-header">NO</th>
                                            <th class="text-center first-col-header">NAMA SISWA</th>
                                            @for ($i = 1; $i <= $course->number_of_meetings; $i++)
                                                <th>Pertemuan ke-{{ $i }}</th>
                                            @endfor
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $student)
                                            <tr>
                                                <td class="first-col-no text-center">{{ $loop->iteration }}</td>
                                                <td class="first-col"><a href="javascript:void(0)"><span
                                                            class="search-siswa" data-nisn="5724"
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
                        </div>
                        <div class="tab-pane" id="basic_competence" role="tabpanel">
                            <h5 class="mb-0 mt-3">Komptensi Dasar</h5>
                            <p>Daftar Komptensi Dasar</p>

                            <table class="table align-middle datatable dt-responsive table-check nowrap"
                                style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;" width="100%">
                                <thead class="table-light">
                                    <th width="20%">Kompetensi Inti (KI)</th>
                                    <th>Komptensi Dasar (KD)</th>
                                </thead>
                                <tbody>
                                    @foreach ($coreCompetence as $item)
                                        <tr>
                                            <td>{{ $item->code . ' - ' . $item->name }}</td>
                                            <td>
                                                <h5>Semester Ganjil</h5>
                                                @foreach ($basicComptence as $valSmtGanjil)
                                                    @if ($item->id == $valSmtGanjil->core_competence_id)
                                                        @if ($valSmtGanjil->semester == 1)
                                                            <strong>{{ $item->code . '.' . $valSmtGanjil->code }}</strong>
                                                            <span>{{ $valSmtGanjil->name }}</span> <br>
                                                        @endif
                                                    @endif
                                                @endforeach
                                                <h5 class="mt-2">Semester Genap</h5>
                                                @foreach ($basicComptence as $valSmtGenap)
                                                    @if ($item->id == $valSmtGenap->core_competence_id)
                                                        @if ($valSmtGenap->semester == 2)
                                                            <strong>{{ $item->code . '.' . $valSmtGenap->code }}</strong>
                                                            <span>{{ $valSmtGenap->name }}</span> <br>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="rpp" role="tabpanel">
                            <h5 class="mb-0 mt-3">RPP</h5>
                            <p>Daftar RPP</p>
                            <table id="dataTableRpp" class="table align-middle datatable dt-responsive table-check nowrap"
                                style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;"
                                data-url="{{ route('course.lesson-plan.getData', ['course' => hashId($course->id)]) }}"
                                width="100%">
                                <thead class="table-light">
                                    <th>No</th>
                                    <th>Hari / Tanggal</th>
                                    <th>File</th>
                                </thead>
                            </table>
                        </div>
                        <div class="tab-pane" id="student_incident" role="tabpanel">
                            <h5 class="mb-0 mt-3">Kejadian Siswa</h5>
                            <p>Daftar Kejadian Siswa</p>
                            <table id="dataTableStudentIncident"
                                class="table align-middle datatable dt-responsive table-check nowrap"
                                style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;" width="100%"
                                data-url="{{ route('course.student-incidents.getData', ['course' => hashId($course->id)]) }}">
                                <thead class="table-light">
                                    <th>No</th>
                                    <th>Waktu</th>
                                    <th>NIS / NISN</th>
                                    <th>Nama Siswa</th>
                                    <th>Perilaku</th>
                                    <th>Butir Sikap</th>
                                    <th>Positif / Negatif</th>
                                    <th>Tindakan</th>
                                </thead>
                            </table>
                        </div>
                        <div class="tab-pane" id="teaching_material" role="tabpanel">
                            <h5 class="mb-0 mt-3">Materi / Bahan Ajar</h5>
                            <p>Daftar Materi / Bahan Ajar</p>
                            <table id="dataTableTeachingMaterial"
                                class="table align-middle datatable dt-responsive table-check nowrap"
                                style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;" width="100%"
                                data-url="{{ route('course.teaching-materials.getData', ['course' => hashId($course->id)]) }}">
                                <thead class="table-light">
                                    <th>No</th>
                                    <th>Nama Bahan Ajar</th>
                                    <th>Kompetensi Inti</th>
                                    <th>Kompetensi Dasar</th>
                                    <th>Materi</th>
                                    <th>Share</th>
                                    <th>Keterangan</th>
                                </thead>
                            </table>
                        </div>
                        <div class="tab-pane" id="student_list" role="tabpanel">
                            <h5 class="mb-0 mt-3">Siswa</h5>
                            <p>Daftar Siswa</p>
                            <table id="dataTableStudentList"
                                class="table align-middle datatable dt-responsive table-check nowrap"
                                style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;" width="100%"
                                data-url="{{ route('course.students.getData', ['course' => hashId($course->id)]) }}">
                                <thead class="table-light">
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>NIS / NISN</th>
                                    <th>Nama Siswa</th>
                                    <th>L/P</th>
                                    <th>TTL</th>
                                    <th>Kelas</th>
                                    <th>Status</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>
@endsection
