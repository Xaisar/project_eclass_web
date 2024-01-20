@extends('layouts.base')

@section('content')

    @yield('body')

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

    <script src="{{ asset('assets/js/pages/moment.min.js') }}"></script>
    {{-- dropzone --}}
    <script src="{{asset('assets/libs/dropzone/min/dropzone.min.js')}}"></script>

   @stack('js')
@endsection
