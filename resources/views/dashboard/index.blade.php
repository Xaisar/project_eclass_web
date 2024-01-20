@extends('layouts.ajax')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{ getSetting('web_name') }}</li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')

    @unlessrole('Guru|Siswa')
        @include('dashboard.admin.dashboard')
    @endunlessrole
    @role('Guru')
        @include('dashboard.teacher.dashboard')
    @endrole
    @role('Siswa')
        @include('dashboard.student.dashboard')
    @endrole

@endsection
