<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>

            <div class="page-title-right">
                @yield('breadcrumb')
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

@yield('content')

<script>
    document.title = "{{ $title . ' | ' . getSetting('web_name') }}";

    if (!window.jQuery) {
        document.body.innerHTML = "";
        window.location.reload();
    }
</script>

@if (isset($mods))
    @if (is_array($mods))
        @foreach ($mods as $m)
            <script src="{{ asset('mods/mod_' . $m . '.js') }}"></script>
        @endforeach
    @else
        <script src="{{ asset('mods/mod_' . $mods . '.js') }}"></script>
    @endif
@endif

@yield('_js')
