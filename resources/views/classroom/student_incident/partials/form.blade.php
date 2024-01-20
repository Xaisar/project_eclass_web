    <!-- sample modal content -->
    <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
        data-bs-scroll="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Tambah Jurnal Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ $action }}" method="post" data-request="ajax"
                    data-success-callback="{{ route('classroom.student-incidents', ['course' => hashId(getClassroomInfo()->id)]) }}">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="">Waktu <span class="text-danger">*</span></label>
                            <input type="text" name="date" id="date" class="form-control flatpickr" placeholder="Waktu"
                                autocomplete="off">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Nama Siswa <span class="text-danger">*</span></label>
                            <select name="student" id="student" class="form-control">
                                <option value="">Pilih Siswa</option>
                                @foreach ($students as $item)
                                    <option value="{{ hashId($item->student->id) }}">{{ $item->student->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Kejadian / Perilaku <span class="text-danger">*</span></label>
                            <textarea name="incident" id="incident" class="form-control"
                                placeholder="Kejadian / Perilaku" cols="30" rows="2"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Butir Sikap <span class="text-danger">*</span></label>
                            <select name="attitude_item" id="attitude_item" class="form-control">
                                <option value="">Pilih Butir Sikap</option>
                                <option value="responsibility">Tanggung Jawab</option>
                                <option value="honest">Jujur</option>
                                <option value="mutual_cooperation">Gotong Royong</option>
                                <option value="self_confident">Percaya Diri</option>
                                <option value="discipline">Disiplin</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Positif / Negatif <span class="text-danger">*</span></label>
                            <select name="attitude_value" id="attitude_value" class="form-control">
                                <option value="">Pilih Jenis Kejadian</option>
                                <option value="positive">Positif (+)</option>
                                <option value="negative">Negatif (-)</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Tindak Lanjut <span class="text-danger">*</span></label>
                            <textarea name="follow_up" id="follow_up" class="form-control" placeholder="Tindak Lanjut"
                                cols="30" rows="2"></textarea>
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
