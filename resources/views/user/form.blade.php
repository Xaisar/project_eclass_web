@extends('layouts.ajax')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">E - Learning</li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" data-toggle="ajax">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users') }}" data-toggle="ajax">Users</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')

    <div class="col-md-6 col-sm-10 col-12">
        <div class="card shadow-sm mb-3">
            <form action="{{ $action }}" method="post" data-request="ajax"
                data-success-callback="{{ route('users') }}" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" autocomplete="off"
                            value="{{ isset($value) ? $value->name : '' }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" placeholder="Email" autocomplete="off"
                            value="{{ isset($value) ? $value->email : '' }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control" placeholder="Username" autocomplete="off"
                            value="{{ isset($value) ? $value->username : '' }}">
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="form-group mb-3">
                                <label for="">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" placeholder="Password"
                                    autocomplete="off" {{ isset($value) ? 'disabled' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="form-group mb-3">
                                <label for="">Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password" name="confirm_password" class="form-control"
                                    placeholder="Konfirmasi Password" autocomplete="off"
                                    {{ isset($value) ? 'disabled' : '' }}>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Status <span class="text-danger">*</span></label>
                        <select name="is_active" class="form-control">
                            <option value="1" {{ isset($value) && $value->is_active == 1 ? 'selected' : '' }}>Aktif
                            </option>
                            <option value="0" {{ isset($value) && $value->is_active == 0 ? 'selected' : '' }}>Tidak Aktif
                            </option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Role <span class="text-danger">*</span></label>
                        <select name="role" id="role" class="form-control js-choices">
                            <option value="">Pilih Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}"
                                    {{ isset($value) && $value->roles[0]->name == $role->name ? 'selected' : '' }}>
                                    {{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3 form-student d-none">
                        <label for="">Siswa <span class="text-danger">*</span></label>
                        <select name="student" id="student" class="form-control js-choices">
                            <option value="">Pilih Siswa</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->hashid }}">{{ $student->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3 form-teacher d-none">
                        <label for="">Guru <span class="text-danger">*</span></label>
                        <select name="teacher" id="teacher" class="form-control js-choices">
                            <option value="">Pilih Guru</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->hashid }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Images</label>
                        <input type="file" name="file" id="input-file-now" class="dropify" />
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-light waves-effect waves-light mx-1" data-toggle="ajax"
                        data-target="{{ route('users') }}"><i class="fa fa-arrow-left"></i> Kembali</button>
                    <button class="btn btn-primary waves-effect wafes-primary mx-1" type="submit"><i
                            class="fa fa-paper-plane"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection
