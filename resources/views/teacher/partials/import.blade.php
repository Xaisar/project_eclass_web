    <!-- sample modal content -->
    <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
        data-bs-scroll="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Import Guru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('teacher.import') }}" method="post" data-request="ajax"
                    data-success-callback="{{ route('teacher') }}" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <a href="{{ route('teacher.exportTemplate') }}"
                                class="btn btn-soft-primary waves-effect waves-light"><i class="bx bx-download"></i>
                                Download Template Import</a>
                        </div>
                        <div class="form-group">
                            <label for="">File <span class="text-danger">*</span></label>
                            <input type="file" name="file" id="input-file-now" class="dropify" />
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
