    <!-- sample modal content -->
    <div id="course" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add-course-modal">
                        Tambah Course Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="course-form" action="{{ $action }}" method="post" data-request="ajax" enctype="multipart/form-data" data-success-callback="{{ route('course') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="">Kelas <span class="text-danger">*</span></label>
                            <select name="class_group_id" id="class-group-id" class="form-control">
                                <option value="">Pilih Kelas</option>
                                @foreach ($classGroup as $cg)
                                    <option value="{{ $cg->hashid }}">{{ $cg->degree->degree }} {{ $cg->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Guru <span class="text-danger">*</span> </label>
                            <select name="teacher_id" id="teacher-id" class="form-control">
                                <option value="">Pilih Guru</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->hashid }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Mata Pelajaran <span class="text-danger">*</span></label>
                            <select name="subject_id" id="subject-id" class="form-control">
                                <option value="">Pilih Mata Pelajaran</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->hashid }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Tahun Ajaran <span class="text-danger">*</span></label>
                            <select name="study_year_id" id="study-year-id" class="form-control">
                                <option value="">Pilih Tahun Ajaran</option>
                                @foreach ($studyYears as $studyYear)
                                    <option value="{{ $studyYear->hashid }}">{{ $studyYear->year }} / {{ $studyYear->year + 1 }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Semester <span class="text-danger">*</span></label>
                            <select name="semester" id="semester" class="form-control">
                                <option value="1">Ganjil</option>
                                <option value="2">Genap</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Status <span class="text-danger">*</span></label>
                            <select name="status" id="stts" class="form-control">
                                <option value="open">Dibuka</option>
                                <option value="close">Ditutup</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Jumlah Pertemuan <span class="text-danger">*</span></label>
                            <input name="meeting_numbers" id="meeting-number" type="number" class="form-control" value="1">
                        </div>
                        <div class="form-group mb-3 attachment-media">
                            <label for="attachment-media">Thumbnail</label>
                            <input type="file" name="thumbnail_img" class="form-control custom-dropify-error-message dropify" id="attachment-media" />
                        </div>
                        <div class="form-group">
                            <label for="">Keterangan</label>
                            <textarea class="form-control" name="description" id="description" cols="30" rows="3"></textarea>
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
