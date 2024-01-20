@extends('layouts.ajax')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{ getSetting('web_name') }}</li>
        <li class="breadcrumb-item"><a href="{{ route('students.dashboard') }}" data-toggle="ajax">Dashboard</a></li>
        <li class="breadcrumb-item active">Tugas Keterampilan</li>
    </ol>
@endsection

@section('content')
    <button class="btn btn-light waves-effect waves-light mx-1 mb-3" data-toggle="ajax"
    data-target="{{ route('students.dashboard') }}"><i class="fa fa-arrow-left"></i> Kembali</button>
    <div class="row">
        @if ($assignments->count() > 0)
            @foreach ($assignments as $item)
                <div class="col-md-4 col-sm-6 col-xs-12 col-12">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">

                            <strong>{{ $item->course->description }}</strong> :
                            {{ $item->name }} <br>
                            @if ($item->skill_assessment->count() > 0)
                                @if ($item->skill_assessment[0]->score != null)
                                    <span class="badge badge-soft-success p-2">
                                        <strong>Nilai : {{ $item->skill_assessment[0]->score }}</strong>
                                    </span>
                                @else
                                    <span class="badge badge-soft-warning p-2">Belum dinilai</span>
                                @endif
                            @else
                                <span class="badge badge-soft-danger p-2">Belum dikerjakan</span>
                            @endif
                            <hr>
                            <div class="table-responsive">
                                <table class="table" cellpadding="10">
                                    <tr>
                                        <th style="vertical-align: top">Materi</th>
                                        <td style="vertical-align: top" width="1%">:</td>
                                        <td>
                                            @foreach ($item->assignmentAttachment as $attachment)
                                                @if ($attachment->attachment_type == 'link')
                                                    <a href="{{ $attachment->attachment }}" target="_blank"
                                                        style="margin-right: 10px;white-space: nowrap">
                                                        <i class="fas fa-external-link-alt text-secondary"></i>
                                                        LINK REFERENSI
                                                    </a>
                                                @else
                                                    @php
                                                        $exts = explode('.', $attachment->attachment);
                                                        $ext = end($exts);
                                                    @endphp
                                                    @if ($ext == 'pdf')
                                                        <a href="{{ route('students.skill-assignment.download', $attachment->attachment) }}"
                                                            target="_blank" style="margin-right: 10px;white-space: nowrap">
                                                            <i class="fas fa-file-pdf text-danger"></i>
                                                            {{ str_replace('.pdf', '', $attachment->attachment) }}
                                                        </a>
                                                    @elseif($ext == 'ppt')
                                                        <a href="{{ route('students.skill-assignment.download', $attachment->attachment) }}"
                                                            target="_blank" style="margin-right: 10px;white-space: nowrap">
                                                            <i class="fas fa-file-powerpoint text-danger"></i>
                                                            {{ str_replace('.ppt', '', $attachment->attachment) }}
                                                        </a>
                                                    @elseif($ext == 'docx' || $ext == 'doc')
                                                        <a href="{{ route('students.skill-assignment.download', $attachment->attachment) }}"
                                                            target="_blank" style="margin-right: 10px;white-space: nowrap">
                                                            <i class="fas fa-file-word text-primary"></i>
                                                            @if ($ext == 'docx')
                                                                {{ str_replace('.docx', '', $attachment->attachment) }}
                                                            @else
                                                                {{ str_replace('.doc', '', $attachment->attachment) }}
                                                            @endif
                                                        </a>
                                                    @elseif($ext == 'xls' || $ext == 'xlsx')
                                                        <a href="{{ route('students.skill-assignment.download', $attachment->attachment) }}"
                                                            target="_blank" style="margin-right: 10px;white-space: nowrap">
                                                            <i class="fas fa-file-excel text-success"></i>
                                                            @if ($ext == 'xls')
                                                                {{ str_replace('.xls', '', $attachment->attachment) }}
                                                            @else
                                                                {{ str_replace('.xlsx', '', $attachment->attachment) }}
                                                            @endif
                                                        </a>
                                                    @elseif($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg')
                                                        <a href="{{ route('students.skill-assignment.download', $attachment->attachment) }}"
                                                            target="_blank" style="margin-right: 10px;white-space: nowrap">
                                                            <i class="fas fa-file-image text-secondary"></i>
                                                            @if ($ext == 'jpg')
                                                                {{ str_replace('.jpg', '', $attachment->attachment) }}
                                                            @elseif($ext == 'jpeg')
                                                                {{ str_replace('.jpeg', '', $attachment->attachment) }}
                                                            @else
                                                                {{ str_replace('.png', '', $attachment->attachment) }}
                                                            @endif
                                                        </a>
                                                    @else
                                                        <a href="{{ route('students.skill-assignment.download', $attachment->attachment) }}"
                                                            target="_blank" style="margin-right: 10px;white-space: nowrap">
                                                            <i class="fas fa-file-alt text-secondary"></i>
                                                            {{ $attachment->attachment }}
                                                        </a>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="vertical-align: top">Tugas</th>
                                        <td style="vertical-align: top">:</td>
                                        <td>{{ $item->name }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <table cellpadding="5">
                                                <tr>
                                                    <td style="vertical-align: top">Status</td>
                                                    <td style="vertical-align: top" width="1%">:</td>
                                                    <td>
                                                        @if ($item->skill_assessment->count() > 0)
                                                            <span class="badge badge-soft-success p-2">Telah
                                                                mengumpulkan</span>
                                                        @else
                                                            <span class="badge badge-soft-danger p-2">Belum
                                                                mengumpulkan</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align: top">Keterangan</td>
                                                    <td style="vertical-align: top" width="1%">:</td>
                                                    <td>{{ $item->description }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align: top">Tenggat Waktu</td>
                                                    <td style="vertical-align: top" width="1%">:</td>
                                                    <td>{{ diffHumanReadable($item->end_time) }}</td>
                                                </tr>
                                                @if ($item->is_uploaded)
                                                    <tr>
                                                        <td style="vertical-align: top">File Lampiran</td>
                                                        <td width="1%" style="vertical-align: top">:</td>
                                                        <td>
                                                            @if ($item->skill_assessment->count() > 0)
                                                                @can('create-student-dashboard-assignment')
                                                                    @if($item->skill_assessment[0]->attachment_type == 'link')
                                                                        <a href="{{ $item->skill_assessment[0]->attachment }}" target="_blank" rel="noopener noreferrer">
                                                                            <i class="fa fa-external-link-alt"></i>
                                                                            Lihat Tugas
                                                                        </a>
                                                                        <hr>
                                                                    @else
                                                                        <a href="{{ route('students.knowledge-assignment.download-tugas', $item->skill_assessment[0]->attachment) }}"
                                                                            target="_blank"
                                                                            style="margin-right: 10px;white-space: nowrap">
                                                                            @php $exts = explode('.', $item->skill_assessment[0]->attachment);$ext = end($exts); @endphp
                                                                            @if($ext == 'pdf')
                                                                                <i class="fas fa-file-pdf text-danger"></i>
                                                                                FILE TUGAS
                                                                            @elseif($ext == 'ppt')
                                                                                <i class="fas fa-file-ppt text-danger"></i>
                                                                                FILE TUGAS
                                                                            @elseif($ext == 'doc' || $ext == 'docx')
                                                                                <i class="fas fa-file-word text-primary"></i>
                                                                                FILE TUGAS
                                                                            @elseif($ext == 'xls' || $ext == 'xlsx')
                                                                                <i class="fas fa-file-excel text-success"></i>
                                                                                FILE TUGAS
                                                                            @elseif($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png')
                                                                                <i class="fas fa-file-image text-secondary"></i>
                                                                                FILE TUGAS
                                                                            @else
                                                                                <i class="fas fa-file-alt text-secondaru"></i>
                                                                                FILE TUGAS
                                                                            @endif
                                                                        </a>
                                                                        <hr>
                                                                    @endif
                                                                    @if (checkDateDiff($item->end_time))
                                                                        <button class="btn btn-primary btn-sm showFormUpload"
                                                                            data-id="{{ $item->hashid }}"><i
                                                                                class="fa fa-edit"></i> Edit</button>
                                                                    @endif
                                                                @endcan
                                                            @else
                                                                @if (checkDateDiff($item->end_time))
                                                                    <button class="btn btn-primary btn-sm showFormUpload"
                                                                        data-id="{{ $item->hashid }}"><i
                                                                            class="fa fa-upload"></i> Upload</button>
                                                                @else
                                                                    @if ($item->allow_late_collection)
                                                                        <button
                                                                            class="btn btn-primary btn-sm showFormUpload"
                                                                            data-id="{{ $item->hashid }}"><i
                                                                                class="fa fa-upload"></i> Upload</button>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center my-5">
                <img src="{{ asset('assets/images/oops-pana.svg') }}" alt="" style="max-width: 350px; width: 100%;">
                <h2 class="mt-5">Tidak ada tugas keterampilan</h2>
                <p class="mt-3">Tidak ada tugas keterampilan saat ini!</p>
            </div>
        @endif
    </div>

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('students.skill-assignment.upload') }}" method="post"
                    enctype="multipart/form-data" data-request="ajax" data-reload-view="true">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-upload"></i> Upload</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="">Type <span class="text-danger">*</span></label><br>
                            <label for="file">
                                <input type="radio" name="file_type" id="file" value="file" checked>
                                File
                            </label>
                            <label for="link" class="mx-3">
                                <input type="radio" name="file_type" id="link" value="link">
                                Link
                            </label>
                        </div>
                        <div class="mb-3 d-none" id="formLink">
                            <label for="">Link <span class="text-danger">*</span></label>
                            <textarea name="link" rows="3" class="form-control"></textarea>
                        </div>
                        <div class="mb-3" id="formFile">
                            <label for="">File <span class="text-danger">*</span></label>
                            <input type="hidden" name="hashid">
                            <input type="file" name="file" class="dropify input-file-now" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit"><i class="fa fa-paper-plane"></i> Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
