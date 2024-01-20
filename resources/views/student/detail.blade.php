@extends('layouts.ajax')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{ getSetting('web_name') }}</li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" data-toggle="ajax">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('student') }}">Siswa</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="text-end">
                <button class="btn btn-danger" data-toggle="delete"
                    data-url="{{ route('student.delete', $student->hashid) }}" data-callback="{{ route('student') }}"><i
                        class="fa fa-trash-alt"></i> Hapus</button>
                <button class="btn btn-primary" data-toggle="ajax"
                    data-target="{{ route('student.edit', $student->hashid) }}"><i class="fa fa-edit"></i>
                    Edit</button>
            </div>
            <div class="text-center mb-3">
                <div style="border-radius: 50%">
                    <img src="{{ asset('assets/images/students/' . $student->picture) }}" width="150" alt="">
                </div>
                <hr>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <table cellpadding="10">
                        <tr>
                            <th style="white-space: nowrap">UID</th>
                            <td>: {{ $student->uid }}</td>
                        </tr>
                        <tr>
                            <th style="white-space: nowrap">Nomor Identitas</th>
                            <td>: {{ $student->identity_number }}</td>
                        </tr>
                        <tr>
                            <th style="white-space: nowrap">Nama</th>
                            <td>: {{ $student->name }}</td>
                        </tr>
                        <tr>
                            <th style="white-space: nowrap">Jurusan</th>
                            <td>: {{ $student->major->name }}</td>
                        </tr>
                        <tr>
                            <th style="white-space: nowrap">Jenis Kelamin</th>
                            <td>:
                                {{ $student->gender == 'male' ? 'Laki - laki' : ($student->gender == 'female' ? 'Perempuan' : 'Lainnya') }}
                            </td>
                        </tr>
                        <tr>
                            <th style="white-space: nowrap">Tempat, Tanggal Lahir</th>
                            <td>: {{ $student->birthplace }}, {{ date('d M Y', strtotime($student->birthdate)) }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table cellpadding="10">
                        <tr>
                            <th style="white-space: nowrap">Email</th>
                            <td>: {{ $student->email }}</td>
                        </tr>
                        <tr>
                            <th style="white-space: nowrap">Nomor Telp/Hp</th>
                            <td>: {{ $student->phone_number }}</td>
                        </tr>
                        <tr>
                            <th style="white-space: nowrap">Nomor Telp/Hp Ortu</th>
                            <td>: {{ $student->parent_phone_number }}</td>
                        </tr>
                        <tr>
                            <th style="vertical-align: top;white-space: nowrap">Alamat</th>
                            <td class="d-flex">
                                <div class="d-inline">:</div>
                                <div class="d-inline" style="padding-left: 3px">
                                    {{ $student->address }} asfasfd afsdfas fasdfsdf asfsf asdfs fafsdfsdfsadf
                                    sfafasdfsdf adsfdsfasf
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th style="white-space: nowrap">Status</th>
                            <td>:
                                @if ($student->status == 1)
                                    <span class="badge badge-soft-success">Aktif</span>
                                @else
                                    <span class="badge badge-soft-danger">Tidak Aktif</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
