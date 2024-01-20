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
            @can('create-video-conference')
                <div class="mb-4">
                    <div class="text-end">
                        <button data-toggle="modal" data-target="#myModal" class="btn btn-light add waves-effect waves-light add-btn" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-plus"></i> Buat Conference</button>
                    </div>
                </div>
            @endcan
            <table id="dataTable" class="table align-middle datatable dt-responsive table-check nowrap" style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;" data-url="{{ route('classroom.video-conference.getData', ['course' => hashId(getClassroomInfo()->id)]) }}" width="100%">
                <thead class="table-light">
                    <th>No</th>
                    <th>Nama Conference</th>
                    <th>Kode</th>
                    <th>Pertemuan ke-</th>
                    <th>Anggota</th>
                    <th>Tanggal</th>
                    <th>Selesai</th>
                    <th></th>
                </thead>
            </table>
        </div><!-- end card-body -->
    </div>

    @canany(['create-video-conference', 'update-video-conference'])
        @include('classroom.video-conference.partials.form')
    @endcanany

    @include('classroom.video-conference.partials.video-conference-participants')

@endsection
