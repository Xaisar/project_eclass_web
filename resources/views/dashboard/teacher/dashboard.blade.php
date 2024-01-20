<div id="carouselExampleCaptions" class="carousel slide widget-carousel mb-2" data-bs-ride="carousel">
    <div class="carousel-inner">
        @foreach ($announcements as $item)
            <div class="carousel-item {{ $loop->iteration == 1 ? 'active' : '' }}">
                <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                    <i class="mdi mdi-information-outline label-icon"></i>
                    <strong>{{ $item->title }}</strong><br>
                    {{ $item->content }}
                </div>
            </div>
        @endforeach
        <!-- end carousel-item -->
    </div>
    <!-- end carousel-inner -->

    <div class="carousel-indicators carousel-indicators-rounded">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
            aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
            aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
            aria-label="Slide 3"></button>
    </div>
    <!-- end carousel-indicators -->
</div>
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

                                    <div
                                        class="d-flex flex-wrap align-items-start gap-2 gap-lg-3 text-muted font-size-13">
                                        <div><i
                                                class="mdi mdi-card-account-phone me-1 align-middle"></i>{{ getInfoLogin()->userable->phone_number }}
                                        </div>
                                        <div><i
                                                class="mdi mdi-email me-1 align-middle"></i>{{ getInfoLogin()->userable->email }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-auto order-1 order-sm-2">
                        <div class="d-flex align-items-start justify-content-end gap-2">
                            <div>
                                <button data-target="{{ route('teachers.profile') }}" data-toggle="ajax"
                                    class="btn btn-soft-light">
                                    <i class="mdi me-1 mdi-account-edit-outline"></i>
                                    Edit Profile</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
        <div class="row">
            <div class="col-xl-6 col-md-12">
                <!-- card -->
                <div class="card card-h-100">
                    <!-- card body -->
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Jumlah Pelajaran</span>
                                <h4 class="mb-3">
                                    <span class="counter-value"
                                        data-target="{{ $courseCount }}">{{ $courseCount }}</span>
                                </h4>
                            </div>
                        </div>
                        <div class="text-nowrap">
                            <span class="ms-1 text-muted font-size-13">Jumlah Pelajaran Tahun Ini</span>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="col-xl-6 col-md-12">
                <!-- card -->
                <div class="card card-h-100">
                    <!-- card body -->
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Jumlah Siswa Ajar</span>
                                <h4 class="mb-3">
                                    <span class="counter-value"
                                        data-target="{{ $studentCount }}">{{ $studentCount }}</span>
                                </h4>
                            </div>
                        </div>
                        <div class="text-nowrap">
                            <span class="ms-1 text-muted font-size-13">Jumlah Siswa Ajar Tahun Ini</span>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="col-xl-6 col-md-12">
                <!-- card -->
                <div class="card card-h-100">
                    <!-- card body -->
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Jumlah Kelas Ajar</span>
                                <h4 class="mb-3">
                                    <span class="counter-value"
                                        data-target="{{ $classCount }}">{{ $classCount }}</span>
                                </h4>
                            </div>
                        </div>
                        <div class="text-nowrap">
                            <span class="ms-1 text-muted font-size-13">Jumlah Kelas Ajar Tahun Ini</span>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="col-xl-6 col-md-12">
                <!-- card -->
                <div class="card card-h-100">
                    <!-- card body -->
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Jumlah Jurusan</span>
                                <h4 class="mb-3">
                                    <span class="counter-value"
                                        data-target="{{ $majorCount }}">{{ $majorCount }}</span>
                                </h4>
                            </div>
                        </div>
                        <div class="text-nowrap">
                            <span class="ms-1 text-muted font-size-13">Jumlah Jurusan Ajar</span>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div>
    </div>
    <!-- end col -->

    <div class="col-xl-6 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Buat Mata Pelajaran dan Kelas Anda</h5>
            </div>
            <form action="{{ route('teachers.createCourse') }}" method="post" data-request="ajax"
                data-reload-view="true">
                <div class="card-body">
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="choices-single-default"
                                class="form-label font-size-13 text-muted">Jurusan</label>
                            <select class="form-control js-choices" name="major_id">
                                <option value="">Pilih Jurusan</option>
                                <option value="non-jurusan">Non Jurusan</option>
                                @foreach ($majors as $major)
                                    <option value="{{ $major->hashid }}">{{ $major->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="subjects" class="form-label font-size-13 text-muted">Mata
                                Pelajaran</label>
                            <select class="form-control" id="subjects" name="subject_id">
                                <option value="">Pilih Mata Pelajaran</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="class" class="form-label font-size-13 text-muted">Kelas</label>
                            <select class="form-control" id="class" name="class_id">
                                <option value="">Pilih Kelas</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary waves-effect wafes-primary mx-1" type="submit"><i
                            class="fa fa-paper-plane"></i> Submit</button>
                </div>
            </form>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-0">Kelas Anda</h5>
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
                                                    <h5 class="font-size-15 text-truncate"><a href="#"
                                                            class="text-dark">
                                                            {{ $item->classGroup->major->short_name .' ' .$item->classGroup->degree->degree .' ' .$item->classGroup->name .'_' .$item->subject->name }}</a>
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
                                                        <i class="bx bx-group align-middle text-muted me-1"></i>
                                                        {{ isset($item->classGroup->studentClass)? $item->classGroup->studentClass->where('study_year_id', getStudyYear()->id)->count(): '0' }}
                                                        Siswa
                                                    </a>
                                                </li>
                                                <li class="list-inline-item me-3">
                                                    <a href="javascript: void(0);" class="text-muted">
                                                        <i class="bx bx-package align-middle text-muted me-1"></i>
                                                        {{ isset($item->basicCompetence) ? $item->basicCompetence->count() : '0' }}
                                                        KD
                                                    </a>
                                                </li>
                                                <li class="list-inline-item me-3">
                                                    <a href="javascript: void(0);" class="text-muted">
                                                        <i class="bx bx-award align-middle text-muted me-1"></i>
                                                        {{ $item->subject->grade }} KKM
                                                    </a>
                                                </li>
                                            </ul>
                                            <p class="text-muted">
                                                {{ substr($item->description, 0, 65) }}
                                                {{ strlen($item->description) > 65 ? '...' : '' }}
                                            </p>

                                            <div>
                                                @if ($item->status == 'open')
                                                    <a href="{{ route('classroom.signin', ['course' => hashId($item->id)]) }} "
                                                        class="btn btn-primary waves-effect wafes-primary mx-1 w-100">
                                                        <i class="bx bx-home"></i>
                                                        Masuk Kelas
                                                    </a>
                                                @elseif ($item->status == 'close')
                                                    <button
                                                        class="btn btn-success waves-effect wafes-primary mx-1 w-100 open-class"
                                                        type="button" data-id="{{ hashId($item->id) }}"><i
                                                            class="bx bx-lock-open"></i> Buka
                                                        Kelas</button>
                                                @endif
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
