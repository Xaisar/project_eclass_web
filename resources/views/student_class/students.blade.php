@extends('layouts.ajax')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{ getSetting('web_name') }}</li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" data-toggle="ajax">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('student-classes') }}" data-toggle="ajax">Kelas Siswa</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')

    <div class="card shadow-sm mb-3">
        <div class="card-header">
            <h5 class="card-title">Kelola Data Siswa Aktif Kelas
                {{ $classGroup->degree->degree . ' ' . $classGroup->name }} - Tahun Ajaran
                {{ getStudyYear()->year . ' / ' . (getStudyYear()->year + 1) }}
            </h5>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <div class="text-end">
                    @can('delete-student-classes')
                        <button class="btn btn-danger mx-1 d-none" id="bulkDelete"><i class="fa fa-trash-alt"></i>
                            Delete</button>
                    @endcan
                    <button class="btn btn-light waves-effect waves-light" data-toggle="ajax"
                        data-target="{{ route('student-classes') }}"><i class="fa fa-arrow-left"></i> Kembali</button>
                    @can('create-student-classes')
                        <button type="button" class="btn btn-light waves-effect waves-light add-student"><i
                                class="fa fa-plus"></i> Tambahkan
                            Siswa</button>
                    @endcan
                </div>
            </div>
            <table id="dataTable" class="table align-middle datatable dt-responsive table-check nowrap"
                style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;"
                data-url="{{ route('student-classes.students.getData', ['classGroup' => hashId($classGroup->id)]) }}"
                width="100%">
                <thead class="table-light">
                    <th style="width: 30px;">
                        <div class="form-check font-size-16">
                            <input type="checkbox" name="check" class="form-check-input" id="checkAll">
                            <label class="form-check-label" for="checkAll"></label>
                        </div>
                    </th>
                    <th>NIS / NISN</th>
                    <th>Nama Siswa</th>
                    <th>Jenis Kelamin</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Shift</th>
                    <th>Status</th>
                    <th></th>
                </thead>
            </table>
        </div><!-- end card-body -->
    </div>
    @include('student_class.partials.form_add')
@endsection
