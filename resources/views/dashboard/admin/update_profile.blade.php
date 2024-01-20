@extends('layouts.ajax')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{ getSetting('web_name') }}</li>
        <li class="breadcrumb-item"><a href="{{ route('teachers.dashboard') }}" data-toggle="ajax">Dashboard</a></li>
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
                                    <h5 class="text-center">{{ getInfoLogin()->name }}</h6>
                                </div>
                                <div class="mb-2 mt-2 row">
                                    <button data-toggle="ajax" data-target="{{ route('admin.profile.update') }}"
                                        class="btn btn-block btn-outline-primary mt-2"><i class="fa fa-user"></i> Ganti
                                        Profil</button>
                                    <button data-toggle="ajax"
                                        data-target="{{ route('admin.update-password', Hashids::encode(getInfoLogin()->id)) }}"
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
                            data-success-callback="{{ route('admin.profile') }}" enctype="multipart/form-data">
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="">Username </label>
                                            <input type="text" name="identity_number" id="identity_number"
                                                class="form-control" placeholder="Username" readonly autocomplete="off"
                                                value="{{ Auth::user()->username }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="">Nama Lengkap <span class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name" class="form-control"
                                                placeholder="Nama Lengkap" autocomplete="off"
                                                value="{{ Auth::user()->name }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="">Email <span class="text-danger">*</span></label>
                                            <input type="text" name="email" id="email" class="form-control"
                                                placeholder="Email" autocomplete="off"
                                                value="{{ Auth::user()->email }}">
                                        </div>
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
                                    data-target="{{ route('admin.profile') }}"><i class="fa fa-arrow-left"></i>
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
