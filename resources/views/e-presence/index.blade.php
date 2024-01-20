@extends('layouts.e-presence')

@section('body')
<div class="card bg-primary m-0 py-4 border-0" style="border-radius: 0;">
    <div class="card-body text-center">
        <img src="{{ asset('assets/images/' . getSetting('logo')) }}" alt="" style="width: 100%; max-width: 100px;">
        <h1 class="text-white mt-4">Selamat Datang di {{  getSetting('web_author') }}</h1>
        <p class="text-white mt-4">
            <h5 class="text-white">
                <span class="date">{{ date('d-m-Y') }}</span> || <span class="time"></span>
            </h5>
        </p>
    </div>
</div>
<div class="container">
    {{-- <div class="row mt-5">
        <div class="col text-center">
            <div class="card d-inline-block p-4 shadow">
                <div class="card-body text-center">
                    {{ generateQRCode('Testing', 250) }}
                    <h2 class="mt-5"><h2 class="mt-5">Absensi Kehadiran</h2></h2>
                </div>
            </div>
        </div>
        <div class="col text-center">
            <div class="card d-inline-block p-4 shadow">
                <div class="card-body text-center">
                    {{ generateQRCode('Hello', 250) }}
                    <h2 class="mt-5">Absensi Pulang</h2>
                </div>
            </div>
        </div>
    </div> --}}
</div>
@endsection

@push('js')
<script src="{{ asset('assets/js/pages/e-presence.js') }}"></script>
@endpush
