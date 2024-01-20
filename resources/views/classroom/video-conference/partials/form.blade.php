<!-- sample modal content -->
<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="video-conference-modal-title">Buat Video Conference</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ $action }}" id="video-conference-form" method="post" data-request="ajax" enctype="multipart/form-data"
                data-success-callback="{{ route('classroom.video-conference.index', ['course' => hashId(getClassroomInfo()->id)]) }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="start-time">Tanggal <span class="text-danger">*</span></label>
                        <input type="text" id="start-time" name="start_time" class="form-control" placeholder="Tanggal (Format yyyy-mm-dd)" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="meeting-number">Pertemuan Ke- <span class="text-danger">*</span></label>
                        <select name="meeting_number" class="form-control" id="meeting-number">
                            <option value="">Pilih Nomor Pertemuan</option>
                            @foreach ($unattendedMeets as $unattendedMeet)
                                <option class="att-val" value="{{ $unattendedMeet }}">{{ $unattendedMeet }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name">Judul Conference <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Isi judul conference anda" autocomplete="off">
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
