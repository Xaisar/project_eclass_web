    <!-- sample modal content -->
    <div id="send-broadcast" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
      data-bs-scroll="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="basic-competence-modal-title">Broadcast WA</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="{{ $action }}" id="basic-competence-form" method="post" data-request="ajax"
            enctype="multipart/form-data"
            data-success-callback="{{ route('classroom.broadcast_wa.index', ['course' => hashId(getClassroomInfo()->id)]) }}">
            <div class="modal-body">
              <div class="form-group mb-3">
                <label for="">Pesan Broadcast</label>
                <textarea id="message" cols="30" rows="10" name="message" class="form-control"></textarea>
              </div>
              <div class="form-group mb-3">
                <label for="">Kirim ke Orang Tua ? </label>
                <div class="form-check form-switch form-switch-md" dir="ltr">
                  <input type="checkbox" class="form-check-input" id="send-parent" name="is_parent">
                  <label class="form-check-label" for="send-parent"></label>
                </div>
                <small>Jika diaktifkan maka pesan akan dikirimkan ke nomor orang tua siswa sekaligus</small>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
              <button class="btn btn-primary waves-effect wafes-primary mx-1" type="submit"><i
                  class="fa fa-paper-plane"></i> Kirim</button>
            </div>
          </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
