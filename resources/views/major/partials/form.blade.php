    <!-- sample modal content -->
    <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
        data-bs-scroll="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Tambah Jurusan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ $action }}" method="post" data-request="ajax"
                    data-success-callback="{{ route('majors') }}">
                    <div class="modal-body">
                        <div class="alert alert-info alert-border-left alert-dismissible fade show mb-3" role="alert">
                            <i class="mdi mdi-alert-circle-outline align-middle me-3"></i><strong>Info</strong>: Jurusan
                            yang telah dibuat akan otomatis aktif.
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Nama Jurusan <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Nama Jurusan"
                                autocomplete="off">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Singkatan <span class="text-danger">*</span></label>
                            <input type="text" name="short_name" id="short_name" class="form-control"
                                placeholder="Singkatan" autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect"
                            data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary waves-effect wafes-primary mx-1" type="submit"><i
                                class="fa fa-paper-plane"></i> Submit</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
