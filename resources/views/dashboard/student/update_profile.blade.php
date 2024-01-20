@extends('layouts.ajax')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{ getSetting('web_name') }}</li>
        <li class="breadcrumb-item"><a href="{{ route('students.dashboard') }}" data-toggle="ajax">Dashboard</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary mb-2">
                        <div class="card-body">
                            <img src="{{ asset('assets/images/users/' . getInfoLogin()->picture) }}" width="130" alt=""
                                class="img-fluid rounded-circle mx-auto d-block">
                            <div class="author-box-details mt-2">
                                <div class="author-box-name mb-3">
                                    <h5 class="text-center">{{ getInfoLogin()->userable->name }}</h6>
                                </div>
                                <div class="mb-2 mt-2 row">
                                    <button data-toggle="ajax" data-target="{{ route('students.profile.update') }}"
                                        class="btn btn-block btn-outline-primary mt-2"><i class="fa fa-user"></i> Ganti
                                        Profil</button>
                                    <button data-toggle="ajax"
                                        data-target="{{ route('students.update-password', Hashids::encode(getInfoLogin()->id)) }}"
                                        class="btn btn-block btn-outline-warning mt-2"><i class="fa fa-lock"></i> Ganti
                                        Password</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $title }}</h4>
                        </div>
                        <form action="{{ $action }}" method="post" data-request="ajax"
                            data-success-callback="{{ route('students.profile') }}" enctype="multipart/form-data">
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="">NIS / NISN (Username) <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="identity_number" id="identity_number"
                                                class="form-control" placeholder="NIS / NISN" autocomplete="off"
                                                value="{{ Auth::user()->userable->identity_number }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="">Nama Lengkap <span class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name" class="form-control"
                                                placeholder="Nama Lengkap" autocomplete="off"
                                                value="{{ Auth::user()->userable->name }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="">Jenis Kelamin <span class="text-danger">*</span></label>
                                            <select class="form-select" id="gender" type="text" name="gender">
                                                <option>Pilih..</option>
                                                <option value="male"
                                                    {{ Auth::user()->userable->gender == 'male' ? 'selected' : '' }}>
                                                    Laki-Laki</option>
                                                <option value="female"
                                                    {{ Auth::user()->userable->gender == 'female' ? 'selected' : '' }}>
                                                    Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="">Nomor Telepon <span class="text-danger">*</span></label>
                                            <input type="text" name="phone_number" id="phone_number" class="form-control"
                                                placeholder="Nomor Telephone" autocomplete="off"
                                                value="{{ Auth::user()->userable->phone_number }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="">Email <span class="text-danger">*</span></label>
                                            <input type="text" name="email" id="email" class="form-control"
                                                placeholder="Email" autocomplete="off"
                                                value="{{ Auth::user()->userable->email }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="">Tempat Lahir <span class="text-danger">*</span></label>
                                            <input type="text" name="birthplace" id="birthplace" class="form-control"
                                                placeholder="Tempat Lahir" autocomplete="off"
                                                value="{{ Auth::user()->userable->birthplace }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="">Tanggal Lahir <span class="text-danger">*</span></label>
                                            <input class="form-control flatpickr" type="date" name="birthdate"
                                                id="birthdate" value="{{ Auth::user()->userable->birthdate }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group mb-3">
                                            <label for="">No. Telepon Orang Tua <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="parent_phone_number" id="parent_phone_number"
                                                class="form-control" placeholder="Tahun Masuk" autocomplete="off"
                                                value="{{ Auth::user()->userable->parent_phone_number }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group mb-3">
                                        <label for="">Alamat <span class="text-danger">*</span></label>
                                        <input type="text" name="address" id="address" class="form-control"
                                            placeholder="Alamat Guru" autocomplete="off"
                                            value="{{ Auth::user()->userable->address }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label for="">Foto</label>
                                        <input type="file" name="picture" id="input-file-now" class="dropify" />
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button class="btn btn-light waves-effect waves-light mx-1" data-toggle="ajax"
                                    data-target="{{ route('students.profile') }}"><i class="fa fa-arrow-left"></i>
                                    Kembali</button>
                                <button class="btn btn-primary waves-effect wafes-primary mx-1" type="submit"><i
                                        class="fa fa-paper-plane"></i> Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
