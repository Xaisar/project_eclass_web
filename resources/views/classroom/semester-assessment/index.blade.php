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

<div class="alert alert-warning d-none" id="alert-unsaved"><i class="fa fa-sync-alt fa-spin mr-3"></i> Perubahan akan otomatis di simpan dalam 5 detik.</div>
<div class="alert alert-success d-none" id="alert-saved"><i class="fa fa-check-circle mr-3"></i> Data telah disimpan.</div>

<div class="card shadow-sm mb-3">
    <div class="card-body">
        @can('create-video-conference')
            <div class="mb-4">
                <div class="text-end">
                    <a href="{{ route('classroom.semester-assessments.export', ['course' => hashId(getClassroomInfo()->id)]) }}" target="_blank" class="btn btn-light add waves-effect waves-light add-btn"><i class="fa fa-download"></i> Export Excel</a>
                </div>
            </div>
        @endcan
        <table id="dataTable" class="table align-middle datatable dt-responsive table-check nowrap" style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;" data-url="{{ route('classroom.semester-assessments.getData', ['course' => hashId(getClassroomInfo()->id)]) }}" width="100%">
            <thead class="table-light">
                <th>No</th>
                <th>Nama</th>
                <th>TTL</th>
                <th>Jenis Kelamin</th>
                <th>Nilai Pas</th>
                <th>Nilai Akhir</th>
            </thead>
        </table>
    </div><!-- end card-body -->
</div>

@endsection