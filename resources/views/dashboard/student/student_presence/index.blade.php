@extends('layouts.ajax')

@section('breadcrumb')
  <ol class="breadcrumb">
    <li class="breadcrumb-item">{{ getSetting('web_name') }}</li>
    <li class="breadcrumb-item"><a href="{{ route('students.dashboard') }}" data-toggle="ajax">Dashboard</a></li>
    <li class="breadcrumb-item active">{{ $title }}</li>
  </ol>
@endsection

@section('content')
  <div class="mb-4">
    <div class="text-start">
      <a href="{{ route('students.dashboard') }}" class="btn btn-light waves-effect mr-2 waves-light" data-toggle="ajax"><i
          class="fa fa-arrow-left"></i> Kembali</a>
    </div>
  </div>
  <div class="row">
    <div class="card d-inline-block">
      <div class="card-body">
        <div id="qr-scanner"></div>
      </div>
    </div>
  </div>
@endsection
