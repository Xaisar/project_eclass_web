@foreach ($announcements as $announcement)
  <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show" role="alert">
    <i class="mdi mdi-information-outline label-icon"></i>
    <strong>{{ $announcement->title }}</strong><br>
    {{ $announcement->content }}
  </div>
@endforeach

<div class="row">
  <div class="col-xl-9 col-lg-12">
    <div class="row">
      <div class="col-xl-6 col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-sm order-2 order-sm-1">
                <div class="d-flex align-items-start mt-3 mt-sm-0">
                  <div class="flex-shrink-0">
                    <div class="avatar-xl me-3">
                      <img src="{{ asset('assets/images/users/' . getInfoLogin()->picture) }}" alt=""
                        class="img-fluid rounded-circle d-block">
                    </div>
                  </div>
                  <div class="flex-grow-1">
                    <div>
                      <h5 class="font-size-16 mb-1">{{ getInfoLogin()->name }}</h5>
                      <p class="text-muted font-size-13">
                        {{ getInfoLogin()->userable->identity_number }}
                      </p>

                      <div class="d-flex flex-wrap align-items-start gap-2 gap-lg-3 text-muted font-size-13">
                        <div><i
                            class="mdi mdi-card-account-phone me-1 align-middle"></i>{{ getInfoLogin()->userable->phone_number }}
                        </div>
                        <div><i class="mdi mdi-email me-1 align-middle"></i>{{ getInfoLogin()->userable->email }}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-auto order-1 order-sm-2 d-md-block d-none">
                <div class="d-flex align-items-start justify-content-end gap-2">
                  <div>
                    @can('read-student-dashboard-update-profile')
                      <button data-toggle="ajax" data-target="{{ route('students.profile') }}" type="button"
                        class="btn btn-soft-light">
                        <i class="mdi me-1 mdi-account-edit-outline"></i>
                        Edit Profile</button>
                    @endcan
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end card body -->
        </div>
      </div>
      <div class="col-xl-4 col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-sm order-2 order-sm-1">
                <div class="d-flex align-items-start mt-3 mt-sm-0">
                  <div class="flex-grow-1">
                    <div>
                      <h5 class="font-size-16 mb-1"> Kelas
                        {{ getStudentInfo()->studentClass[0]->classGroup->degree->degree . ' ' . getStudentInfo()->studentClass[0]->classGroup->name }}
                      </h5>
                      </h5>
                      <p class="text-muted font-size-13">
                        Semester {{ getStudyYear()->semester == 1 ? 'Ganjil' : 'Genap' }}
                        |
                        {{ getStudyYear()->year . '/' . (getStudyYear()->year + 1) }}
                      </p>

                      <div class="d-flex flex-wrap align-items-start gap-2 gap-lg-3 text-muted font-size-13">
                        <div><i
                            class="mdi mdi-book-education me-1 align-middle"></i>{{ getStudentInfo()->studentClass[0]->classGroup->course->where('status', 'open')->count() }}
                          Mata Pelajaran
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end card body -->
        </div>
        <!-- end card -->
      </div>
      <div class="col-xl-2 col-lg-12 mb-3 d-md-block d-none bh-100">
        <a data-toggle="ajax" href="{{ route('student.presence') }}" class="btn btn-primary w-100 d-block h-100">
          <i class="mdi me-1 mdi-qrcode d-block mb-2" style="font-size: 30px;"></i>
          Absensi QR
        </a>
      </div>
      <div class="col-md-12 d-md-block d-none">
        <div class="card">
          <div class="card-header">
            <div class="d-flex">
              <div class="flex-grow-1">
                <h5 class="card-title mb-0">Daftar Kelas</h5>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div>
              <div class="row">
                @if ($courses->count() > 0)
                  @foreach ($courses as $item)
                    <div class="col-xl-3">
                      <div class="card p-1 mb-xl-0">
                        <img src="{{ asset('assets/images/courses/' . $item->thumbnail) }}" alt=""
                          class="card-img-top img-fluid">
                        <div class="p-3">
                          <div class="d-flex align-items-start">
                            <div class="flex-grow-1 overflow-hidden">
                              <h5 class="font-size-15 text-truncate"><a href="#" class="text-dark">
                                  {{ $item->classGroup->major->short_name . ' ' . $item->classGroup->degree->degree . ' ' . $item->classGroup->name . '_' . $item->subject->name }}</a>
                              </h5>
                              <p class="font-size-13 text-muted mb-0">Mata Pelajaran
                                {{ $item->subject->name }}
                                Kelas
                                {{ $item->classGroup->degree->degree . ' ' . $item->classGroup->name }}
                              </p>
                            </div>
                          </div>
                        </div>
                        <div class="p-3 pt-0">
                          <ul class="list-inline">
                            <li class="list-inline-item me-3">
                              <a href="javascript: void(0);" class="text-muted">
                                <i class="bx bx-package align-middle text-muted me-1"></i>
                                {{ isset($item->basicCompetence) ? $item->basicCompetence->count() : '0' }}
                                Komptensi
                              </a>
                            </li>
                            <li class="list-inline-item me-3">
                              <a href="javascript: void(0);" class="text-muted">
                                <i class="bx bx-video-plus align-middle text-muted me-1"></i>
                                {{ $item->number_of_meetings }} Pertemuan
                              </a>
                            </li>
                          </ul>
                          <div>
                            @can('read-student-dashboard-class-detail')
                              <button class="btn btn-primary waves-effect wafes-primary mx-1 w-100" type="button"
                                data-toggle="ajax"
                                data-target="{{ route('students.class-detail', hashId($item->id)) }}"><i
                                  class="bx bx-book-open"></i> Detail
                                Kelas</button>
                            @endcan
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                @else
                  <img src="{{ asset('assets/images/illustration/no-data.svg') }}" class="mx-auto d-block"
                    style="max-width: 400px" alt="">
                  <h5 class="text-center">Opps! Kamu belum memiliki kelas</h5>
                @endif
                <!-- end col -->
                <!-- end col -->
              </div>
              <!-- end row -->
            </div>
          </div>
          <!-- end card body -->
        </div>
      </div>
    </div>
    <!-- end card -->
  </div>
  <!-- end col -->
  <div class="col-xl-3 col-lg-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex flex-wrap gap-2">
          <h5 class="card-title">
            {{-- {{ dd($courses) }} --}}
            Daftar Tugas <span class="badge bg-success ms-1">{{ $totalAssignment }}</span>
          </h5>
        </div>
      </div>
      <div class="card-body">
        <div class="list-group">
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col">
                <a href="{{ route('students.knowledge-assignment') }}" data-toggle="ajax">
                  <strong class="mb-2">Tugas Pengetahuan <span
                      class="badge bg-danger ms-1">{{ $knowledgeAssignment }}</span></strong>
                  <p class="text-muted mb-0">
                    Lihat semua tugas pengetahuan</p>
                </a>
              </div>
              <div class="col-auto">
                <a href="{{ route('students.knowledge-assignment') }}" class="setting-next-link" data-toggle="ajax">
                  <i class="dripicons-chevron-right setting-next-arrow text-secondary"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col">
                <a href="{{ route('students.skill-assignment') }}" data-toggle="ajax">
                  <strong class="mb-2">Tugas Keterampilan <span
                      class="badge bg-danger ms-1">{{ $skillAssignment }}</span></strong>
                  <p class="text-muted mb-0">
                    Lihat semua tugas keterampilan</p>
                </a>
              </div>
              <div class="col-auto">
                <a href="{{ route('students.skill-assignment') }}" class="setting-next-link" data-toggle="ajax">
                  <i class="dripicons-chevron-right setting-next-arrow text-secondary"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <div class="d-flex flex-wrap gap-2">
          <h5 class="card-title">
            Daftar Meet Hari Ini <span class="badge bg-success ms-1">{{ $videoConferences->count() }}</span>
          </h5>
        </div>
      </div>
      <div class="card-body">
        <div class="list-group">
          @forelse ($videoConferences as $videoConference)
            <div class="list-group-item">
              <div class="row align-items-center">
                <div class="col">
                  <strong class="mb-2">{{ $videoConference->name }}</strong>
                  <p class="text-muted mb-0 mt-2"><i class='bx bx-folder'></i>
                    {{ $item->classGroup->major->short_name . ' ' . $item->classGroup->degree->degree . ' ' . $item->classGroup->name . '_' . $item->subject->name }}
                  </p>
                  <p class="text-muted mb-0"><i class='bx bx-time-five'></i>
                    {{ date('H:i', strtotime($videoConference->start_time)) }}</p>
                </div>
                <div class="col-auto">
                  <a href="{{ route('student.classroom.conference-room', ['videoConference' => $videoConference->hashid, 'course' => $videoConference->course->hashid]) }}"
                    class="setting-next-link" data-toggle="ajax">
                    <i class="dripicons-chevron-right setting-next-arrow text-secondary"></i>
                  </a>
                </div>
              </div>
            </div>
          @empty
            <h4 class="text-center">Tidak Ada Meet</h4>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>
