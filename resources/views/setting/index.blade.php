@extends('layouts.ajax')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{ getSetting('web_name') }}</li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" data-toggle="ajax">Dashboard</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')
    <div class="col-md-7">
        {{-- <div class="card shadow-sm mb-3">
            <div class="card-body"> --}}
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#general" role="tab" aria-selected="true">
                    <span class="d-block "><i class="dripicons-home"></i></span>
                    <span class="d-none d-sm-block">General</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#image" role="tab" aria-selected="false">
                    <span class="d-block "><i class=" dripicons-photo-group"></i></span>
                    <span class="d-none d-sm-block">Image</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#config" role="tab" aria-selected="false">
                    <span class="d-block"><i class="dripicons-gear"></i></span>
                    <span class="d-none d-sm-block">Config</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#update" role="tab" aria-selected="false">
                    <span class="d-block"><i class="dripicons-folder"></i></span>
                    <span class="d-none d-sm-block">Update</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#plugin" role="tab" aria-selected="false">
                    <span class="d-block"><i class="dripicons-meter"></i></span>
                    <span class="d-none d-sm-block">Plugin</span>
                </a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content p-3 text-muted">
            <div class="tab-pane active" id="general" role="tabpanel">
                <h5 class="mb-0 mt-3">General Settings</h5>
                <p>Pengaturan dasar untuk aplikasi anda ada di sini.</p>
                <div class="list-group mb-5">
                    @foreach ($settingsGrouped['General'] as $settingGeneral)
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong class="mb-2">{{ $settingGeneral->label }}</strong>
                                    <p class="text-muted mb-0">
                                        {{ $settingGeneral->value . ' ' . $settingGeneral->display_suffix }}</p>
                                </div>
                                @can('update-settings')
                                    <div class="col-auto">
                                        <a href="{{ route('settings.edit', ['setting' => hashId($settingGeneral->id)]) }}"
                                            class="setting-next-link" data-toggle="ajax">
                                            <i class="dripicons-chevron-right setting-next-arrow text-secondary"></i>
                                        </a>
                                    </div>
                                @endcan
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane" id="image" role="tabpanel">
                <h5 class="mb-0 mt-3">Image Setting</h5>
                <p>Pengaturan gambar aplikasi anda ada di sini.</p>
                <div class="list-group mb-5">
                    @foreach ($settingsGrouped['Image'] as $settingImage)
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong class="mb-2">{{ $settingImage->label }}</strong>
                                    <p class="text-muted mb-0">
                                        {{ $settingImage->value . ' ' . $settingImage->display_suffix }}</p>
                                </div>
                                @can('update-settings')
                                    <div class="col-auto">
                                        <a href="{{ route('settings.edit', ['setting' => hashId($settingImage->id)]) }}"
                                            class="setting-next-link" data-toggle="ajax">
                                            <i class="dripicons-chevron-right setting-next-arrow text-secondary"></i>
                                        </a>
                                    </div>
                                @endcan
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane" id="config" role="tabpanel">
                <h5 class="mb-0 mt-3">Configuration Setting</h5>
                <p>Pengaturan konfigurasi aplikasi anda ada di sini.</p>
                <div class="list-group mb-5">
                    @foreach ($settingsGrouped['Config'] as $settingConfig)
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong class="mb-2">{{ $settingConfig->label }}</strong>
                                    <p class="text-muted mb-0">
                                        {{ ($settingConfig->value == 'N' ? 'Disabled' : 'Enabled') . ' ' . $settingConfig->display_suffix }}
                                    </p>
                                </div>
                                <div class="col-auto">
                                    <div class="custom-control custom-checkbox">
                                        @can('update-settings')
                                            <input type="checkbox" id="maintenanceMode" class="boolean-setting"
                                                data-id="{{ hashId($settingConfig->id) }}" switch="none"
                                                {{ $settingConfig->value === 'Y' ? 'checked' : '' }}>
                                            <label for="maintenanceMode" data-on-label="On" data-off-label="Off"></label>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane" id="update" role="tabpanel">
                <h5 class="mb-0 mt-3">Update Aplikasi</h5>
                <p>Anda bisa melakukan update aplikasi pada halaman ini.</p>
                <div class="list-group mb-5 mt-3">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="mdi mdi-alert-outline me-2"></i>
                        <strong>Info!</strong> Fitur ini akan seger hadir.
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="plugin" role="tabpanel">
                <h5 class="mb-0 mt-3">Plugin</h5>
                <p>Anda bisa menambahkan plugin aplikasi pada halaman ini.</p>
                <div class="list-group mb-5 mt-3">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="mdi mdi-alert-outline me-2"></i>
                        <strong>Info!</strong> Fitur ini akan seger hadir.
                    </div>
                </div>
            </div>
        </div>
        {{-- </div>
        </div> --}}
    </div>
@endsection
