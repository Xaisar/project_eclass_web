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
            <table id="dataTable" class="table align-middle datatable dt-responsive table-check nowrap"
                style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;"
                data-url="{{ route('classroom.activity-monitoring.getData', ['course' => hashId(getClassroomInfo()->id)]) }}"
                width="100%">
                <thead class="table-light">
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>L/P</th>
                    <th>Online</th>
                    <th>Keterangan</th>
                </thead>
            </table>
        </div><!-- end card-body -->
    </div>
@endsection
