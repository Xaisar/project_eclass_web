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
        <div class="card-header">
            <h5 class="card-title">Kelola Data Siswa Aktif - Tahun Ajaran
                {{ getStudyYear()->year . ' / ' . (getStudyYear()->year + 1) }}
            </h5>
        </div>
        <div class="card-body">
            <table id="dataTable" class="table align-middle datatable dt-responsive table-check nowrap"
                style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;"
                data-url="{{ route('student-classes.getData') }}" width="100%">
                <thead class="table-light">
                    <th>No</th>
                    <th>Tingkat</th>
                    <th>Jurusan</th>
                    <th>Kelas</th>
                    <th>Jumlah Siswa</th>
                    <th></th>
                </thead>
            </table>
        </div><!-- end card-body -->
    </div>
    @include('student_class.partials.student_class')
@endsection
