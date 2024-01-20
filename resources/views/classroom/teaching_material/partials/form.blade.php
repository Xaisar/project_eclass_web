    <!-- sample modal content -->
    <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
        data-bs-scroll="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="teaching-material-modal-title">Tambah Bahan Ajar Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ $action }}" id="teaching-material-form" method="post" data-request="ajax" enctype="multipart/form-data"
                    data-success-callback="{{ route('classroom.teaching-materials', ['course' => hashId(getClassroomInfo()->id)]) }}">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="type">Jenis / Format <span class="text-danger">*</span></label>
                            <select name="type" id="type" class="form-control">
                                <option value="">Pilih Jenis Bahan Ajar</option>
                                <option value="file">File</option>
                                <option value="image">Gambar</option>
                                <option value="video">Video</option>
                                <option value="audio">Audio</option>
                                <option value="youtube">Link YouTube</option>
                                <option value="article">Link Artikel</option>
                            </select>
                        </div>
                        <div class="form-group mb-3 attachment"> </div>
                        <div class="form-group mb-3">
                            <label for="name">Nama Bahan Ajar <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Nama Bahan Ajar" autocomplete="off">
                        </div>
                        <div class="form-group mb-3">
                            <label for="core-competence">Kompetensi Inti (KI) <span class="text-danger">*</span></label>
                            <select name="core_competence_id" class="form-control" id="core-competence">
                                <option value="">Pilih Kompetensi Inti</option>
                                @foreach ($coreCompetences as $item)
                                    <option value="{{ $item->id }}">{{ '(' . $item->code . ') - ' . $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="basic-competence">Kompetensi Dasar (KD) <span class="text-danger">*</span></label>
                            <select name="basic_competence_id" class="form-control" id="basic-competence">
                                <option value="">Pilih Kompetensi Dasar</option>
                                @foreach ($basicCompetences as $basicCompetence)
                                    <option value="{{ $basicCompetence->id }}">({{ $basicCompetence->coreCompetence->code }}.{{ $basicCompetence->code }}) {{ $basicCompetence->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3 attachment-link">
                            <label for="attachment-link">Lampiran <span class="text-danger">*</span></label>
                            <input type="text" name="attachment_item" class="form-control" id="attachment-link" placeholder="Masukkan Tautan Lampiran" />
                        </div>
                        <div class="form-group mb-3 attachment-media d-none">
                            <label for="attachment-media">Lampiran <span class="text-danger">*</span></label>
                            <input type="file" name="attachment_item" class="form-control custom-dropify-error-message" id="attachment-media" />
                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Keterangan </label>
                            <textarea name="description" class="form-control" id="description" cols="30"
                                rows="3"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Share Bahan Ajar ? </label>
                            <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                <input type="checkbox" class="form-check-input" id="share-material" name="is_share">
                                <label class="form-check-label" for="share-material"></label>
                            </div>
                            <small>Bahan Ajar yang Anda bagikan
                                apakah akan langsung dishare ke siswa ?</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary waves-effect wafes-primary mx-1" type="submit"><i class="fa fa-paper-plane"></i> Submit</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
