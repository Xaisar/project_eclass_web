@extends('layouts.ajax')

@section('content')
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <button class="btn btn-danger d-block back-btn" data-href="{{ route('students.dashboard') }}">
                    <i class='bx bx-arrow-back'></i>
                    Kembali
                </button>
                <div class="text-center">
                    <h4 class="mb-0 mt-2">
                        <b>{{ $videoConference->name }}</b>
                    </h4>
                    <span>Kode Meeting : {{ $videoConference->code }}</span>
                </div>
                <div class="text-right"></div>
            </div>
        </div><!-- end card-body -->
    </div>
    @if (!$videoConference->end_time)
        @if (strtotime($videoConference->start_time) < time())
            @if ($videoConference->started_at)
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <div id="meet" style="height: 75vh;"></div>
                    </div>
                </div>
                <input type="hidden" id="room-name"
                    value="{{ $videoConference->name .' - ' .$videoConference->course->classGroup->degree->degree .' ' .$videoConference->course->classGroup->name .' ' .$videoConference->course->subject->name }}">
                <input type="hidden" id="email" value="{{ auth()->user()->email }}">
                <input type="hidden" id="name" value="{{ auth()->user()->name }}">
                <input type="hidden" id="meet-code" value="{{ $videoConference->code }}">
            @else
                <div class="text-center my-5">
                    <img src="{{ asset('assets/images/oops-pana.svg') }}" alt="" style="max-width: 350px; width: 100%;">
                    <h2 class="mt-5">Meet ini Belum Dimulai 😢</h2>
                    <p class="mt-3">Sabar ya ! Host akan segera memulai meet. Klik tombol Refresh dibawah untuk
                        melakukan cek ulang status meet</p>
                    <button class="refresh-btn btn btn-primary">Refresh</button>
                </div>
            @endif
        @else
            <div class="text-center my-5">
                <img src="{{ asset('assets/images/oops-pana.svg') }}" alt="" style="max-width: 350px; width: 100%;">
                <h2 class="mt-5">Meet ini Belum Dibuka 😢</h2>
                <p class="mt-3">Meet akan dibuka saat
                    {{ date('d-m-Y H:i', strtotime($videoConference->start_time)) }}</p>
            </div>
        @endif
    @else
        <div class="text-center my-5">
            <img src="{{ asset('assets/images/oops-pana.svg') }}" alt="" style="max-width: 350px; width: 100%;">
            <h2 class="mt-5">Opps ! Meet ini sudah berakhir 😢</h2>
            <p>Penyelenggara telah mengakhiri meet ini</p>
        </div>
    @endif
@endsection
