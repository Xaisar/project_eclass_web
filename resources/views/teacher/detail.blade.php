@extends('layouts.ajax')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">E - Learning</li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" data-toggle="ajax">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('teacher') }}" data-toggle="ajax">Guru</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-9 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm order-2 order-sm-1">
                            <div class="d-flex align-items-start mt-3 mt-sm-0">
                                <div class="flex-shrink-0">
                                    <div class="avatar-xl me-3">
                                        <img src="{{ asset('assets/images/teachers/' . $teacher->picture) }}" alt=""
                                            class="img-fluid rounded-circle d-block">
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div>
                                        <h5 class="font-size-16 mb-1">{{ $teacher->name }}</h5>
                                        <p class="text-muted font-size-13">{{ $teacher->identity_number }}</p>

                                        <div
                                            class="d-flex flex-wrap align-items-start gap-2 gap-lg-3 text-muted font-size-13">
                                            <div><i
                                                    class="mdi mdi-phone me-1 text-success align-middle"></i>{{ $teacher->phone_number }}
                                            </div>
                                            <div><i
                                                    class="mdi mdi-mail me-1 text-success align-middle"></i>{{ $teacher->email }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-auto order-1 order-sm-2">
                            <div class="d-flex align-items-start justify-content-end gap-2">
                                <div>
                                    <button type="button" data-toggle="ajax"
                                        data-target="{{ route('teacher.edit', ['teacher' => hashId($teacher->id)]) }}"
                                        class="btn btn-soft-light"><i class="mdi mdi-account-edit-outline me-1"></i>
                                        Edit Profile</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-tabs-custom card-header-tabs border-top mt-4" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link px-3 active" data-bs-toggle="tab" href="#overview" role="tab">Riwayat
                                Menjajar</a>
                        </li>
                    </ul>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            <div class="tab-content">
                <div class="tab-pane active" id="overview" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Riwayat Mengajar</h5>
                        </div>
                        <div class="card-body">
                            <div>
                                <div class="pb-3">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <table id="dataTable"
                                                class="table align-middle datatable dt-responsive table-check nowrap"
                                                style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;"
                                                data-url="{{ route('teacher.getHistoryData', ['teacher' => hashId($teacher->id)]) }}"
                                                width="100%">
                                                <thead class="table-light">
                                                    <th>No</th>
                                                    <th>Nama Course</th>
                                                    <th>Kelas</th>
                                                    <th>Tahun Ajaran</th>
                                                    <th>Status</th>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end tab pane -->
            </div>
            <!-- end tab content -->
        </div>
        <!-- end col -->

        <div class="col-xl-3 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-3">Informasi Pribadi</h5>
                </div>
                <div class="card-body">
                    <div>
                        <ul class="list-unstyled mb-0">
                            <li>
                                <a href="#" class="py-1 d-block text-muted"><i
                                        class="mdi mdi-gender-male-female text-primary me-1"></i>
                                    {{ $teacher->gender == 'male' ? 'Laki-Laki' : ($teacher->gender == 'female' ? 'Perempuan' : 'Lainnya') }}</a>
                            </li>
                            <li class="mt-1">
                                <a href="#" class="py-1 d-block text-muted"><i
                                        class="mdi mdi-calendar-account-outline text-primary me-1"></i>
                                    {{ $teacher->birthplace . ', ' . $teacher->birthdate }}</a>
                            </li>
                            <li class="mt-1">
                                <a href="#" class="py-1 d-block text-muted"><i
                                        class="mdi mdi-calendar-arrow-left text-primary me-1"></i>
                                    {{ $teacher->year_of_entry }}</a>
                            </li>
                            <li class="mt-1">
                                <a href="#" class="py-1 d-block text-muted"><i
                                        class="mdi mdi-book-education-outline text-primary me-1"></i>
                                    {{ $teacher->last_education }}</a>
                            </li>
                            <li class="mt-1">
                                <a href="#" class="py-1 d-block text-muted"><i
                                        class="mdi mdi-map-marker text-primary me-1"></i>
                                    {{ $teacher->address }}</a>
                            </li>
                            <li class="mt-1">
                                <a href="#" class="py-1 d-block text-muted"><i
                                        class="mdi mdi-account-check text-primary me-1"></i>
                                    {{ $teacher->status == true ? 'Aktif' : 'Tidak Aktif' }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
@endsection
