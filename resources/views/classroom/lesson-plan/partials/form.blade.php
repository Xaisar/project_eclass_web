<!-- sample modal content -->
<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lesson-plan-modal-title">Tambah Kelas RPP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ $action }}" id="lesson-plan-form" method="post" data-request="ajax" enctype="multipart/form-data"
                data-success-callback="{{ route('classroom.lesson-plan.index', ['course' => hashId(getClassroomInfo()->id)]) }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="date">Tanggal <span class="text-danger">*</span></label>
                        <input type="text" id="date" name="date" class="form-control" placeholder="Tanggal (Format yyyy-mm-dd)" autocomplete="off">
                    </div>
                    <div class="form-group mb-3 attachment-media">
                        <label for="file-media">File <span class="text-danger">*</span></label>
                        <input type="file" name="file_item" class="form-control custom-dropify-error-message" id="file-media" />
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
