if (typeof table == "undefined") {
    let table = null;
}

table = initDataTable(
    "#dataTable",
    [
        {
            name: "hashid",
            data: "hashid",
            width: "5%",
            sortable: false,
            searchable: false,
            mRender: function (data, type, row) {
                return `
                <td>
                    <div class="form-check font-size-16">
                        <input type="checkbox" class="form-check-input bulk-delete" value="${data}">
                        <label class="form-check-label"></label>
                    </div>
                </td>`;
            },
        },
        {
            name: "course_name",
            data: "course_name",
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
                    `;
            },
        },
        {
            name: "teacher_name",
            data: "teacher_name",
            mRender: function (data, type, row) {
                return ` <div class="row">
                            <div class="col-md-2">
                                <img src="${$('meta[name="base-url"]').attr(
                                    "content"
                                )}/assets/images/teachers/${
                    row.teacher_picture
                }" alt="" class="avatar-sm rounded-circle me-2">
                            </div>
                            <div class="col-md-10">
                                <strong>${data}</strong><br>
                                <span class="small">${
                                    row.identity_number
                                }</span>
                            </div>
                        </div>`;
            },
        },
        {
            name: "class_group",
            data: "class_group",
        },
        {
            name: "study_year",
            data: "study_year",
            mRender: function (data, type, row) {
                return `${data}/${parseInt(data) + 1} - ${
                    row.semester == 1 ? "Ganjil" : "Genap"
                }`;
            },
        },
        {
            name: "status",
            data: "status",
            mRender: function (data, type, row, meta) {
                let render = `${
                    row.status == "open"
                        ? '<div class="badge badge-soft-success font-size-12">Aktif</div>'
                        : '<div class="badge badge-soft-danger font-size-12">Tidak Aktif</div>'
                }`;
                return render;
            },
        },
        {
            name: "status",
            data: "status",
            mRender: function (data, type, row, meta) {
                let render = `<input type="checkbox"  id="switch${
                    meta.row + meta.settings._iDisplayStart + 1
                }"  onclick="updateStatus(this, '${
                    row.hashid
                }')" switch="none" ${
                    data == "open" ? `checked` : ``
                } class="cb-${row.hashid}" />
                        <label for="switch${
                            meta.row + meta.settings._iDisplayStart + 1
                        }" data-on-label="On" data-off-label="Off"></label>`;
                return render;
            },
        },
        {
            name: "hashid",
            data: "hashid",
            sortable: false,
            searchable: false,
            mRender: function (data) {
                var render = ``;

                if (userPermissions.includes("update-course")) {
                    render += `
                        <button class="btn btn-sm btn-primary waves-effect waves-light edit-btn" data-id="${data}"><i class="bx bx-edit-alt"></i></button>
                        `;
                }

                if (userPermissions.includes("read-course")) {
                    render += `
                <button class="btn btn-sm btn-warning waves-effect detail waves-light" title="detail" data-toggle="ajax" data-target="${$(
                    'meta[name="base-url"]'
                ).attr(
                    "content"
                )}/administrator/course/${data}/detail"><i class="bx bxs-user-detail"></i></button>
            `;
                }

                if (userPermissions.includes("delete-course")) {
                    render += `
                    <button class="btn btn-sm btn-danger waves-effect waves-light" title="hapus" data-toggle="delete" data-id="${data}"><i class="bx bx-trash"></i></button>
                `;
                }

                return render;
            },
        },
    ],
    function () {
        scanEditBtn();
    }
);

table.on("responsive-display", function () {
    scanEditBtn();
});

function scanEditBtn() {
    $(".edit-btn").on("click", async function (e) {
        e.preventDefault();
        const { data } = await $.ajax({
            url: `${$("meta[name=base-url]").attr(
                "content"
            )}/administrator/course/${$(this).data("id")}/show`,
            dataType: "json",
        });
        $("#class-group-id").val(data.class_group.hashid);
        $("#teacher-id").val(data.teacher.hashid);
        $("#subject-id").val(data.subject.hashid);
        $("#study-year-id").val(data.study_year.hashid);
        $("#semester").val(data.semester);
        $("#stts").val(data.status);
        $("#meeting-number").val(data.number_of_meetings);
        $("#description").html(data.description);
        $("#course-form").data(
            "action",
            `${$("meta[name=base-url]").attr(
                "content"
            )}/administrator/course/${$(this).data("id")}/update`
        );
        $("#add-course-modal").html("Edit Course");
        $("#course").modal("show");
    });
}

if ($(".dropify").length > 0) {
    $(".dropify").dropify();
}

$(".add-course-btn").on("click", function () {
    $("#add-course-modal").html("Tambah Course Baru");
    $("#course-form")[0].reset();
});

$(".filter-form").on("change", function (e) {
    let params = {};
    if ($("#year").val() != "") params.study_year_id = $("#year").val();
    if ($("#semester").val() != "") params.semester = $("#semester").val();
    if ($("#class_group").val() != "")
        params.class_group_id = $("#class_group").val();

    table.ajax
        .url(
            `${$("meta[name=base-url]").attr(
                "content"
            )}/administrator/course/getData?${$.param(params)}`
        )
        .load();
});

async function updateStatus(el, hashid) {
    const data = await $.ajax({
        url: `${$("meta[name=base-url]").attr(
            "content"
        )}/administrator/course/${hashid}/update-status`,
        method: "get",
    });
    table.ajax.reload();
    showToast("success", "Berhasil mengupdate status course");
}
