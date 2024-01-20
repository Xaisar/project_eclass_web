@extends('layouts.ajax')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{ getSetting('web_name') }}</li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" data-toggle="ajax">Dashboard</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')
    <div class="col-md-6 col-sm-10 col-12">
        <div class="card shadow-sm mb-3">
            <form action="{{ route('settings.holiday.update', hashId($holidaySetting[0]->id)) }}" method="post" data-request="ajax"
                data-success-callback="{{ route('settings.holiday.index') }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="day_1">Hari Libur 1</label>
                                <select name="day_1" id="day_1" class="form-control">
                                    <option value="" {{ !isset($holidaySetting[0]->day_1) ? 'selected' : '' }}>Pilih Hari</option>
                                    <option value="Monday" {{ $holidaySetting[0]->day_1 == 'Monday' ? 'selected' : '' }}>Monday</option>
                                    <option value="Tuesday" {{ $holidaySetting[0]->day_1 == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                                    <option value="Wednesday" {{ $holidaySetting[0]->day_1 == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                                    <option value="Thursday" {{ $holidaySetting[0]->day_1 == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                                    <option value="Friday" {{ $holidaySetting[0]->day_1 == 'Friday' ? 'selected' : '' }}>Friday</option>
                                    <option value="Saturday" {{ $holidaySetting[0]->day_1 == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                                    <option value="Sunday" {{ $holidaySetting[0]->day_1 == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="day_2">Hari Libur 2</label>
                                <select name="day_2" id="day_2" class="form-control">
                                    <option value="" {{ !isset($holidaySetting[0]->day_2) ? 'selected' : '' }}>Pilih Hari</option>
                                    <option value="Monday" {{ $holidaySetting[0]->day_2 == 'Monday' ? 'selected' : '' }}>Monday</option>
                                    <option value="Tuesday" {{ $holidaySetting[0]->day_2 == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                                    <option value="Wednesday" {{ $holidaySetting[0]->day_2 == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                                    <option value="Thursday" {{ $holidaySetting[0]->day_2 == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                                    <option value="Friday" {{ $holidaySetting[0]->day_2 == 'Friday' ? 'selected' : '' }}>Friday</option>
                                    <option value="Saturday" {{ $holidaySetting[0]->day_2 == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                                    <option value="Sunday" {{ $holidaySetting[0]->day_2 == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="date_1">Hari Libur 3</label>
                                <input type="text" name="date_1" class="form-control flatpickr"
                                    placeholder="Hari Libur 3" autocomplete="off"
                                    value="{{ $holidaySetting[0]->date_1 }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="date_2">Hari Libur 4</label>
                                <input type="text" name="date_2" class="form-control flatpickr"
                                    placeholder="Hari Libur 4" autocomplete="off"
                                    value="{{ $holidaySetting[0]->date_2 }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="date_3">Hari Libur 5</label>
                                <input type="text" name="date_3" class="form-control flatpickr"
                                    placeholder="Hari Libur 5" autocomplete="off"
                                    value="{{ $holidaySetting[0]->date_3 }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="range_1">Hari Libur 6</label>
                                <input type="text" name="range_1" class="form-control flatpickr-range"
                                    placeholder="Hari Libur 6" autocomplete="off"
                                    value="{{ isset($holidaySetting[0]->start_range_1) && isset($holidaySetting[0]->end_range_1) ? $holidaySetting[0]->start_range_1 . ' to ' . $holidaySetting[0]->end_range_1 : '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="range_2">Hari Libur 7</label>
                                <input type="text" name="range_2" class="form-control flatpickr-range"
                                    placeholder="Hari Libur 7" autocomplete="off"
                                    value="{{ isset($holidaySetting[0]->start_range_2) && isset($holidaySetting[0]->end_range_2) ? $holidaySetting[0]->start_range_2 . ' to ' . $holidaySetting[0]->end_range_2 : '' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-danger waves-effect waves-danger mx-1 btn-reset" type="button" data-reset-url="{{ route('settings.holiday.reset', hashId($holidaySetting[0]->id)) }}"><i class="fa fa-undo"></i> Reset</button>
                    <button class="btn btn-primary waves-effect wafes-primary mx-1" type="submit"><i
                            class="fa fa-paper-plane"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-6">
        <div class="card shadow-sm mb-3">

        </div>
    </div>
    {{-- @include('announcement.partials.form') --}}
@endsection
