@extends('layouts.ajax')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{ getSetting('web_name') }}</li>
        <li class="breadcrumb-item"><a href="{{ route('classroom.home', ['course' => hashId(getClassroomInfo()->id)]) }}"
                data-toggle="ajax">{{ getClassroomInfo()->classGroup->degree->degree .' ' .getClassroomInfo()->classGroup->name .'_' .getClassroomInfo()->subject->name }}</a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('classroom.video-conference.index', ['course' => hashId(getClassroomInfo()->id)]) }}"
            data-toggle="ajax">Video Conference</a>
    </li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <button class="btn btn-danger d-block back-btn d-sm-block d-none" data-href="{{ route('classroom.video-conference.index', ['course' => hashId(getClassroomInfo()->id)]) }}">
                    <i class='bx bx-arrow-back' ></i>
                    Kembali
                </button>
                <div class="text-center">
                    <h4 class="mb-0 mt-2">
                        <b>{{ $videoConference->name }}</b>
                    </h4>
                    <span>Kode Meeting : {{ $videoConference->code }}</span>
                </div>
                <div class="text-right">
                    <button class="btn btn-success h-100 d-inline-block copy-link d-none d-sm-inline-block" {{ $videoConference->end_time ? 'disabled' : '' }}>
                        <i class='bx bx-clipboard' ></i>
                        Copy Link
                    </button>
                    <button class="btn btn-primary h-100 d-inline-block end-btn" {{ $videoConference->end_time ? 'disabled' : '' }}>
                        <i class='bx bx-check-circle' ></i>
                        Selesai
                    </button>
                </div>
            </div>
        </div><!-- end card-body -->
    </div>
    @if(!$videoConference->end_time)
        @if(strtotime($videoConference->start_time) < time())
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <div id="meet" style="height: 75vh;"></div>
                </div>
            </div>
            <input type="hidden" id="room-name" value="{{ $videoConference->name . ' - ' . getClassroomInfo()->classGroup->degree->degree .' ' .getClassroomInfo()->classGroup->name .' ' .getClassroomInfo()->subject->name }}">
            <input type="hidden" id="email" value="{{ auth()->user()->email }}">
            <input type="hidden" id="name" value="{{ auth()->user()->name }}">
            <input type="hidden" id="meet-code" value="{{ $videoConference->code }}">
            <input type="hidden" id="course-id" value="{{ hashId(getClassroomInfo()->id) }}">
            <input type="hidden" id="video-conference-id" value="{{ $videoConference->hashid }}">
            <input type="hidden" id="end-meet-url" value="{{ route('classroom.video-conference.end-conference', ['course' => hashId(getClassroomInfo()->id), 'videoConference' => $videoConference->hashid]) }}">
        @else
        <div class="text-center my-5">
            <img src="{{ asset("assets/images/oops-pana.svg") }}" alt="" style="max-width: 550px; width: 100%;">
            <h1 class="mt-5">Meet ini Belum Bisa Dimulai 😢</h1>
            <p class="mt-3">Meet akan dibuka saat {{ date('d-m-Y H:i', strtotime($videoConference->start_time)) }}</p>
        </div>
        @endif
    @else
        <div class="text-center my-5">
            <img src="{{ asset("assets/images/oops-pana.svg") }}" alt="" style="max-width: 550px; width: 100%;">
            <h1 class="mt-5">Opps ! Meet ini sudah berakhir 😢</h1>
            <p>Penyelenggara telah mengakhiri meet ini</p>
        </div>
    @endif
@endsection

