@extends('layouts.ajax')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{ getSetting('web_name') }}</li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" data-toggle="ajax">Dashboard</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Tahun Ajaran</label>
                        <select name="year" id="year" class="form-control js-choices filter-form">
                            <option value="">Pilih Tahun Ajaran</option>
                            @foreach ($studyYear as $item)
                                <option value="{{ $item->hashid }}">{{ $item->year . '/' . ($item->year + 1) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Semester</label>
                        <select name="semester" id="semester" class="form-control js-choices filter-form">
                            <option value="">Pilih Tahun Ajaran</option>
                            <option value="1">Ganjil</option>
                            <option value="2">Genap</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Kelas</label>
                        <select name="class_group" id="class_group" class="form-control js-choices filter-form">
                            <option value="">Pilih Kelas</option>
                            @foreach ($classGroup as $item)
                                <option value="{{ $item->hashid }}">
                                    {{ $item->degree->degree . ' ' . $item->name . ' (' . $item->major->name . ')' }}
                                </option>
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="mb-4">
                <div class="text-end">
                    @can('delete-course')
                        <button class="btn btn-danger mx-1 d-none" id="bulkDelete"><i class="fa fa-trash-alt"></i>
                            Delete</button>
                    @endcan
                    @can('create-course')
                        <button class="btn btn-primary add waves-effect waves-light add-course-btn" data-bs-toggle="modal" data-bs-target="#course">
                            <i class="fa fa-plus"></i>
                            Tambah Course Baru
                        </button>
                    @endcan
                </div>
            </div>
            <table id="dataTable" class="table align-middle datatable dt-responsive table-check nowrap"
                style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;"
                data-url="{{ route('course.getData') }}" width="100%">
                <thead class="table-light">
                    <th style="width: 30px;">
                        <div class="form-check font-size-16">
                            <input type="checkbox" name="check" class="form-check-input" id="checkAll">
                            <label class="form-check-label" for="checkAll"></label>
                        </div>
                    </th>
                    <th>Nama Course</th>
                    <th>Nama Guru</th>
                    <th>Kelas</th>
                    <th>Tahun Ajaran</th>
                    <th>Status</th>
                    <th></th>
                    <th></th>
                </thead>
            </table>
        </div><!-- end card-body -->
    </div>
@include('course.form')
@endsection
