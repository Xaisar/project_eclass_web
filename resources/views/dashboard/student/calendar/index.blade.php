@extends('layouts.ajax')

@section('breadcrumb')
  <ol class="breadcrumb">
    <li class="breadcrumb-item">{{ getSetting('web_name') }}</li>
    <li class="breadcrumb-item"><a href="{{ route('students.dashboard') }}" data-toggle="ajax">Dashboard</a></li>
    <li class="breadcrumb-item active">Kalender Tugas</li>
  </ol>
@endsection

@section('content')
  <div class="mb-4">
    <div class="text-start">
      <a href="{{ route('students.dashboard') }}" class="btn btn-light waves-effect mr-2 waves-light" data-toggle="ajax"><i
          class="fa fa-arrow-left"></i> Kembali</a>
    </div>
  </div>
  <div class="card shadow-sm mb-3">
    <div class="card-body">
      <div id="calendar"></div>
    </div>
  </div>
@endsection
