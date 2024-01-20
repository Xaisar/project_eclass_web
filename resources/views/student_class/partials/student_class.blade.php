    <!-- sample modal content -->
    <div id="studentClassModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
        data-bs-scroll="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="student-content d-none">
                        <table class="table align-middle datatable dt-responsive table-check nowrap"
                            id="student-class-table"
                            style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>NIS / NISN</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No. HP</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="student-body">
                            </tbody>
                        </table>
                    </div>
                    <div class="ilustration-content">
                        <img src="{{ asset('assets/images/illustration/empty.svg') }}" class="mx-auto d-block"
                            style="max-width: 400px" alt="">
                        <h4 class="text-center">Opps! Tidak ada siswa di kelas ini..</h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
