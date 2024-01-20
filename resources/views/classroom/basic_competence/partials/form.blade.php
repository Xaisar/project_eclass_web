    <!-- sample modal content -->
    <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
        data-bs-scroll="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="basic-competence-modal-title">Tambah Kompetensi Dasar Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ $action }}" id="basic-competence-form" method="post" data-request="ajax" enctype="multipart/form-data"
                    data-success-callback="{{ route('classroom.basic-competences.index', ['course' => hashId(getClassroomInfo()->id)]) }}">
                    <div class="modal-body">
                        <div class="form-group mb-3 attachment"> </div>
                        <div class="form-group mb-3">
                            <label for="name">Nama Kompetensi Dasar <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Nama Kompetensi Dasar" autocomplete="off">
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
                            <label for="semester">Semester <span class="text-danger">*</span></label>
                            <select name="semester" class="form-control" id="semester">
                                <option value="">Pilih Semester</option>
                                <option value="1">Ganjil</option>
                                <option value="2">Genap</option>
                            </select>
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
