    <!-- sample modal content -->
    <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
      data-bs-scroll="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">Tambah Pengumuman Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="{{ $action }}" method="post" data-request="ajax"
            data-success-callback="{{ route('announcements') }}">
            <div class="modal-body">
              <div class="form-group mb-3">
                <label for="">Judul <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="title" id="title" placeholder="Judul"
                  autocomplete="off">
              </div>
              <div class="form-group mb-3">
                <label for="">Isi Pengumuman <span class="text-danger">*</span></label>
                <textarea name="content" id="content" class="form-control" placeholder="Isi Pengumuman" cols="30" rows="2"></textarea>
              </div>
              <div class="form-group mb-3">
                <label for="">Untuk Siapa Pengumuman Dibuat ? <span class="text-danger">*</span></label>
                <select name="recipient" id="recipient" class="form-control">
                  <option value="all">Semua (Guru dan Siswa)</option>
                  <option value="teachers">Guru</option>
                  <option value="students">Siswa</option>
                </select>
              </div>
              <div class="form-group mb-3">
                <label for="">Waktu Mulai <span class="text-danger">*</span></label>
                <input type="text" name="start_time" id="start_time" class="form-control flatpickr"
                  placeholder="Waktu Mulai" autocomplete="off">
              </div>
              <div class="form-group mb-3">
                <label for="">Waktu Berakhir <span class="text-danger">*</span></label>
                <input type="text" name="end_time" id="end_time" class="form-control flatpickr"
                  placeholder="Waktu Berakhit" autocomplete="off">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
              <button class="btn btn-primary waves-effect wafes-primary mx-1" type="submit"><i
                  class="fa fa-paper-plane"></i> Submit</button>
            </div>
          </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
