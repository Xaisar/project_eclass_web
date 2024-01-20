initDataTable('#dataTable', [{
        name: 'hashid',
        data: 'hashid',
        width: "1%",
        sClass: "text-center",
        mRender: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        },
    },
    {
        name: 'course_name',
        data: 'course_name',
        mRender: function (data, type, row) {
            return ` <h5 class="font-size-15 text-truncate">
                        <a href="#"class="text-dark">${data}</a>
                    </h5>
                     <ul class="list-inline">
                        <li class="list-inline-item me-3">
                            <a href="javascript: void(0);" class="text-muted">
                                <i class="bx bx-group align-middle text-muted me-1"></i>
                                ${row.student_count} Siswa
                            </a>
                        </li>
                        <li class="list-inline-item me-3">
                            <a href="javascript: void(0);" class="text-muted">
                                <i class="bx bx-package align-middle text-muted me-1"></i>
                                ${row.kd_count} KD
                            </a>
                        </li>
                        <li class="list-inline-item me-3">
                            <a href="javascript: void(0);" class="text-muted">
                                <i class="bx bx-award align-middle text-muted me-1"></i>
                                ${row.grade} KKM
                            </a>
                        </li>
                        <li class="list-inline-item me-3">
                            <a href="javascript: void(0);" class="text-muted">
                                <i class="bx bx-video-plus align-middle text-muted me-1"></i>
                                ${row.number_of_meetings} Pertemuan
                            </a>
                        </li>
                    </ul>
                    `
        }
    },
    {
        name: 'class_group',
        data: 'class_group',
    },
    {
        name: 'study_year',
        data: 'study_year',
        mRender: function (data, type, row) {
            return `${data}/${parseInt(data)+1} - ${row.semester == 1 ? 'Ganjil' : 'Genap'}`;
        }
    },
    {
        name: 'status',
        data: 'status',
        mRender: function (data, type, row, meta) {
            let render = `${row.status == 'open' ? '<div class="badge badge-soft-success font-size-12">Aktif</div>' : '<div class="badge badge-soft-danger font-size-12">Tidak Aktif</div>'}`;
            return render;
        }
    },
]);
