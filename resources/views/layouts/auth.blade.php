@extends('layouts.base')

@section('content')

@yield('content-view')

<div style="z-index: 11">
    <div id="toast-primary" class="toast overflow-hidden mt-3" role="alert" aria-live="assertive"
        aria-atomic="true" style="position: absolute;top: 0;right: 10px;">
        <div class="align-items-center text-white bg-primary border-0">
            <div class="d-flex">
                <div class="toast-body"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
</div>

<div style="z-index: 11">
    <div id="toast-success" class="toast overflow-hidden mt-3" role="alert" aria-live="assertive"
        aria-atomic="true" style="position: absolute;top: 0;right: 10px;">
        <div class="align-items-center text-white bg-success border-0">
            <div class="d-flex">
                <div class="toast-body"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
</div>

<div style="z-index: 11">
    <div id="toast-warning" class="toast overflow-hidden mt-3" role="alert" aria-live="assertive"
        aria-atomic="true" style="position: absolute;top: 0;right: 10px;">
        <div class="align-items-center text-white bg-warning border-0">
            <div class="d-flex">
                <div class="toast-body"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
</div>

<div style="z-index: 11">
    <div id="toast-danger" class="toast overflow-hidden mt-3" role="alert" aria-live="assertive"
        aria-atomic="true" style="position: absolute;top: 0;right: 10px;">
        <div class="align-items-center text-white bg-danger border-0">
            <div class="d-flex">
                <div class="toast-body"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
</div>

<!-- JAVASCRIPT -->
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
<!-- pace js -->
<script src="{{ asset('assets/libs/pace-js/pace.min.js') }}"></script>
<!-- password addon init -->
<script src="{{ asset('assets/js/pages/pass-addon.init.js') }}"></script>
<script src="{{ asset('mods/mod_main.js') }}"></script>

{{-- dropzone --}}
<script src="{{asset('assets/libs/dropzone/min/dropzone.min.js')}}"></script>

@endsection
