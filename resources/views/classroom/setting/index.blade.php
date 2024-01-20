@extends('layouts.ajax')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{ getSetting('web_name') }}</li>
        <li class="breadcrumb-item"><a href="{{ route('classroom.home', ['course' => hashId(getClassroomInfo()->id)]) }}"
                data-toggle="ajax">{{ getClassroomInfo()->classGroup->degree->degree .' ' .getClassroomInfo()->classGroup->name .'_' .getClassroomInfo()->subject->name }}</a>
        </li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <form action="{{ $action }}" method="post" data-request="ajax"
                data-success-callback="{{ route('classroom.settings', hashId(getClassroomInfo()->id)) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row mb-4">
                        <label for="number_of_meetings" class="col-sm-3 col-form-label">Jumlah Pertemuan</label>
                        <div class="col-sm-9">
                            <select name="number_of_meetings" class="form-control" id="number_of_meetings">
                                <option value=""> -- Pilih Jumlah Pertemuan -- </option>
                                @for ($i = 1; $i <= 50; $i++)
                                    <option value="{{ $i }}"
                                        {{ $i == getClassroomInfo()->number_of_meetings ? 'selected' : '' }}>
                                        {{ $i }} Pertemuan</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="number_of_meeting" class="col-sm-3 col-form-label">Deskripsi Kelas</label>
                        <div class="col-sm-9">
                            <textarea name="description" id="description" cols="30" rows="4"
                                class="form-control">{{ getClassroomInfo()->description }}</textarea>
                        </div>
                    </div>
                    @can('update-course-setting')
                        <div class="row mb-4">
                            <label for="" class="col-sm-3 col-form-label">Aktifkan Kelas</label>
                            <div class="col-sm-9">
                                <input type="checkbox" id="status" switch="none" name="status"
                                    {{ getClassroomInfo()->status == 'open' ? 'checked' : '' }} />
                                <label for="status" data-on-label="On" data-off-label="Off"></label>
                            </div>
                        </div>
                    @endcan
                </div>
                <div class="card-footer text-end">
                    @can('update-course-setting')
                        <button class="btn btn-primary waves-effect wafes-primary mx-1" type="submit"><i
                                class="fa fa-paper-plane"></i>
                            Submit</button>
                    @endcan
                </div>
            </form>
        </div>
    @endsection
