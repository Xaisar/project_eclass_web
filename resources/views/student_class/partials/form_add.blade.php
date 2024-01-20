    <!-- sample modal content -->
    <div id="studentsModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
        data-bs-scroll="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Tambahkan Siswa Ke Dalam Kelas
                        {{ $classGroup->degree->degree }} {{ $classGroup->name }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ $action }}" method="post" data-request="ajax"
                    data-success-callback="{{ route('student-classes.students', ['classGroup' => hashId($classGroup->id)]) }}">
                    @csrf
                    <div class="  modal-body">
                        <table class="table align-middle datatable dt-responsive table-check nowrap" id="studentsTable"
                            style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;"
                            data-url="{{ route('student-classes.students.getStudents', ['classGroup' => hashId($classGroup->id)]) }}">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 30px;">
                                        <div class="form-check font-size-16">
                                            <input type="checkbox" class="form-check-input" id="check-all-student">
                                            <label class="form-check-label" for="check-all-student"></label>
                                        </div>
                                    </th>
                                    <th>NIS / NISN</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                </tr>
                            </thead>
                        </table>
                        <div class="form-group mt-4">
                            <label for="">Pilih Shift <span class="text-danger">*</span></label>
                            <select name="shift" class="form-control" id="shift">
                                @foreach ($shifts as $item)
                                    <option value="{{ hashId($item->id) }}">{{ $item->name }}
                                        ({{ $item->start_entry . ' - ' . $item->start_exit }})</option>
                                @endforeach
                            </select>
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
