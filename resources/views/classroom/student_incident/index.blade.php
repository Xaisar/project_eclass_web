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
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="mb-4">
                <div class="text-end">
                    <a href="{{ route('classroom.student-incidents.export-excel', ['course' => hashId(getClassroomInfo()->id)]) }}"
                        class="btn btn-light add waves-effect waves-light"><i class="fa fa-file-excel"></i> Cetak Excel</a>
                    @can('create-student-incident')
                        <button class="btn btn-light add waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#myModal"><i class="fa fa-plus"></i> Tambah Kejadian</button>
                    @endcan
                </div>
            </div>
            <table id="dataTable" class="table align-middle datatable dt-responsive table-check nowrap"
                style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;"
                data-url="{{ route('classroom.student-incidents.getData', ['course' => hashId(getClassroomInfo()->id)]) }}"
                width="100%">
                <thead class="table-light">
                    <th>No</th>
                    <th>Waktu</th>
                    <th>NIS / NISN</th>
                    <th>Nama Siswa</th>
                    <th>Perilaku</th>
                    <th>Butir Sikap</th>
                    <th>Positif / Negatif</th>
                    <th>Tindakan</th>
                    <th></th>
                </thead>
            </table>
        </div><!-- end card-body -->
    </div>
    @include('classroom.student_incident.partials.form')
@endsection
