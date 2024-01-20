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
        <a href="" id="printExcel" target="_blank" class="btn btn-light btn-export-excel waves-effect mr-2 waves-light"><i
                class="fa fa-file-excel"></i>
            Cetak
            Excel</a>
        <a href="" id="printPdf" target="_blank" class="btn btn-light btn-export-pdf waves-effect waves-light"><i class="fa fa-file-pdf"></i>
            Cetak
            PDF</a>
    </div>
</div>
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Tahun Ajaran</label>
                    <select name="year" class="form-control js-choices" id="year">
                        <option value="">Pilih Tahun Ajaran</option>
                        @foreach ($studyYear as $item)
                            <option value="{{ $item->hashid }}">{{ $item->year . '/' . ($item->year + 1) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Bulan</label>
                    <select name="month" class="form-control" id="month">
                        <option value="">Pilih Bulan</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Kelas</label>
                    <select name="course" class="form-control js-choices" id="class_group">
                        <option value="">Pilih Kelas</option>
                        @foreach ($classGroup as $item)
                            <option value="{{ $item->hashid }}">
                                {{ '(' . $item->degree->degree . ')  ' . $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="no-data">
            <img src="{{ asset('assets/images/illustration/empty.svg') }}" class="mx-auto d-block"
                style="max-width: 400px" alt="">
            <h4 class="text-center">Opps! Tidak ada data untuk ditampilkan</h4>
        </div>
        <div class="d-none" id="viewData"></div>
    </div><!-- end card-body -->
</div>

@endsection