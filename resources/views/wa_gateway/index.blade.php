@extends('layouts.ajax')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{ getSetting('web_name') }}</li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" data-toggle="ajax">Dashboard</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            @if ($waDevice['result'] == 'true')
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <p>ID : {{ $waDevice['id'] }}</p>
                                <p>Nomor Telephone : {{ $waDevice['phoneNumber'] }}</p>
                                <p>ID Perangkat : {{ $waDevice['id_device'] }}</p>
                                <p>Token : {{ $waDevice['token'] }}</p>
                                <p>Expired : {{ date('d-m-Y H:i:s', strtotime($waDevice['expired'])) }}</p>
                                <p>Status : <i class='bx bx-check-double text-success'></i> Terhubung</p>
                                <a href="{{ url('https://app.ruangwa.id/devices/view/' . $waDevice['id_device'] . '/1') }}" target="_blank" class="btn btn-primary">Informasi Gateway</a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center">
                    <img src="{{ asset('assets/images/cell_phone.svg') }}" alt="" style="max-width: 300px; width: 100%;">
                    <h5 class="mt-4">Koneksi WA Gateway Terputus, silahkan sambungkan ulang</h5>
                    <p>Pastikan token sudah terisi dengan benar di pengaturan aplikasi !</p>
                    <a href="" class="btn btn-outline-primary mt-3">Reload</a>
                    <a href="https://app.ruangwa.id/devices" class="btn btn-primary mt-3" target="_blank">Sambungkan Perangkat</a>
                </div>
            @endif
        </div>
    </div>
    {{-- @include('announcement.partials.form') --}}
@endsection
