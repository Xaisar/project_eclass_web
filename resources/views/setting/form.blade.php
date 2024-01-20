@extends('layouts.ajax')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">E - Learning</li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" data-toggle="ajax">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('settings') }}" data-toggle="ajax">Settings</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')

    <div class="col-md-6 col-sm-10 col-12">
        <div class="card shadow-sm mb-3">
            <form action="{{ $action }}" method="post" data-request="ajax"
                data-success-callback="{{ route('settings') }}" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="">Group <span class="text-danger">*</span></label>
                        <input type="text" name="group" class="form-control" placeholder="Group" disabled
                            autocomplete="off" value="{{ isset($settings) ? $settings->groups : '' }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Label <span class="text-danger">*</span></label>
                        <input type="text" name="option" class="form-control" placeholder="Label" disabled
                            autocomplete="off" value="{{ isset($settings) ? $settings->label : '' }}">
                    </div>
                    @if ($settings->groups == 'Image')
                        <div class="form-group mb-3">
                            <label for="">Gambar <span class="text-danger">*</span></label>
                            <input type="file" name="value" class="form-control" placeholder="Gambar" autocomplete="off"
                                value="{{ isset($settings) ? $settings->value : '' }}">
                        </div>
                    @else
                        <div class="form-group mb-3">
                            <label for="">Value <span class="text-danger">*</span></label>
                            <input type="text" name="value" class="form-control" placeholder="Value" autocomplete="off"
                                value="{{ isset($settings) ? $settings->value : '' }}">
                        </div>
                    @endif
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-light waves-effect waves-light mx-1" data-toggle="ajax"
                        data-target="{{ route('settings') }}"><i class="fa fa-arrow-left"></i> Kembali</button>
                    <button class="btn btn-primary waves-effect wafes-primary mx-1" type="submit"><i
                            class="fa fa-paper-plane"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection
