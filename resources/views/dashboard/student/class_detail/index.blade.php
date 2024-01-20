@extends('layouts.ajax')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{ getSetting('web_name') }}</li>
        <li class="breadcrumb-item"><a href="{{ route('students.dashboard') }}" data-toggle="ajax">Dashboard</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')
    <div class="mb-4">
        <div class="text-start">
            <a href="{{ route('students.dashboard') }}" class="btn btn-light waves-effect mr-2 waves-light" data-toggle="ajax"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary mb-2">
                        <div class="card-header">
                            <h4>Mata Pelajaran</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 mb-2">
                                    <h5>{{ $course->subject->name }}</h5>
                                    <p class="mb-0">{{ $course->description }}</p>
                                    <p class="mb-0"><span
                                            class="badge bg-danger">{{ $course->semester == 1 ? 'Semester Ganjil' : 'Semester Genap' }}</span>
                                        <span class="badge bg-success">{{ 'KKM : ' . $course->subject->grade }}</span>
                                    </p>
                                </div>
                            </div>
                            <input type="hidden" id="class-hashid" value="{{ $course->hashid }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Guru</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <img class="rounded avatar-xl"
                                        src="{{ asset('assets/images/teachers/' . $course->teacher->picture) }}"
                                        alt="Teacher Picture">
                                </div>
                                <div class="flex-grow-1">
                                    <h5>{{ $course->teacher->name }}</h5>
                                    <div class="mb-0">{{ $course->teacher->identity_number }}</div>
                                    <div class="mb-0"><span class="badge bg-success">Kelas :
                                            {{ $course->classgroup->degree->number . ' ' . $course->classGroup->name }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary mb-2">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h4>Status Kehadiran</h4>
                                <button class="btn btn-primary presence-now-btn" data-bs-toggle="modal"
                                    data-bs-target="#meeting-presence-modal"
                                    {{ $todayAttendance ? 'disabled' : '' }}>{{ $todayAttendance ? 'Sudah Presensi' : 'Presensi Sekarang' }}</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td>Hari</td>
                                        <td>:</td>
                                        <td>
                                            <div>
                                                <div class="row">
                                                    @for ($i = 0; $i < $course->number_of_meetings; $i++)
                                                        <div class="col-md-1 border text-center border-dark">
                                                            <span>
                                                                <i
                                                                    class="{{ isset($course->attendance) &&$course->attendance()->whereStatusAndNumberOfMeetings('present', $i + 1)->first() != null? 'fa fa-check-circle text-success': 'fa fa-times-circle text-danger' }}"></i>

                                                                {{ $i + 1 }}</span>
                                                        </div>
                                                    @endfor
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="130px">Total Pertemuan</td>
                                        <td width="20px">:</td>
                                        <td>{{ $course->number_of_meetings }} Pertemuan</td>
                                    </tr>
                                    <tr>
                                        <td>Total Kehadiran</td>
                                        <td>:</td>
                                        <td>{{ isset($course->attendance)? $course->attendance()->whereStatus('present')->count(): 0 }}
                                            Pertemuan</td>
                                    </tr>
                                    <tr>
                                        <td>Total Ketidakhadiran</td>
                                        <td>:</td>
                                        <td>{{ isset($course->attendance)? $course->number_of_meetings -$course->attendance()->whereStatus('present')->count(): 0 }}
                                            Pertemuan</td>
                                    </tr>
                                    <tr>
                                        <td>Keterangan</td>
                                        <td>:</td>
                                        <td>
                                            <span><i class="fa fa-check-circle text-success"></i> Hadir <i
                                                    class="fa fa-times-circle text-danger"></i> Tidak Hadir / Belum
                                                Absen</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-primary mb-2">
                <div class="card-header">
                    <h4>Jadwal Video Conference</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse ($videoConferences as $videoConference)
                            <div class="col-md-4 col-sm-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="mb-3">{{ $videoConference->name }}</h5>
                                        <p class="mb-0"><i class='bx bx-folder mr-3'></i>  Pertemuan ke-{{ $videoConference->meeting_number }}</p>
                                        <p class="mb-0"><i class='bx bx-calendar'></i>  {{ date('d-m-Y | H:i', strtotime($videoConference->start_time)) }}</p>
                                        @if ($videoConference->started_at == null)
                                            <button class="btn btn-primary w-100 mt-4" disabled>Video Conference Belum di Mulai</button>
                                        @elseif ($videoConference->started_at != null && $videoConference->end_time == null)
                                            <a class="btn btn-primary w-100 mt-4" href="{{ route('student.classroom.conference-room', ['videoConference' => $videoConference->hashid,'course' => $videoConference->course->hashid]) }}">Join</a>
                                        @else
                                            <button class="btn btn-primary w-100 mt-4" disabled>Sudah Selesai</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center">
                                <img src="{{ asset('assets/images/meet.svg') }}" alt="" style="width: 100%; max-width: 350px;">
                                <h3 class="mt-3">Tidak Ada Video Conference di Kelas Ini</h3>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary mb-2">
                        <div class="card-header">
                            <h4>Materi / Bahan Ajar</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @forelse ($course->teachingMaterial->where('is_share', true) as $item)
                                    @php
                                        $extension = explode('.', $item->attachment);

                                    @endphp
                                    <div class="col-md-3 mb-3">
                                        <div class="d-flex">
                                            <i
                                                class="mdi {{ end($extension) == 'pdf'? 'mdi-file-pdf-box text-danger': (end($extension) == 'doc' || end($extension) == 'docx' || end($extension) == 'docs'? 'mdi-file-word text-info': (end($extension) == 'csv'? 'mdi-file-excel text-success': (end($extension) == 'xls' || end($extension) == 'xlsx'? 'mdi-file-excel text-success': (end($extension) == 'ppt' || end($extension) == 'pptx'? 'mdi-file-powerpoint text-warning': ($item->type == 'image'? 'mdi-file-image text-primary': ($item->type == 'video'? 'mdi-file-video text-primary': ($item->type == 'audio'? 'mdi-motion-play text-primary': ($item->type == 'youtube'? 'mdi-youtube text-danger': ($item->type == 'article'? 'mdi-web text-primary': 'mdi-file text-secondary'))))))))) }} fa-3x"></i>
                                            <a href="{{ $item->type == 'article' || $item->type == 'youtube'? $item->attachment: asset('storages/teaching-materials/' . $item->attachment) }}"
                                                target="_blank" class="mt-auto mb-auto">
                                                <h5 class="mr-2 mt-2">{{ $item->name }}</h5>
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center my-5">
                                        <img src="{{ asset('assets/images/oops-pana.svg') }}" alt=""
                                            style="max-width: 250px; width: 100%;">
                                        <h3 class="mt-5">Tidak ada materi</h3>
                                        <p class="mt-3">Saat ini masih belum ada materi di pelajaran ini!
                                        </p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="card card-primary shadow-sm mb-2">
                        <div class="card-header">
                            <h4>Tugas Pengetahuan</h4>
                        </div>
                        <div class="card-body">
                            {{-- <div class="row"> --}}
                                {{-- <div class="col-md-12"> --}}
                                    <div class="mt-3 table-responsive">
                                        <table id="dataTable-assignment-knowledge"
                                            class="table align-middle datatable dataTable dt-responsive table-check nowrap"
                                            style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;"
                                            data-url="{{ route('students.class-detail.getDataAssignmentKnowledge', ['course' => hashId($course->id)]) }}"
                                            width="100%">
                                            <thead class="table-light">
                                                <th class="all">No</th>
                                                <th class="all">Tugas</th>
                                                <th>Skema</th>
                                                <th>Waktu</th>
                                                <th>Instruksi</th>
                                                <th>Dikerjakan</th>
                                                <th>Aksi</th>
                                            </thead>
                                        </table>
                                    </div>
                                {{-- </div> --}}
                            {{-- </div> --}}
                        </div>
                    </div>
                    <div class="card card-primary shadow-sm mb-2">
                        <div class="card-header">
                            <h4>Tugas Keterampilan</h4>
                        </div>
                        <div class="card-body">
                            {{-- <div class="row">
                                <div class="col-md-12"> --}}
                                    <div class="mt-3 table-responsive">
                                        <table id="dataTable-assignment-skill"
                                            class="table align-middle datatable dataTable dt-responsive table-check nowrap"
                                            style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;"
                                            data-url="{{ route('students.class-detail.getDataAssignmentSkill', ['course' => hashId($course->id)]) }}"
                                            width="100%">
                                            <thead class="table-light">
                                                <th class="all">No</th>
                                                <th class="all">Tugas</th>
                                                <th>Skema</th>
                                                <th>Waktu</th>
                                                <th>Instruksi</th>
                                                <th>Dikerjakan</th>
                                                <th>Aksi</th>
                                            </thead>
                                        </table>
                                    </div>
                                {{-- </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="post" id="form" enctype="multipart/form-data" data-request="ajax"
                    reload-view="true">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-upload"></i> Upload</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="">Type <span class="text-danger">*</span></label><br>
                            <label for="file">
                                <input type="radio" name="file_type" id="file" value="file" checked>
                                File
                            </label>
                            <label for="link" class="mx-3">
                                <input type="radio" name="file_type" id="link" value="link">
                                Link
                            </label>
                        </div>
                        <div class="mb-3 d-none" id="formLink">
                            <label for="">Link <span class="text-danger">*</span></label>
                            <textarea name="link" rows="3" class="form-control"></textarea>
                        </div>
                        <div class="mb-3" id="formFile">
                            <label for="">File <span class="text-danger">*</span></label>
                            <input type="hidden" name="hashid">
                            <input type="file" name="file" class="dropify input-file-now" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit"><i class="fa fa-paper-plane"></i> Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if (!$todayAttendance)
        <div class="modal fade" id="meeting-presence-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <form id="meeting-presence-form"
                action="{{ route('students.class-detail.presence', ['course' => $course->hashid]) }}" method="POST">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Presensi Sekarang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="meeting-number-selector">Pilih Pertemuan</label>
                                <select name="meeting_number" class="form-control" id="meeting-number-selector">
                                    <option value="">Pilih Nomor Pertemuan</option>
                                    @foreach ($coursePresenceMeetingsNumber as $pn)
                                        <option value="{{ $pn }}">{{ $pn }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary presence-btn">Presensi</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endif
@endsection
