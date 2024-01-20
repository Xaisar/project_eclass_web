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
            @can('create-basic-competence')
                <div class="text-end">
                    <button class="btn btn-light add waves-effect waves-light add-btn" data-bs-toggle="modal"
                        data-bs-target="#send-broadcast"><i class="fas fa-paper-plane mr-2 d-inline-block"></i> <span class="d-inline-block">Broadcast Pesan Baru</span></button>
                </div>
            @endcan
        </div><!-- end card-body -->
    </div>
    <div class="card shadow mb-3">
        <div class="card-body">
            <table id="dataTable" class="table align-middle datatable dt-responsive table-check nowrap" style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;" data-url="{{ route('classroom.broadcast.getData', ['course' => hashId(getClassroomInfo()->id)]) }}" width="100%">
                <thead class="table-light">
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Pesan</th>
                </thead>
            </table>
        </div>
    </div>
    @include('classroom.broadcast-wa.partials.form')
@endsection
