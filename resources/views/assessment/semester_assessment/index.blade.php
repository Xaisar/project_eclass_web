@extends('layouts.ajax')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{ getSetting('web_name') }}</li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" data-toggle="ajax">Dashboard</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')
    <div class="mb-4">
        <div class="text-end">
            <button type="button" class="btn btn-light btn-export-excel waves-effect mr-2 waves-light"><i
                    class="fa fa-file-excel"></i>
                Cetak
                Excel</button>
            <button type="button" class="btn btn-light btn-export-pdf waves-effect waves-light"><i class="fa fa-file-pdf"></i>
                Cetak
                PDF</button>
        </div>
    </div>
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Tahun Ajaran</label>
                        <select name="year" class="form-control" id="year">
                            <option value="">Pilih Tahun Ajaran</option>
                            @foreach ($studyYear as $item)
                                <option value="{{ $item->hashid }}">{{ $item->year . '/' . ($item->year + 1) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Semester</label>
                        <select name="semester" class="form-control" id="semester">
                            <option value="">Pilih Semester</option>
                            <option value="1">Ganjil</option>
                            <option value="2">Genap</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Kelas</label>
                        <select name="class_group" class="form-control" id="class_group">
                            <option value="">Pilih Kelas</option>
                            @foreach ($classGroup as $item)
                                <option value="{{ $item->hashid }}">
                                    {{ '(' . $item->degree->degree . ')  ' . $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Pelajaran</label>
                        <select name="course" class="form-control" id="course">
                            <option value="">Pilih Pelajaran</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="no-data">
                <img src="{{ asset('assets/images/illustration/empty.svg') }}" class="mx-auto d-block"
                    style="max-width: 400px" alt="">
                <h4 class="text-center">Opps! Tidak ada data untuk ditampilkan</h4>
            </div>
            <div class="data d-none">
                <table id="dataTable" class="table align-middle datatable dt-responsive table-check nowrap"
                    style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;"
                    data-url="{{ route('semester-assessment.getData') }}" width="100%">
                    <thead class="table-light">
                        <th>No.</th>
                        <th>NIS / NISN</th>
                        <th>Nama Siswa</th>
                        <th>L/P</th>
                        <th>TTL</th>
                        <th>Status</th>
                        <th>Nilai</th>
                    </thead>
                </table>
            </div>
        </div><!-- end card-body -->
    </div>
@endsection
