if (typeof table == "undefined") {
    let table = null;
}

table = initDataTable(
    "#dataTable",
    [
        {
            name: "hashid",
            data: "hashid",
            sortable: false,
            searchable: false,
            width: "4%",
            mRender: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            },
        },
        {
            name: "code",
            data: "code",
            mRender(data, type, row) {
                return `${row.core_competence.code}.${data}`;
            },
        },
        {
            name: "name",
            data: "name",
        },
        {
            name: "core_competence_name",
            data: "core_competence_name",
        },
        {
            name: "semester",
            data: "semester",
            mRender(col, type, row) {
                return parseInt(col) % 2 == 0 ? "Genap" : "Ganjil";
            },
        },
        {
            name: "hashid",
            data: "hashid",
            sortable: false,
            searchable: false,
            mRender: function (data) {
                var render = ``;

                if (userPermissions.includes("update-basic-competence")) {
                    render += `
                        <button class="btn btn-sm btn-primary waves-effect waves-light edit-btn" data-id="${data}"><i class="bx bx-edit-alt"></i></button>
                    `;
                }

                if (userPermissions.includes("update-basic-competence")) {
                    render += `
                        <button class="btn btn-sm btn-danger waves-effect waves-light" data-toggle="delete" data-id="${data}"><i class="bx bx-trash"></i></button>
                    `;
                }

                return render;
            },
        },
    ],
    function () {
        if ($(".edit-btn").length > 0) {
            $(".edit-btn").on("click", editBtnAction);
        }
    }
);

table.on("responsive-display", function () {
    if ($(".edit-btn").length > 0) {
        $(".edit-btn").on("click", editBtnAction);
    }
});
if ($(".add-btn").length > 0) {
    $(".add-btn").on("click", function () {
        $("#basic-competence-form").attr("action", window.location.href);
        $("#basic-competence-form")[0].reset();
        $("#basic-competence-modal-title").html("Tambah Kompetensi Dasar Baru");
    });
}

async function editBtnAction() {
    $("#basic-competence-form").attr(
        "action",
        `${window.location.href}/${$(this).data("id")}/update`
    );
    const res = await fetch(`${window.location.href}/${$(this).data("id")}`);
    const data = await res.json();
    $("#name").val(data.data.name);
    $("#core-competence").val(data.data.core_competence_id);
    $("#semester").val(data.data.semester);
    $("#myModal").modal("show");
    $("#basic-competence-modal-title").html("Edit Kompetensi Dasar Baru");
}
