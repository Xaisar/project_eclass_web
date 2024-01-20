@extends('layouts.ajax')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{ getSetting('web_name') }}</li>
        <li class="breadcrumb-item"><a href="{{ route('teachers.dashboard') }}" data-toggle="ajax">Dashboard</a></li>
        <li class="breadcrumb-item active">Kalender Tugas</li>
    </ol>
@endsection

@section('content')

<div class="card shadow-sm mb-3">
    <div class="card-body">
        <div id="calendar"></div>
    </div>
</div>

@endsection
