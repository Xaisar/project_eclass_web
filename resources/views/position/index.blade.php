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
            <div class="mb-4">
                <div class="text-end">
                    @can('delete-position')
                        <button class="btn btn-danger mx-1 d-none" id="bulkDelete"><i class="fa fa-trash-alt"></i> Delete</button>
                    @endcan
                    @can('create-position')
                        <button class="btn btn-light add waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#myModal"><i class="fa fa-plus"></i> Tambah Jabatan
                            Baru</button>
                    @endcan
                </div>
            </div>
            <table id="dataTable" class="table align-middle datatable dt-responsive table-check nowrap"
                style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;"
                data-url="{{ route('position.getData') }}" width="100%">
                <thead class="table-light">
                    <th style="width: 30px;">
                        <div class="form-check font-size-16">
                            <input type="checkbox" name="check" class="form-check-input" id="checkAll">
                            <label class="form-check-label" for="checkAll"></label>
                        </div>
                    </th>
                    <th>Nama Jabatan</th>
                    <th></th>
                </thead>
            </table>
        </div><!-- end card-body -->
    </div>
    @include('position.partials.form')
@endsection
