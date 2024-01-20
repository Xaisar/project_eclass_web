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
            <table id="dataTable" class="table align-middle datatable dt-responsive table-check nowrap"
                style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;"
                data-url="{{ route('roles.getData') }}" width="100%">
                <thead class="table-light">
                    <th>No.</th>
                    <th>Nama Role</th>
                    <th>Guard</th>
                    <th></th>
                </thead>
            </table>
        </div><!-- end card-body -->
    </div>
@endsection
