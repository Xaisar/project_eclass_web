@extends('layouts.auth')

@section('content-view')
  <div class="auth-page">
    <div class="container-fluid">
      <div class="auth-bg pt-md-5 p-4 d-flex justify-content-center">
        <div class="bg-overlay bg-primary"></div>
        <ul class="bg-bubbles">
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
        </ul>
        <!-- end bubble effect -->

        <div class="row justify-content-center align-items-center">
          <div class="bg-light auth-full-page-content d-flex p-sm-5 p-5" style="min-height:400px;">
            <div class="d-flex flex-column">
              <div class="text-center">
                <a href="#" class="d-block auth-logo">
                  <img src="{{ asset('assets/images/' . getSetting('logo')) }}" alt="" height="40">
                  <span class="logo-txt">{{ getSetting('web_name') }}</span>
                </a>
              </div>
              <div class="auth-content my-auto">
                <div class="text-center">
                  <h5 class="mt-4 mb-2">Welcome Back !</h5>
                  <p class="text-muted mt-2">Sign in to continue to App.</p>
                </div>
                @if (session('success'))
                  <div class="alert alert-success text-center my-2" role="alert">
                    {{ session('success') }}
                  </div>
                @endif
                @if (session('error'))
                  <div class="alert alert-danger text-center my-2" role="alert">
                    {{ session('error') }}
                  </div>
                @endif
                <form class="mt-2 pt-2" action="{{ route('auth.check') }}" method="post" data-request="ajax"
                  data-success-callback="{{ route('dashboard') }}" data-redirect="true">
                  <div class="form-group mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" id="username" placeholder="Enter username"
                      autocomplete="off">
                  </div>
                  <div class="from-group mb-3">
                    <div class="d-flex align-items-start">
                      <div class="flex-grow-1">
                        <label class="form-label">Password</label>
                      </div>
                      <div class="flex-shrink-0">
                        <div class="">
                          <a href="{{ route('auth.forgot-password') }}" class="text-muted">Forgot
                            password?</a>
                        </div>
                      </div>
                    </div>

                    <div class="input-group auth-pass-inputgroup">
                      <input type="password" name="password" class="form-control" placeholder="Enter password"
                        aria-label="Password" aria-describedby="password-addon">
                      {{-- <button class="btn btn-light shadow-none ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button> --}}
                    </div>
                  </div>
                  <div class="row mb-2">
                    <div class="col">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember-check">
                        <label class="form-check-label" for="remember-check">
                          Remember me
                        </label>
                      </div>
                    </div>

                  </div>
                  <div class="mb-5">
                    <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Log
                      In</button>
                  </div>
                </form>
                <div class="text-center mt-5">
                  <script>
                    document.write(new Date().getFullYear())
                  </script> {{ getSetting('copyright') }}</p>
                </div>
              </div>
            </div>
          </div>
          <!-- end auth full page content -->
        </div>
      </div>
      <!-- end row -->
    </div>
    <!-- end container fluid -->
  </div>
@endsection
