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
                    @can('delete-shift')
                        <button class="btn btn-danger mx-1 d-none" id="bulkDelete"><i class="fa fa-trash-alt"></i> Delete</button>
                    @endcan
                    @can('create-shift')
                        <button class="btn btn-primary add waves-effect waves-light" data-toggle="ajax"
                            data-target="{{ route('shift.create') }}"><i class="fa fa-plus"></i> Tambah Shift
                            Baru</button>
                    @endcan
                </div>
            </div>
            <table id="dataTable" class="table align-middle datatable dt-responsive table-check nowrap"
                style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;"
                data-url="{{ route('shift.getData') }}" width="100%">
                <thead class="table-light">
                    <th style="width: 30px;">
                        <div class="form-check font-size-16">
                            <input type="checkbox" name="check" class="form-check-input" id="checkAll">
                            <label class="form-check-label" for="checkAll"></label>
                        </div>
                    </th>
                    <th>Nama</th>
                    <th>Mulai Masuk</th>
                    <th>Waktu Mulai Masuk</th>
                    <th>Terakhir Masuk</th>
                    <th>Mulai Keluar</th>
                    <th>Waktu Mulai Keluar</th>
                    <th>Terakhir Keluar</th>
                    <th>Status</th>
                    <th></th>
                </thead>
            </table>
        </div><!-- end card-body -->
    </div>
@endsection
