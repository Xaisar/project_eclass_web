@extends('layouts.ajax')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item">{{ getSetting('web_name') }}</li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" data-toggle="ajax">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('shift') }}" data-toggle="ajax">Data Shift</a></li>
    <li class="breadcrumb-item active">{{$title}}</li>
</ol>
@endsection

@section('content')

<div class="col-md-5">
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <form action="{{ $action }}" method="post" data-request="ajax" data-success-callback="{{ route('shift') }}">
                @csrf
                <div class="mb-3">
                    <label for="">Nama</label>
                    <input type="text" name="name" class="form-control" placeholder="Nama" autocomplete="off" value="{{ isset($values) ? $values->name : '' }}">
                </div>
                <div class="mb-3">
                    <label for="">Mulai Masuk</label>
                    <input type="time" name="start_entry" class="form-control" placeholder="Mulai Masuk" autocomplete="off" value="{{ isset($values) ? $values->start_entry : '' }}">
                </div>
                <div class="mb-3">
                    <label for="">Waktu Mulai Masuk</label>
                    <input type="time" name="start_time_entry" class="form-control" placeholder="Waktu Mulai Masuk" autocomplete="off" value="{{ isset($values) ? $values->start_time_entry : '' }}">
                </div>
                <div class="mb-3">
                    <label for="">Terakhir Masuk</label>
                    <input type="time" name="last_time_entry" class="form-control" placeholder="Terakhir Masuk" autocomplete="off" value="{{ isset($values) ? $values->last_time_entry : '' }}">
                </div>
                <div class="mb-3">
                    <label for="">Mulai Keluar</label>
                    <input type="time" name="start_exit" class="form-control" placeholder="Mulai Keluar" autocomplete="off" value="{{ isset($values) ? $values->start_exit : '' }}">
                </div>
                <div class="mb-3">
                    <label for="">Waktu Mulai Keluar</label>
                    <input type="time" name="start_time_exit" class="form-control" placeholder="Waktu Mulai Keluar" autocomplete="off" value="{{ isset($values) ? $values->start_time_exit : '' }}">
                </div>
                <div class="mb-3">
                    <label for="">Terakhir Keluar</label>
                    <input type="time" name="last_time_exit" class="form-control" placeholder="Terakhir Keluar" autocomplete="off" value="{{ isset($values) ? $values->last_time_exit : '' }}">
                </div>
                @if(isset($values))
                <div class="mb-3">
                    <label for="">Status</label>
                    <select name="status" class="form-control js-choices">
                        <option value="1" {{ isset($values) && $values->status == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ isset($values) && $values->status == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                @endif
                <div class="mb-3 text-end">
                    <button class="btn btn-danger" type="button" data-toggle="ajax" data-target="{{ route('shift') }}">Kembali</button>
                    <button class="btn btn-primary" type="submit"><i class="fa fa-paper-plane"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection