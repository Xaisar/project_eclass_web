@extends('layouts.ajax')
@section('breadcrumb')
  <ol class="breadcrumb">
    <li class="breadcrumb-item">{{ getSetting('web_name') }}</li>
    <li class="breadcrumb-item"><a href="{{ route('students.dashboard') }}" data-toggle="ajax">Dashboard</a></li>
    <li class="breadcrumb-item active">{{ $title }}</li>
  </ol>
@endsection

@section('content')
  <div class="mb-4">
    <div class="text-start">
      <a href="{{ route('students.dashboard') }}" class="btn btn-light waves-effect mr-2 waves-light" data-toggle="ajax"><i
          class="fa fa-arrow-left"></i> Kembali</a>
    </div>
  </div>
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
                  {{-- @canany(['update-student-dashboard-class-detail', 'update-users']) --}}
                  @can('update-student-dashboard-update-profile')
                    <button data-toggle="ajax" data-target="{{ route('students.profile.update') }}"
                      class="btn btn-block btn-outline-primary mt-2"><i class="fa fa-user"></i> Ganti
                      Profil</button>
                  @endcan
                  {{-- @can('update-users') --}}
                  <button data-toggle="ajax"
                    data-target="{{ route('students.update-password', Hashids::encode(getInfoLogin()->id)) }}"
                    class="btn btn-block btn-outline-warning mt-2"><i class="fa fa-lock"></i> Ganti
                    Password</button>
                  {{-- @endcan --}}
                  {{-- @endcanany --}}
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-9">
          <div class="card">
            <div class="card-header">
              <h4>Profil Anda</h4>
            </div>
            <div class="card-body">
              <table class="table table-bordered">
                <tbody>
                  <tr>
                    <td>
                      <h5>NIS / NISN <small class="text-danger">*Username</small></h5>
                    </td>
                    <td>{{ getInfoLogin()->userable->identity_number }}</td>
                  </tr>
                  <tr>
                    <td>
                      <h5>NAMA</h5>
                    </td>
                    <td>{{ getInfoLogin()->userable->name }}</td>
                  </tr>
                  <tr>
                    <td>
                      <h5>NOMOR TELEPON</h5>
                    </td>
                    <td> {{ getInfoLogin()->userable->phone_number }}</td>
                  </tr>
                  <tr>
                    <td>
                      <h5>EMAIL</h5>
                    </td>
                    <td> {{ getInfoLogin()->userable->email }}</td>
                  </tr>
                  <tr>
                    <td>
                      <h5>JENIS KELAMIN</h5>
                    </td>
                    <td>{{ getInfoLogin()->userable->gender == 'male' ? 'Laki-Laki' : 'Perempuan' }}
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <h5>TEMPAT LAHIR</h5>
                    </td>
                    <td>{{ getInfoLogin()->userable->birthplace }}</td>
                  </tr>
                  <tr>
                    <td>
                      <h5>TANGGAL LAHIR</h5>
                    </td>
                    <td>{{ getInfoLogin()->userable->birthdate }}</td>
                  </tr>
                  <tr>
                    <td>
                      <h5>NO. TELEPON ORANG TUA</h5>
                    </td>
                    <td>{{ getInfoLogin()->userable->parent_phone_number }} </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
