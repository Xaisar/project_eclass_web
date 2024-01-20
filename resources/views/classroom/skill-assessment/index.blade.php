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
            <div class="col-12 text-end mb-3">
                @can('create-teacher-skill-assessment')
                    <button class="btn btn-primary" id="create"><i class="fa fa-plus"></i> Buat Tugas</button>
                @endcan
                <button class="btn btn-success"><i class="fa fa-download"></i> Export Excel</button>
            </div>

            <table id="dataTable" class="table align-middle datatable dt-responsive table-check nowrap"
                style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;"
                data-url="{{ route('classroom.skill-assessments.getData', ['course' => hashId(getClassroomInfo()->id)]) }}"
                width="100%">
                <thead class="table-light">
                    <th>No</th>
                    <th>Skema</th>
                    <th>Nama</th>
                    <th>KD</th>
                    <th>Keterangan</th>
                    <th>Waktu</th>
                    <th></th>
                </thead>
            </table>
        </div>
    </div>

    <v-modal></v-modal>
@endsection
