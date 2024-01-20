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
                    @can('delete-student')
                        <button class="btn btn-danger mx-1 d-none" id="bulkDelete"><i class="fa fa-trash-alt"></i> Delete</button>
                    @endcan
                    @can('create-student')
                        <button class="btn btn-dark add waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-upload"></i> Import Siswa</button>
                        <button class="btn btn-primary add waves-effect waves-light" data-toggle="ajax" data-target="{{ route('student.create') }}"><i class="fa fa-plus"></i> Tambah Siswa
                            Baru</button>
                    @endcan
                </div>
            </div>
            <table id="dataTable" class="table align-middle datatable dt-responsive table-check nowrap"
                style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;"
                data-url="{{ route('student.getData') }}" width="100%">
                <thead class="table-light">
                    <th style="width: 30px;">
                        <div class="form-check font-size-16">
                            <input type="checkbox" name="check" class="form-check-input" id="checkAll">
                            <label class="form-check-label" for="checkAll"></label>
                        </div>
                    </th>
                    <th>Nama Siswa</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th></th>
                </thead>
            </table>
        </div><!-- end card-body -->
    </div>

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('student.import') }}" method="post" data-request="ajax" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-upload"></i> Import Data Siswa</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <a href="{{ route('student.download-template') }}" target="_blank" class="btn btn-rounded shadow btn-outline-success btn-sm"><i class="fa fa-download"></i> Download Template</a>
                        </div>
                        <div class="mb-3">
                            <label for="">File <span class="text-danger">*</span></label>
                            <input type="file" name="file" id="input-file-now" class="dropify" />
                            <p class="text-muted small">Keterangan : Upload file dengan format (.xlx, .xlsx, .csv).</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
