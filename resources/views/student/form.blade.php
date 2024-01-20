@extends('layouts.ajax')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item">{{ getSetting('web_name') }}</li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" data-toggle="ajax">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('student') }}" data-toggle="ajax">Siswa</a></li>
    <li class="breadcrumb-item active">Tambah Siswa</li>
</ol>
@endsection

@section('content')
<div class="col-md-6 col-sm-8 col-xs-12">
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="alert alert-info alert-border-left alert-dismissible fade show mb-3" role="alert">
                <i class="mdi mdi-alert-circle-outline align-middle me-3"></i><strong>Info</strong>: Siswa
                yang telah dibuat akan otomatis aktif.
            </div>
            <form action="{{ $action }}" method="post" data-request="ajax" enctype="multipart/form-data" data-success-callback="{{ route('student') }}">
                <div class="mb-3">
                    <label for="">Nomor Identitas <span class="text-danger">*</span></label>
                    <input type="text" name="identity_number" class="form-control" placeholder="Nomor Identitas" autocomplete="off" value="{{ isset($values) ? $values->identity_number : '' }}">
                </div>
                <div class="mb-3">
                    <label for="">Nama Siswa <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="Nama Siswa" autocomplete="off" value="{{ isset($values) ? $values->name : '' }}">
                </div>
                <div class="mb-3">
                    <label for="">Jurusan <span class="text-danger">*</span></label>
                    <select name="major_id" class="form-control js-choices">
                        <option value="">Pilih Jurusan</option>
                        @foreach($majors as $item)
                            <option value="{{ $item->hashid }}" {{ isset($values) && $values->major_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="">Jenis Kelamin <span class="text-danger">*</span></label><br>
                    <label for="lk"><input type="radio" name="gender" id="lk" value="male" {{ isset($values) && $values->gender == 'male' ? 'checked' : '' }}> Laki - laki</label>
                    <label for="pr" class="mx-3"><input type="radio" name="gender" id="pr" value="female" {{ isset($values) && $values->gender == 'female' ? 'checked' : '' }}> Perempuan</label>
                    <label for="oth"><input type="radio" name="gender" id="oth" value="other" {{ isset($values) && $values->gender == 'other' ? 'checked' : '' }}> Lainnya</label>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="">Tempat Lahir <span class="text-danger">*</span></label>
                            <input type="text" name="birthplace" class="form-control" placeholder="Tempat Lahir" autocomplete="off" value="{{ isset($values) ? $values->birthplace : '' }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" name="birthdate" class="form-control" placeholder="Tanggal Lahir" autocomplete="off" value="{{ isset($values) ? $values->birthdate : '' }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" placeholder="Email" autocomplete="off" value="{{ isset($values) ? $values->email : '' }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="">Nomor Telp/Hp <span class="text-danger">*</span></label>
                            <input type="text" name="phone_number" class="form-control" placeholder="Nomor Telp/Hp" autocomplete="off" value="{{ isset($values) ? $values->phone_number : '' }}">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="">Telp/Hp Orang Tua <span class="text-danger">*</span></label>
                    <input type="text" name="parent_phone_number" class="form-control" placeholder="Nomor Telp/Hp Orang Tua" autocomplete="off" value="{{ isset($values) ? $values->parent_phone_number : '' }}">
                </div>
                <div class="mb-3">
                    <label for="">Alamat</label>
                    <textarea name="address" rows="3" class="form-control">{{ isset($values) ? $values->address : '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="">Images</label>
                    <input type="file" name="file" id="input-file-now" class="dropify" />
                </div>
                <div class="mb-3 text-end">
                    <button class="btn btn-danger" type="button" data-toggle="ajax" data-target="{{ route('student') }}">Kembali</button>
                    <button class="btn btn-primary" type="submit"><i class="fa fa-paper-plane"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection