@extends('layouts.ajax')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{ getSetting('web_name') }}</li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"
                data-toggle="ajax">{{ getClassroomInfo()->classGroup->degree->degree .' ' .getClassroomInfo()->classGroup->name .'_' .getClassroomInfo()->subject->name }}</a>
        </li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card author-box mb-2">
                <div class="card-body">
                    <div class="author-box-details text-center mt-2">
                        <div class="author-box-name">
                            <h5 style="color:#6777ef;"><b>{{ $classGroup }}</b></h5>
                            <br>
                            <h6 class="text-muted">
                                {{ $course->teacher->name }} </h6>
                            <p class="text-muted">Mata Pelajaran {{ $course->subject->name }}
                                Kelas {{ $course->classGroup->degree->degree }}
                                {{ $course->number_of_meetings }}
                                Pertemuan</p>
                        </div>
                        <p class="text-center mb-0" style="font-weight: 700; font-size: 16px;">
                            Siswa {{ $studentCount }} | Jumlah KD :
                            {{ $course->basicComptence->count() }} | KKM :
                            {{ $course->subject->grade }}
                        </p>
                        <center>
                            <small>
                                Kelas dibuat pada
                                {{ $course->created_at->locale('id')->isoFormat('LLLL') }}
                            </small>
                        </center>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 offset-lg-2">
            <h5 class="section-title text-primary my-3">Statistik Kelas</h5>
        </div>
        <div class="col-lg-8 offset-lg-2">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>KD</th>
                                    <th>Jumlah Materi</th>
                                    <th>Jumlah Penilaian Pengetahuan</th>
                                    <th>Jumlah Penilaian Keterampilan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($basicComptenceWithCount as $item)
                                    <tr>
                                        <td>KD {{ $item['code'] }}</td>
                                        <td>{{ $item['teachingMaterial'] }}</td>
                                        <td>{{ $item['knowledge'] }}</td>
                                        <td>{{ $item['skill'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
