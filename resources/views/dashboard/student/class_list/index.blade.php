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
      <a href="{{ route('students.dashboard') }}" class="btn btn-light waves-effect mr-2 waves-light" data-toggle="ajax"><i
          class="fa fa-arrow-left"></i> Kembali</a>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
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
                              data-toggle="ajax" data-target="{{ route('students.class-detail', hashId($item->id)) }}"><i
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
@endsection
