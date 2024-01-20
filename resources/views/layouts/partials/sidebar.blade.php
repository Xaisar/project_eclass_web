<ul class="metismenu list-unstyled" id="side-menu">
  @canany(['read-dashboard'])
    <li class="menu-title" data-key="t-menu">Home</li>
  @endcanany
  @can('read-dashboard')
    @role('Guru')
      @if (session()->get('course'))
        <li>
          <a href="{{ route('classroom.home', ['course' => hashId(getClassroomInfo()->id)]) }}" data-toggle="ajax">
            <i data-feather="home"></i>
            <span data-key="t-dashboard">Home</span>
          </a>
        </li>
        <li>
          <a href="{{ route('classroom.activity', ['course' => hashId(getClassroomInfo()->id)]) }}" data-toggle="ajax">
            <i data-feather="activity"></i>
            <span data-key="">Aktifitas Guru</span>
          </a>
        </li>
      @else
        <li>
          <a href="{{ route('teachers.dashboard') }}" data-toggle="ajax">
            <i data-feather="home"></i>
            <span data-key="t-dashboard">Dashboard</span>
          </a>
        </li>
      @endif
    @endrole
    @role('Siswa')
      <li>
        <a href="{{ route('students.dashboard') }}" data-toggle="ajax">
          <i data-feather="home"></i>
          <span data-key="t-dashboard">Dashboard</span>
        </a>
      </li>
    @endrole
    @unlessrole('Siswa|Guru')
      <li>
        <a href="{{ route('admin.dashboard') }}" data-toggle="ajax">
          <i data-feather="home"></i>
          <span data-key="t-dashboard">Dashboard</span>
        </a>
      </li>
    @endunlessrole
  @endcan

  <li class="menu-title" data-key="t-application">Application</li>
  @unlessrole('Guru|Siswa')
    @canany(['create-majors', 'read-class-groups', 'read-teacher'])
      <li>
        <a href="javascript: void(0)" class="has-arrow">
          <i data-feather="grid"></i>
          <span data-key="t-master-data">Master Data</span>
        </a>
        <ul class="submenu" aria-expanded="false">
          @can('create-position')
            <li><a href="{{ route('position') }}" data-toggle="ajax">Data Jabatan</a></li>
          @endcan
          @can('create-majors')
            <li><a href="{{ route('majors') }}" data-toggle="ajax">Data Jurusan</a></li>
          @endcan
          @can('read-class-groups')
            <li><a href="{{ route('class-groups') }}" data-toggle="ajax">Data Kelas</a></li>
          @endcan
          @can('read-teacher')
            <li><a href="{{ route('teacher') }}" data-toggle="ajax">Data Guru</a></li>
          @endcan
          @can('read-teacher')
            <li><a href="{{ route('student') }}" data-toggle="ajax">Data Siswa</a></li>
          @endcan
        </ul>
      </li>
    @endcanany
    @canany(['read-subjects', 'read-study-years'])
      <li>
        <a href="javascript: void(0)" class="has-arrow">
          <i data-feather="bookmark"></i>
          <span data-key="t-lessons">Pelajaran</span>
        </a>
        <ul class="submenu" aria-expanded="false">
          @can('read-subjects')
            <li><a href="{{ route('subjects') }}" data-toggle="ajax">Mata Pelajaran</a></li>
          @endcan
          @can('read-study-years')
            <li><a href="{{ route('study-years') }}" data-toggle="ajax">Tahun Ajaran</a></li>
          @endcan
        </ul>
      </li>
    @endcanany
    @can('read-shift')
      <li>
        <a href="{{ route('shift') }}" data-toggle="ajax">
          <i data-feather="clock"></i>
          <span data-key="t-shift">Shift</span>
        </a>
      </li>
    @endcan
    @can('read-student-classes')
      <li>
        <a href="{{ route('student-classes') }}" data-toggle="ajax">
          <i data-feather="server"></i>
          <span data-key="t-class">Kelas Siswa</span>
        </a>
      </li>
    @endcan
    @can('read-course')
      <li>
        <a href="{{ route('course') }}" data-toggle="ajax">
          <i data-feather="book-open"></i>
          <span data-key="t-course">Course</span>
        </a>
      </li>
    @endcan
    {{-- <li>
            <a href="#" data-toggle="ajax">
                <i data-feather="briefcase"></i>
                <span data-key="t-library">Library</span>
            </a>
        </li> --}}
    @canany(['read-school-present', 'read-admin-class-attendance'])
      <li>
        <a href="javascript: void(0)" class="has-arrow">
          <i data-feather="user-check"></i>
          <span data-key="t-attendance">Presensi Siswa</span>
        </a>
        <ul class="submenu" aria-expanded="false">
          @can('read-admin-class-attendance')
            <li><a href="{{ route('admin.class-attendance') }}" data-toggle="ajax">Presensi Kelas Ajar</a></li>
          @endcan
          @can('read-school-present')
            <li><a href="{{ route('school-presents') }}" data-toggle="ajax">Presensi Sekolah</a></li>
          @endcan
        </ul>
      </li>
    @endcanany
    @canany(['read-semester-assessment'])
      <li>
        <a href="javascript: void(0)" class="has-arrow">
          <i data-feather="award"></i>
          <span data-key="t-student-scores">Nilai Siswa</span>
        </a>
        <ul class="submenu" aria-expanded="false">
          @can('read-semester-assessment')
            <li><a href="{{ route('semester-assessment') }}" data-toggle="ajax">Nilai Semester</a></li>
          @endcan
        </ul>
      </li>
    @endcanany
    @can('read-announcements')
      <li>
        <a href="{{ route('announcements') }}" data-toggle="ajax">
          <i data-feather="volume-2"></i>
          <span data-key="t-announcement">Pengumuman</span>
        </a>
      </li>
    @endcan
    @can('read-wa-gateway')
      <li>
        <a href="{{ route('wa-gateway') }}" data-toggle="ajax">
          <i data-feather="message-circle"></i>
          <span data-key="t-announcement">WA Gateway</span>
        </a>
      </li>
    @endcan
    @canany(['read-users', 'read-roles'])
      <li>
        <a href="javascript: void(0)" class="has-arrow">
          <i data-feather="user"></i>
          <span data-key="t-management-users">Management Users</span>
        </a>
        <ul class="submenu" aria-expanded="false">
          @can('read-users')
            <li><a href="{{ route('users') }}" data-toggle="ajax">Users</a></li>
          @endcan
          @can('read-roles')
            <li><a href="{{ route('roles') }}" data-toggle="ajax">Roles</a></li>
          @endcan
        </ul>
      </li>
    @endcanany
    @canany(['read-settings', 'read-holiday-settings'])
      <li>
        <a href="javascript: void(0)" class="has-arrow">
          <i data-feather="settings"></i>
          <span data-key="t-settings">Settings</span>
        </a>
        <ul class="submenu" aria-expanded="false">
          @can('read-settings')
            <li><a href="{{ route('settings') }}" data-toggle="ajax">Setup Aplikasi</a></li>
          @endcan
          @can('read-holiday-settings')
            <li><a href="{{ route('settings.holiday.index') }}" data-toggle="ajax"> Setup Hari Libur</a></li>
          @endcan
        </ul>
      </li>
    @endcanany
  @endunlessrole

  @role('Guru')
    @if (session()->get('course'))
      @can('read-video-conference')
        <li>
          <a href="{{ route('classroom.video-conference.index', ['course' => hashId(getClassroomInfo()->id)]) }}"
            data-toggle="ajax">
            <i data-feather="video"></i>
            <span data-key="t-teacher-video-conference">Video Conference</span>
          </a>
        </li>
      @endcan
      @can('read-video-conference')
        <li>
          <a href="{{ route('classroom.broadcast_wa.index', ['course' => hashId(getClassroomInfo()->id)]) }}"
            data-toggle="ajax">
            <i data-feather="message-circle"></i>
            <span data-key="t-teacher-video-conference">Broadcast WA</span>
          </a>
        </li>
      @endcan
      @can('read-class-attendance')
        <li>
          <a href="{{ route('classroom.class-attendance.index', ['course' => hashId(getClassroomInfo()->id)]) }}"
            data-toggle="ajax">
            <i data-feather="calendar"></i>
            <span data-key="t-teacher-attendance">Absensi Kelas</span>
          </a>
        </li>
      @endcan
      @can('read-basic-competence')
        <li>
          <a href="{{ route('classroom.basic-competences.index', ['course' => hashId(getClassroomInfo()->id)]) }}"
            data-toggle="ajax">
            <i data-feather="briefcase"></i>
            <span data-key="t-teacher-basic-comptence">Kompetensi Dasar</span>
          </a>
        </li>
      @endcan
      @can('read-lesson-plan')
        <li>
          <a href="{{ route('classroom.lesson-plan.index', ['course' => hashId(getClassroomInfo()->id)]) }}"
            data-toggle="ajax">
            <i data-feather="file-text"></i>
            <span data-key="t-teacher-lesson-plan">Dokumen Penunjang</span>
          </a>
        </li>
      @endcan
      @can('read-student-incident')
        <li>
          <a href="{{ route('classroom.student-incidents', ['course' => hashId(getClassroomInfo()->id)]) }}"
            data-toggle="ajax">
            <i data-feather="alert-triangle"></i>
            <span data-key="t-teacher-student-incident">Kejadian Siswa</span>
          </a>
        </li>
      @endcan
      @can('create-teaching-materials')
        <li>
          <a href="{{ route('classroom.teaching-materials', ['course' => hashId(getClassroomInfo()->id)]) }}"
            data-toggle="ajax">
            <i data-feather="book-open"></i>
            <span data-key="t-teacher-materials">Materi / Bahan Ajar</span>
          </a>
        </li>
      @endcan
      @can('read-student-class-list')
        <li>
          <a href="{{ route('classroom.students', ['course' => hashId(getClassroomInfo()->id)]) }}" data-toggle="ajax">
            <i data-feather="users"></i>
            <span data-key="t-teacher-student-lists">Daftar Siswa Kelas</span>
          </a>
        </li>
      @endcan
      @canany(['read-teacher-skill-assessment', 'read-teacher-semester-assessment', 'read-teacher-knowledge-assessment'])
        <li>
          <a href="javascript: void(0)" class="has-arrow">
            <i data-feather="clipboard"></i>
            <span data-key="t-teacher-score">Penilaian</span>
          </a>
          <ul class="submenu" aria-expanded="false">
            @can('read-teacher-knowledge-assessment')
              <li><a href="{{ route('classroom.knowledge-assessments', ['course' => hashId(getClassroomInfo()->id)]) }}"
                  data-toggle="ajax"> Pengetahuan</a></li>
            @endcan
            @can('read-teacher-skill-assessment')
              <li><a href="{{ route('classroom.skill-assessments', ['course' => hashId(getClassroomInfo()->id)]) }}"
                  data-toggle="ajax"> Keterampilan</a></li>
            @endcan
            @can('read-teacher-semester-assessment')
              <li><a href="{{ route('classroom.semester-assessments', ['course' => hashId(getClassroomInfo()->id)]) }}"
                  data-toggle="ajax"> Semester</a></li>
            @endcan
          </ul>
        </li>
      @endcanany
      @can('read-monitoring-activity')
        <li>
          <a href="{{ route('classroom.activity-monitoring', ['course' => hashId(getClassroomInfo()->id)]) }}"
            data-toggle="ajax">
            <i data-feather="monitor"></i>
            <span data-key="t-teacher-activity">Monitor Aktifitas</span>
          </a>
        </li>
      @endcan
      @can('read-course-setting')
        <li>
          <a href="{{ route('classroom.settings', ['course' => hashId(getClassroomInfo()->id)]) }}" data-toggle="ajax">
            <i data-feather="settings"></i>
            <span data-key="t-teacher-settings">Pengaturan Kelas</span>
          </a>
        </li>
      @endcan
      <li>
        <a href="{{ route('classroom.signout') }}">
          <i data-feather="log-out"></i>
          <span data-key="t-teacher-settings">Keluar Kelas</span>
        </a>
      </li>
    @else
      <li>
        <a href="#" data-toggle="ajax">
          <i data-feather="bookmark"></i>
          <span data-key="t-teacher-lessons">Mata Pelajaran <small>{{ '(On Proses)' }}</small></span>
        </a>
      </li>
      <li>
        <a href="#" data-toggle="ajax">
          <i data-feather="book-open"></i>
          <span data-key="t-teacher-work-book">Buku Kerja <small>{{ '(On Proses)' }}</small></span>
        </a>
      </li>
      {{-- <li>
                <a href="#" data-toggle="ajax">
                    <i data-feather="user-check"></i>
                    <span data-key="t-teacher-attendance">Absensi</span>
                </a>
            </li> --}}
      <li>
        <a href="#" data-toggle="ajax">
          <i data-feather="bar-chart-2"></i>
          <span data-key="t-teacher-progress">Progress Anda <small>{{ '(On Proses)' }}</small></span>

        </a>
      </li>
    @endif
  @endrole
</ul>
