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
            @can('create-teaching-materials')
                <div class="mb-4">
                    <div class="text-end">
                        <button class="btn btn-light add waves-effect waves-light add-btn" data-bs-toggle="modal"
                            data-bs-target="#myModal"><i class="fa fa-plus"></i> Tambah Bahan Ajar</button>
                    </div>
                </div>
            @endcan
            <table id="dataTable" class="table align-middle datatable dt-responsive table-check nowrap" style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;" data-url="{{ route('classroom.teaching-materials.getData', ['course' => hashId(getClassroomInfo()->id)]) }}" width="100%">
                <thead class="table-light">
                    <th>No</th>
                    <th>Nama Bahan Ajar</th>
                    <th>Kompetensi Inti</th>
                    <th>Kompetensi Dasar</th>
                    <th>Materi</th>
                    <th>Share</th>
                    <th>Keterangan</th>
                    <th></th>
                </thead>
            </table>
        </div><!-- end card-body -->
    </div>
    @canany(['read-teaching-materials', 'update-teaching-materials'])
        @include('classroom.teaching_material.partials.form')
    @endcanany
@endsection
