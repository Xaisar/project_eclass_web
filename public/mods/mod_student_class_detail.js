initDataTable("#dataTable", [
    {
        name: "hashid",
        data: "hashid",
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
        name: "identity_number",
        data: "identity_number",
    },
    {
        name: "name",
        data: "name",
        mRender: function (data, type, row) {
            let render = `<img src="${$('meta[name="base-url"]').attr(
                "content"
            )}/assets/images/users/${
                row.picture
            }" alt="" class="avatar-sm rounded-circle me-2">
                            <strong>${row.name}</strong>`;
            return render;
        },
    },
    {
        name: "gender",
        data: "gender",
        mRender: function (data, type, row) {
            return data == "male"
                ? "Laki-Laki"
                : data == "female"
                ? "Perempuan"
                : "Lainnya";
        },
    },
    {
        name: "email",
        data: "email",
    },
    {
        name: "phone",
        data: "phone",
    },
    {
        name: "shift",
        data: "shift",
        mRender: function (data, type, row) {
            let jsonObj = JSON.parse(data);
            return jsonObj.start_entry + " - " + jsonObj.start_exit;
        },
    },
    {
        name: "status",
        data: "status",
        mRender: function (data, type, row) {
            let render = ``;
            if (data == true) {
                render = `<div class="badge badge-soft-success font-size-12">Aktif</div>`;
            } else {
                render = `<div class="badge badge-soft-danger font-size-12">Tidak Aktif</div>`;
            }
            return render;
        },
    },
    {
        name: "hashid",
        data: "hashid",
        sortable: false,
        searchable: false,
        width: "3%",
        sClass: "text-center",
        mRender: function (data) {
            var render = ``;
            if (userPermissions.includes("delete-student-classes")) {
                render += `
                    <button class="btn btn-sm btn-danger waves-effect waves-light" data-toggle="delete" data-id="${data}"><i class="bx bx-trash"></i></button>
                `;
            }

            return render;
        },
    },
]);

$(".add-student").on("click", function () {
    $("#studentsModal").modal("show");
    fetchStudents();
});

function fetchStudents() {
    studentTable();
}

function studentTable() {
    let url = $("#studentsTable").data("url");
    $("#studentsTable").DataTable().destroy();
    const table = $("#studentsTable").DataTable({
        serverSide: true,
        processing: true,
        ajax: url,
        columns: [
            {
                name: "hashid",
                data: "hashid",
                sortable: false,
                searchable: false,
                mRender: function (data, type, row) {
                    return `
                <td>
                    <div class="form-check font-size-16">
                        <input type="checkbox" name="hashid[]" class="form-check-input check-student" value="${data}">
                        <label class="form-check-label"></label>
                    </div>
                </td>`;
                },
            },
            {
                name: "identity_number",
                data: "identity_number",
            },
            {
                name: "name",
                data: "name",
                mRender: function (data, type, row) {
                    let render = `<img src="${$('meta[name="base-url"]').attr(
                        "content"
                    )}/assets/images/users/${
                        row.picture
                    }" alt="" class="avatar-sm rounded-circle me-2">
                            <strong>${row.name}</strong>`;
                    return render;
                },
            },
            {
                name: "gender",
                data: "gender",
                mRender: function (data, type, row) {
                    return data == "male"
                        ? "Laki-Laki"
                        : data == "female"
                        ? "Perempuan"
                        : "Lainnya";
                },
            },
        ],
        responsive: true,
        // drawCallback,
    });

    table.on("responsive-display", () => {
        mainAct();
    });

    table.on("draw.dt", () => {
        mainAct();
    });
    window.tableDataTable = table;
    return table;
}

$("#check-all-student").click(function () {
    if ($("#check-all-student:checkbox:checked").length) {
        $(".check-student:checkbox").prop("checked", true);
    } else {
        $(".check-student:checkbox").prop("checked", false);
    }
});
