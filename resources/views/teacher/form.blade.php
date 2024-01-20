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
    <div class="col-md-6 col-sm-10 col-12">
        <div class="card shadow-sm mb-3">
            <form action="{{ $action }}" method="post" data-request="ajax"
                data-success-callback="{{ route('teacher') }}" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="">NUPTK / NIK <span class="text-danger">* Username</span></label>
                                <input type="text" name="identity_number" class="form-control" placeholder="NUPTK / NIK"
                                    autocomplete="off" value="{{ isset($teacher) ? $teacher->identity_number : '' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="Nama Lengkap"
                                    autocomplete="off" value="{{ isset($teacher) ? $teacher->name : '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="male"
                                        {{ isset($teacher) ? ($teacher->gender == 'male' ? 'selected' : '') : '' }}>
                                        Laki-Laki
                                    </option>
                                    <option value="female"
                                        {{ isset($teacher) ? ($teacher->gender == 'female' ? 'selected' : '') : '' }}>
                                        Perempuan
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="">Jabatan <span class="text-danger">*</span></label>
                                <select name="position" id="position" class="form-control js-choices">
                                    @foreach ($position as $item)
                                        <option value="{{ hashId($item->id) }}"
                                            {{ isset($teacher) ? ($teacher->position_id == $item->id ? 'selected' : '') : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="Email"
                                    autocomplete="off" value="{{ isset($teacher) ? $teacher->email : '' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="">Nomor Telepon <span class="text-danger">*</span></label>
                                <input type="text" name="phone_number" class="form-control" placeholder="Nomor Telepon"
                                    autocomplete="off" value="{{ isset($teacher) ? $teacher->phone_number : '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="">Tempat Lahir </label>
                                <input type="text" name="birthplace" class="form-control" placeholder="Tempat Lahir"
                                    autocomplete="off" value="{{ isset($teacher) ? $teacher->birthplace : '' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="">Tanggal Lahir </label>
                                <input type="text" name="birthdate" class="form-control flatpickr"
                                    placeholder="Tanggal Lahir" autocomplete="off"
                                    value="{{ isset($teacher) ? $teacher->birthdate : '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="">Tahun Masuk <span class="text-danger">*</span> </label>
                                <input type="text" name="year_of_entry" class="form-control" placeholder="Tahun Masuk"
                                    autocomplete="off" value="{{ isset($teacher) ? $teacher->year_of_entry : '' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="">Pendidikan Terakhir <span class="text-danger">*</span></label>
                                <input type="text" name="last_education" class="form-control"
                                    placeholder="Pendidikan Terakhir" autocomplete="off"
                                    value="{{ isset($teacher) ? $teacher->last_education : '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Alamat <span class="text-danger">*</span> </label>
                        <textarea name="address" id="address" cols="30" rows="2"
                            class="form-control">{{ isset($teacher) ? $teacher->address : '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Foto</label>
                        <input type="file" name="picture" id="input-file-now" class="dropify" />
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-light waves-effect waves-light mx-1" data-toggle="ajax"
                        data-target="{{ route('teacher') }}"><i class="fa fa-arrow-left"></i> Kembali</button>
                    <button class="btn btn-primary waves-effect wafes-primary mx-1" type="submit"><i
                            class="fa fa-paper-plane"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
