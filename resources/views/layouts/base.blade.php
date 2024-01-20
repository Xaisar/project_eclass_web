<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>{{ $title }} | {{ getSetting('web_name') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="Learning Management System SMA Negeri 1 Cluring" name="description" />
  <meta content="Themesbrand" name="author" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="base-url" content="{{ url('/') }}">
  <meta name="user-permissions" content="{!! getAuthPermissions() !!}">
  <meta name="theme-color" content="#4549a2" />
  <!-- App favicon -->
  <link rel="shortcut icon" href="{{ asset('assets/images/' . getSetting('favicon')) }}">
  <link rel="apple-touch-icon" href="{{ asset('assets/images/' . getSetting('favicon')) }}">
  <link rel="manifest" href="{{ asset('manifest.json') }}">

  <!-- plugin css -->
  <link href="{{ asset('assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet"
    type="text/css" />
  <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/libs/select2/select2.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet"
    type="text/css" />
  <link href="{{ asset('assets/libs/dropify/css/dropify.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/libs/@fullcalendar/core/main.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/libs/@fullcalendar/daygrid/main.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/libs/@fullcalendar/bootstrap/main.min.css') }}" rel="stylesheet" type="text/css" />

  {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css"> --}}

  <!-- DataTables -->
  <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
    type="text/css" />
  <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
    type="text/css" />

  <!-- Responsive datatable examples -->
  <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
    rel="stylesheet" type="text/css" />
  <!-- datepicker css -->
  <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}">

  {{-- dropzone css --}}
  <link href="{{ asset('assets/libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
  <!-- preloader css -->
  <link rel="stylesheet" href="{{ asset('assets/css/preloader.min.css') }}" type="text/css" />

  <!-- Bootstrap Css -->
  <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
  <!-- Icons Css -->
  <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
  <!-- App Css-->
  <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
  <link href="{{ asset('assets/css/style.css') }}" id="app-style" rel="stylesheet" type="text/css" />
</head>

<body @role('Siswa') data-layout="horizontal" @endrole>
  @yield('content')
</body>

</html>
