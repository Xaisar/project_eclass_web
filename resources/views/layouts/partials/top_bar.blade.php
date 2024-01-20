<div class="navbar-header">
  <div class="d-flex">
    <!-- LOGO -->
    <div class="navbar-brand-box">
      @can('read-dashboard')
        @role('Guru')
          @if (session()->get('course'))
            <a class="logo logo-dark" href="{{ route('classroom.home', ['course' => hashId(getClassroomInfo()->id)]) }}"
              data-toggle="ajax">
            @else
              <a class="logo logo-dark" href="{{ route('teachers.dashboard') }}" data-toggle="ajax">
          @endif
        @endrole
        @role('Siswa')
          <a class="logo logo-dark" href="{{ route('students.dashboard') }}" data-toggle="ajax">
          @endrole
          @unlessrole('Siswa|Guru')
            <a class="logo logo-dark" href="{{ route('admin.dashboard') }}" data-toggle="ajax">
            @endunlessrole
            {{-- <a href="#" class="logo logo-dark"> --}}
            <span class="logo-sm">
              <img src="{{ asset('assets/images/' . getSetting('logo')) }}" alt="" height="28">
            </span>
            <span class="logo-lg">
              <img src="{{ asset('assets/images/' . getSetting('logo')) }}" alt="" height="28"> <span
                class="logo-txt">E-Learning</span>
            </span>
          </a>
        @endcan
        @can('read-dashboard')
          @role('Guru')
            @if (session()->get('course'))
              <a class="logo logo-light" href="{{ route('classroom.home', ['course' => hashId(getClassroomInfo()->id)]) }}"
                data-toggle="ajax">
              @else
                <a class="logo logo-light" href="{{ route('teachers.dashboard') }}" data-toggle="ajax">
            @endif
          @endrole
          @role('Siswa')
            <a class="logo logo-light" href="{{ route('students.dashboard') }}" data-toggle="ajax">
            @endrole
            @unlessrole('Siswa|Guru')
              <a class="logo logo-light" href="{{ route('admin.dashboard') }}" data-toggle="ajax">
              @endunlessrole
              {{-- <a href="#" class="logo logo-light"> --}}
              <span class="logo-sm">
                <img src="{{ asset('assets/images/' . getSetting('logo')) }}" alt="" height="28">
              </span>
              <span class="logo-lg">
                <img src="{{ asset('assets/images/' . getSetting('logo')) }}" alt="" height="28"> <span
                  class="logo-txt">E-Learning</span>
              </span>
            </a>
          @endcan
    </div>

    @unlessrole('Siswa')
      <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
      </button>
    @endunlessrole

  </div>

  <div class="d-flex">

    <div class="dropdown d-none d-sm-inline-block">
      <button type="button" class="btn header-item" id="mode-setting-btn">
        <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
        <i data-feather="sun" class="icon-lg layout-mode-light"></i>
      </button>
    </div>
    <div class="dropdown d-sm-inline-block">
      @if (getInfoLogin()->roles[0]->name == 'Siswa')
        <button type="button" data-toggle="ajax" data-target="{{ route('students.calendar') }}"
          class="btn header-item" id="">
          <i data-feather="calendar" class="icon-lg"></i>
        </button>
      @elseif (getInfoLogin()->roles[0]->name == 'Guru')
        <button type="button" class="btn header-item" data-toggle="ajax"
          data-target="{{ route('teachers.calendar') }}" id="">
          <i data-feather="calendar" class="icon-lg"></i>
        </button>
      @endif
    </div>

    @php
      $allNotifications = getNotifications(Auth::user());
      $unreadedNotifications = getNotifications(Auth::user(), 0, false);
    @endphp

    @unlessrole('Administrator|Developer')
      <div class="dropdown d-inline-block">
        <button type="button" class="btn header-item noti-icon position-relative" id="page-header-notifications-dropdown"
          data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i data-feather="bell" class="icon-lg"></i>
          @if ($unreadedNotifications->count() > 0)
            <span
              class="badge bg-danger rounded-pill unread-notifications-count">{{ $unreadedNotifications->count() }}</span>
          @endif
        </button>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
          aria-labelledby="page-header-notifications-dropdown">
          <div class="p-3">
            <div class="row align-items-center">
              <div class="col">
                <h6 class="m-0"> Notifications </h6>
              </div>
              <div class="col-auto">
                <a href="{{ route('notifications.read-all', ['user' => Auth::user()->hashid]) }}"
                  class="small text-reset text-decoration-underline read-all-notifications"> Read All
                  ({{ $unreadedNotifications->count() }})</a>
              </div>
            </div>
          </div>
          <div data-simplebar style="max-height: 230px;">
            @forelse (getNotifications(Auth::user()) as $notification)
              <a href="{{ $notification->path }}" class="text-reset notification-item" data-toggle="ajax">
                <div class="d-flex">
                  <div class="flex-shrink-0 me-3">
                    <i class='bx bxs-bell notification-icon {{ $notification->is_read ? 'text-secondary' : 'text-primary' }}'
                      style="font-size: 25px;"></i>
                  </div>
                  <div class="flex-grow-1">
                    <h6 class="mb-1">{{ $notification->name }}</h6>
                    <div class="font-size-13 text-muted">
                      <p class="mb-1">{{ $notification->message }}</p>
                      <p class="mb-0">
                        <i class="mdi mdi-clock-outline"></i>
                        <span>{{ $notification->created_at->diffInDays(getCurrentTime()) > 4 ? $notification->created_at->format('d M Y H:i') : $notification->created_at->diffForHumans() }}</span>
                      </p>
                    </div>
                  </div>
                </div>
              </a>
            @empty
              <h5 class="text-center mt-3 mb-4">There's no Notifications</h5>
            @endforelse
          </div>
        </div>
      </div>
    @endunlessrole

    <div class="dropdown d-inline-block">
      <button type="button" class="btn header-item bg-soft-light border-start border-end"
        id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        @if (!getClassroomInfo())
          <img class="rounded-circle header-profile-user"
            src="{{ asset('assets/images/users/' . getInfoLogin()->picture) }}" alt="Header Avatar">
          <span class="d-none d-xl-inline-block ms-1 fw-medium">{{ getInfoLogin()->name }}</span>
        @else
          <span
            class="d-none d-xl-inline-block ms-1 fw-medium">{{ getClassroomInfo()->classGroup->degree->degree . ' ' . getClassroomInfo()->classGroup->name . '_' . getClassroomInfo()->subject->name }}</span>
        @endif
        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
      </button>
      <div class="dropdown-menu dropdown-menu-end">
        <!-- item-->
        @if (!getClassroomInfo())
          <a class="dropdown-item"
            href="{{ getInfoLogin()->roles[0]->name == 'Guru' ? route('teachers.profile') : (getInfoLogin()->roles[0]->name == 'Siswa' ? route('students.profile') : route('admin.profile')) }}"><i
              class="mdi mdi-account font-size-16 align-middle me-1"></i> Profile</a>
          <a class="dropdown-item"
            href="{{ getInfoLogin()->roles[0]->name == 'Guru' ? route('teachers.update-password', Hashids::encode(getInfoLogin()->id)) : (getInfoLogin()->roles[0]->name == 'Siswa' ? route('students.update-password', Hashids::encode(getInfoLogin()->id)) : route('users.update-password', Hashids::encode(getInfoLogin()->id))) }}"><i
              class="mdi mdi-lock font-size-16 align-middle me-1"></i> Password</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('auth.logout') }}" data-toggle="confirm"
            data-message="Apakah anda yakin ingin keluar?" data-redirect="true"><i
              class="mdi mdi-logout font-size-16 align-middle me-1"></i> Logout</a>
        @else
          <a class="dropdown-item"
            href="{{ route('classroom.settings', ['course' => hashId(getClassroomInfo()->id)]) }}"
            data-toggle="ajax"><i class="mdi mdi-account font-size-16 align-middle me-1"></i>
            Pengaturan Kelas</a>
          <a class="dropdown-item" href="{{ route('classroom.signout') }}"><i
              class="mdi mdi-logout font-size-16 align-middle me-1"></i> Keluar Kelas</a>
        @endif
      </div>
    </div>

  </div>
</div>
