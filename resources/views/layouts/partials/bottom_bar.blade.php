<div class="bottom-bar fixed-bottom">
  <ul class=" list-unstyled d-flex justify-content-around mt-1">
    <li class="text-center">
      <a href="{{ route('students.dashboard') }}" data-toggle="ajax">
        <i class="mdi mdi-home" style="font-size:24px;"></i>
        <p style="margin-top:-5px;">Home</p>
      </a>
    </li>
    <li class="text-center">
      <a href="{{ route('student.presence') }}" data-toggle="ajax">
        <i class="mdi mdi-qrcode" style="font-size:24px;"></i>
        <p style="margin-top:-5px;">Presensi</p>
      </a>
    </li>
    <li class="text-center">
      <a href="{{ route('students.class-list') }}" data-toggle="ajax">
        <i class="mdi mdi-bookmark" style="font-size:24px;"></i>
        <p style="margin-top:-5px;">Kelas</p>
      </a>
    </li>
    <li class="text-center">
      @can('read-student-dashboard-update-profile')
        <a href="{{ route('students.profile') }}" data-toggle="ajax">
          <i class="mdi mdi-account" style="font-size:24px;"></i>
          <p style="margin-top:-5px;">Profil</p>
        </a>
      @endcan
    </li>
  </ul>
</div>
