<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ $action }}" method="post" data-request="ajax" enctype="multipart/form-data">
                <div class="modal-header align-items-center d-flex">
                    <h4 class="modal-title mb-0 flex-grow-1">{{ $title }}</h4>
                    <div class="flex-shrink-0">
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-edit"></i></span>
                                    <span class="d-none d-sm-block">Tugas</span> 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-file-alt"></i></span>
                                    <span class="d-none d-sm-block nowrap">File Instruksi</span> 
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane active" id="home1" role="tabpanel">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-12 py-2">
                                        <label for="">Skema Penilaian <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col">
                                        <select name="scheme" class="form-control js-choices">
                                            <option value="">Pilih Skema Penilaian</option>
                                            <option value="practice" {{ isset($assignment) && $assignment->scheme == 'practice' ? 'selected' : ''}}>Unjuk Kerja / Praktek</option>
                                            <option value="project" {{ isset($assignment) && $assignment->scheme == 'project' ? 'selected' : ''}}>Proyek</option>
                                            <option value="portfolio" {{ isset($assignment) && $assignment->scheme == 'portfolio' ? 'selected' : ''}}>Portofolio</option>
                                            <option value="product" {{ isset($assignment) && $assignment->scheme == 'product' ? 'selected' : ''}}>Produk</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-12 py-2">
                                        <label for="">Nama Penilaian <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col">
                                        <input type="text" name="name" class="form-control" placeholder="Nama Penilaian, Contoh : Praktik Presentasi" autocomplete="off" value="{{ isset($assignment) ? $assignment->name : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-12 py-2">
                                        <label for="">Kompetensi Dasar (KD)</label>
                                    </div>
                                    <div class="col">
                                        @if(isset($assignment))
                                            @foreach($basicCompetence as $item)
                                                @php $hashid = []; @endphp
                                                @foreach($assignment->assignmentDetail as $assignmentDetail)
                                                    @php $hashid[] = Hashids::encode($assignmentDetail->basic_competence_id); @endphp
                                                @endforeach
                                                <label for="{{ $item->hashid }}">
                                                    <div class="d-flex align-items-center">
                                                        <div class="inline mx-3"><input type="checkbox" name="basic_competence[]" class="form-check-input" value="{{ $item->hashid }}" id="{{ $item->hashid }}" {{ in_array($item->hashid, $hashid) ? 'checked' : '' }}></div>
                                                        <div class="inline">{{ $item->coreCompetence->code }}.{{ $item->code }} {{ $item->name }}.</div>
                                                    </div>
                                                </label>
                                            @endforeach
                                        @else
                                            @foreach($basicCompetence as $item)
                                                <label for="{{ $item->hashid }}">
                                                    <div class="d-flex align-items-center">
                                                        <div class="inline mx-3"><input type="checkbox" name="basic_competence[]" class="form-check-input" value="{{ $item->hashid }}" id="{{ $item->hashid }}"></div>
                                                        <div class="inline">{{ $item->coreCompetence->code }}.{{ $item->code }} {{ $item->name }}.</div>
                                                    </div>
                                                </label>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-12 py-2">
                                        <label for="">Mulai Pengerjaan Tugas <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col">
                                        <input type="text" name="start_time" class="form-control flatpickr-input datepicker" placeholder="Mulai Pengerjaan Tugas" autocomplete="off" id="start_time" value="{{ isset($assignment) ? date('Y-m-d H:i', strtotime($assignment->start_time)) : date('m-d-Y H:i') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-12 py-2">
                                        <label for="">Batas Pengerjaan Tugas <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col">
                                        <input type="text" name="end_time" class="form-control flatpickr-input datepicker" placeholder="Mulai Pengerjaan Tugas" autocomplete="off" id="end_time" value="{{ isset($assignment) ? date('m-d-Y H:i', strtotime($assignment->end_time)) : date('m-d-Y H:i') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-12 py-2">
                                        <label for="">Keterangan</label>
                                    </div>
                                    <div class="col">
                                        <textarea name="description" rows="3" class="form-control">{{ isset($assignment) ? $assignment->description : '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-12">
                                        <label for="">Izinkan pengumpulan terlambat</label>
                                    </div>
                                    <div class="col">
                                        <div class="form-check form-switch form-switch-md" dir="ltr">
                                            <input type="checkbox" class="form-check-input" name="allow_late_collection" id="customSwitchsizemd" value="1" {{ isset($assignment) && $assignment->is_uploaded ? 'checked' : ''}}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-12">
                                        <label for="">Upload Tugas</label>
                                    </div>
                                    <div class="col">
                                        <div class="form-check form-switch form-switch-md" dir="ltr">
                                            <input type="checkbox" class="form-check-input" name="is_uploaded" id="customSwitchsizemd" value="1" {{ isset($assignment) && $assignment->is_uploaded ? 'checked' : ''}}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-12">
                                    
                                </div>
                                <div class="col">
                                    <div class="alert alert-info">
                                        <strong>INFO</strong> : Jika tugas harus diupload oleh Siswa Aplikasi, silahkan aktifkan panel upload tugas.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="profile1" role="tabpanel">
                            @if(isset($assignment) && $assignment->assignmentAttachment->count() > 0)
                                <div id="tableContent">
                                    <table class="table table-bordered" width="100%">
                                        <tr>
                                            <th>Instruksi</th>
                                            <th></th>
                                        </tr>
                                        @foreach($assignment->assignmentAttachment as $attachment)
                                            <tr id="{{ $attachment->hashid }}">
                                                <td>{{ $attachment->attachment }}</td>
                                                <td>
                                                    @if($attachment->attachment_type == 'link')
                                                        <a href="{{ $attachment->attachment }}" target="_blank" class="btn btn-outline-primary btn-sm"><i class="fa fa-eye"></i></a>
                                                    @else
                                                        <a href="" target="_blank" class="btn btn-outline-primary btn-sm"><i class="fa fa-eye"></i></a>
                                                    @endif
                                                    <button class="btn btn-outline-danger btn-sm delete-instruksi" type="button" data-id="{{ $attachment->hashid }}"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    <hr class="my-4">
                                </div>
                            @endif
                            <div id="content">
                                <div class="element" id="element1">
                                    <div class="mb-3">
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-md-4 col-sm-4 col-12">
                                                    <label for="">Apa yang mau anda kirim ?</label>
                                                </div>
                                                <div class="col">
                                                    <select class="form-control file-link" name="attachment_type[]" data-id="#element1">
                                                        <option value="">Pilih jenis pengiriman</option>
                                                        <option value="1">Upload file instruksi berupa dokumen atau video</option>
                                                        <option value="2">Link instruksi berupa link eksternal</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 d-none uploadFile">
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-md-4 col-sm-4 col-12">
                                                    <label for="">Upload File</label>
                                                </div>
                                                <div class="col">
                                                    <input type="file" name="file[]" id="input-file-now" class="dropify" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 d-none inputLink">
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-md-4 col-sm-4 col-12">
                                                    <label for="">Masukkan Link</label>
                                                </div>
                                                <div class="col">
                                                    <input type="text" name="link[]" class="form-control" placeholder="Contoh : https://m.youtube.com" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <button class="btn btn-success btn-sm" type="button" id="addForm"><i class="fa fa-plus"></i> Tambah Form</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Kembali</button>
                    <button class="btn btn-primary" type="submit"><i class="fa fa-paper-plane"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>