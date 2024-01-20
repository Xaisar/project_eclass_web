@extends('layouts.ajax')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{ getSetting('web_name') }}</li>
        <li class="breadcrumb-item"><a href="{{ route('classroom.home', ['course' => hashId(getClassroomInfo()->id)]) }}"
                data-toggle="ajax">{{ getClassroomInfo()->classGroup->degree->degree .' ' .getClassroomInfo()->classGroup->name .'_' .getClassroomInfo()->subject->name }}</a>
        </li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')
    <div class="mb-4">
        <div class="text-start">
            <a href="{{ route('classroom.home', hashId(getClassroomInfo()->id), 'encode') }}" class="btn btn-light waves-effect mr-2 waves-light" data-toggle="ajax"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
    </div>
    <div class="card shadow-sm mb-3">
        <div class="card-header">
            <!-- Nav tabs -->
            <ul class="nav nav-pills nav-justified" role="tablist">
                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link active" data-bs-toggle="tab" href="#class-attendance-recap" role="tab" aria-selected="true">
                        <span class="d-block d-sm-none"><i class="fa fa-print"></i></span>
                        <span class="d-none d-sm-block">Rekap Absensi Kelas</span> 
                    </a>
                </li>
                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link" data-bs-toggle="tab" href="#class-attendance" role="tab" aria-selected="false">
                        <span class="d-block d-sm-none"><i class="fa fa-file-alt"></i></span>
                        <span class="d-none d-sm-block">Absensi Kelas</span> 
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <!-- Tab panes -->
            <div class="tab-content p-3 text-muted">
                <div class="tab-pane active" id="class-attendance-recap" role="tabpanel">
                    <div class="mb-4">
                        <div class="text-end">
                            <a href="" id="printExcel" target="_blank" class="btn btn-light btn-export-excel waves-effect mr-2 waves-light"><i
                                    class="fa fa-file-excel"></i>
                                Cetak
                                Excel</a>
                            <a href="" id="printPdf" target="_blank" class="btn btn-light btn-export-pdf waves-effect waves-light"><i class="fa fa-file-pdf"></i>
                                Cetak
                                PDF</a>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Tahun Ajaran</label>
                                <select name="year" class="form-control js-choices" id="year">
                                    <option value="">Pilih Tahun Ajaran</option>
                                    @foreach ($studyYears as $item)
                                        <option value="{{ $item->hashid }}">{{ $item->year . '/' . ($item->year + 1) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Pertemuan</label>
                                <select name="number_of_meeting_attendance_recap" class="form-control js-choices" id="number-of-meeting-attendance-recap">
                                    <option value="">Pilih Pertemuan</option>
                                    @for ($i = 0; $i < $course->number_of_meetings; $i++)
                                        <option value="{{ $i + 1 }}">Pertemuan {{ $i + 1 }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Cari Nama/NISN Siswa</label>
                                <input type="text" class="form-control" id="filter" name="filter" autocomplete="off" placeholder="Cari Nama/NISN Siswa">
                            </div>
                        </div>
                    </div>
                    <div class="no-data">
                        <img src="{{ asset('assets/images/illustration/empty.svg') }}" class="mx-auto d-block"
                            style="max-width: 400px" alt="">
                        <h4 class="text-center">Opps! Tidak ada data untuk ditampilkan</h4>
                    </div>
                    <div class="d-none" id="viewData"></div>
                </div>
                <div class="tab-pane" id="class-attendance" role="tabpanel">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Pertemuan</label>
                                <select name="number_of_meeting" class="form-control js-choices" id="number-of-meeting">
                                    <option value="">Pilih Pertemuan</option>
                                    @for ($i = 0; $i < $course->number_of_meetings; $i++)
                                        <option value="{{ $i + 1 }}">Pertemuan {{ $i + 1 }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="no-data-attendance">
                        <img src="{{ asset('assets/images/illustration/empty.svg') }}" class="mx-auto d-block"
                            style="max-width: 400px" alt="">
                        <h4 class="text-center">Opps! Tidak ada data untuk ditampilkan</h4>
                    </div>
                    <div class="d-none" id="viewDataAttendance">
                        <table id="dataTable"
                                            class="table align-middle datatable dataTable dt-responsive table-check nowrap"
                                            style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;"
                                            data-url="{{ route('classroom.class-attendance.getDataAttendance', ['course' => Hashids::encode($course->id)]) }}"
                                            width="100%">
                            <thead class="table-light">
                                <th>No</th>
                                <th>NISN</th>
                                <th>Nama</th>
                                <th>JK</th>
                                <th>Pertemuan</th>
                                <th>Status</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- end card-body -->
    </div>
@endsection
