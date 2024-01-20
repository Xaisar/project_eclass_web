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
                    @can('delete-users')
                        <button class="btn btn-danger mx-1 d-none" id="bulkDelete"><i class="fa fa-trash-alt"></i> Delete</button>
                    @endcan
                    @can('create-users')
                        <button class="btn btn-light waves-effect waves-light" data-toggle="ajax"
                            data-target="{{ route('users.create') }}"><i class="fa fa-plus"></i> Tambah User Baru</button>
                    @endcan
                </div>
            </div>
            <table id="dataTable" class="table align-middle datatable dt-responsive table-check nowrap"
                style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;"
                data-url="{{ route('users.getData') }}" width="100%">
                <thead class="table-light">
                    <th style="width: 30px;">
                        <div class="form-check font-size-16">
                            <input type="checkbox" name="check" class="form-check-input" id="checkAll">
                            <label class="form-check-label" for="checkAll"></label>
                        </div>
                    </th>
                    <th>ID Chat Channel</th>
                    <th>Nama User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Online</th>
                    <th>Status</th>
                    <th></th>
                </thead>
            </table>
        </div><!-- end card-body -->
    </div>

@endsection
