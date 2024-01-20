@extends('layouts.ajax')
@section('breadcrumb')
  <ol class="breadcrumb">
    <li class="breadcrumb-item">{{ getSetting('web_name') }}</li>
    <li class="breadcrumb-item"><a href="{{ route('classroom.home', ['course' => hashId(getClassroomInfo()->id)]) }}"
        data-toggle="ajax">{{ getClassroomInfo()->classGroup->degree->degree . ' ' . getClassroomInfo()->classGroup->name . '_' . getClassroomInfo()->subject->name }}</a>
    </li>
    <li class="breadcrumb-item active">{{ $title }}</li>
  </ol>
@endsection

@section('content')
  @forelse ($teachingMaterial as $item)
    <a class="text-dark" href="{{ route('classroom.teaching-materials', ['course' => hashId(getClassroomInfo()->id)]) }}"
      data-toggle="ajax">
      <div class="card shadow-sm mb-3">
        <div class="card-body">
          <div class="row d-flex align-items-center">
            <div class="col-10">
              <p style="font-weight:700;">
                {{ 'Anda telah menambahkan Bahan Ajar ' . $item->name }}
              </p>
            </div>
            <div class="col-2 text-center">
              {{ $item->created_at?->locale('id')->isoFormat('LLLL') }}
            </div>
          </div>
        </div><!-- end card-body -->
      </div>
    </a>
  @empty
    'Belum ada materi'
  @endforelse
  @forelse ($knowledge as $item)
    <a class="text-dark"
      href="{{ route('classroom.knowledge-assessments', ['course' => hashId(getClassroomInfo()->id)]) }}"
      data-toggle="ajax">
      <div class="card shadow-sm mb-3">
        <div class="card-body">
          <div class="row d-flex align-items-center">
            <div class="col-10">
              <p style="font-weight:700;">
                {{ 'Anda telah menambahkan Tugas Pengetahuan  ' . $item->name }}
              </p>
            </div>
            <div class="col-2 text-center">
              {{ $item->created_at?->locale('id')->isoFormat('LLLL') }}
            </div>
          </div>
        </div><!-- end card-body -->
      </div>
    </a>
  @empty
    'Belum ada tugas pengetahuan yang diberikan'
  @endforelse
  @forelse ($skill as $item)
    <a class="text-dark" href="{{ route('classroom.skill-assessments', ['course' => hashId(getClassroomInfo()->id)]) }}"
      data-toggle="ajax">
      <div class="card shadow-sm mb-3">
        <div class="card-body">
          <div class="row d-flex align-items-center">
            <div class="col-10">
              <p style="font-weight:700;">
                {{ 'Anda telah menambahkan Tugas Keterampilan  ' . $item->name }}
              </p>
            </div>
            <div class="col-2 text-center">
              {{ $item->created_at?->locale('id')->isoFormat('LLLL') }}
            </div>
          </div>
        </div><!-- end card-body -->
      </div>
    </a>
  @empty
    'Belum ada tugas keterampilan yang diberikan'
  @endforelse
@endsection
