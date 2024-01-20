$("#file-media").dropify();

if (typeof datepicker == "undefined") {
    let datepicker = null;
}

datepicker = flatpickr("#date", {
    defaultDate: new Date(),
    dateFormat: "d-m-Y",
});

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
            name: "date",
            data: "date",
        },
        {
            name: "file",
            data: "file",
            mRender(data, type, row) {
                link = `${$("meta[name=base-url]").attr(
                    "content"
                )}/storages/lesson-plans/${data}`;
                return `<a href="${link}" target="blank">Lihat File</a>`;
            },
        },
        {
            name: "hashid",
            data: "hashid",
            sortable: false,
            searchable: false,
            mRender: function (data) {
                var render = ``;

                if (userPermissions.includes("update-lesson-plan")) {
                    render += `
                    <button class="btn btn-sm btn-primary waves-effect waves-light edit-btn" data-id="${data}"><i class="bx bx-edit-alt"></i></button>
                `;
                }

                if (userPermissions.includes("delete-lesson-plan")) {
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

async function editBtnAction() {
    const res = await fetch(`${window.location.href}/${$(this).data("id")}`);
    const data = await res.json();
    datepicker.setDate(data.data.date, true, "Y-m-d");
    $("#lesson-plan-modal-title").html("Edit Kelas RPP");
    $("#lesson-plan-form").attr(
        "action",
        `${window.location.href}/${$(this).data("id")}`
    );
    $("#myModal").modal("show");
}

$(".add-btn").on("click", function () {
    $("#lesson-plan-modal-title").html("Tambah Kelas RPP");
    $("#lesson-plan-form").attr("action", `${window.location.href}`);
    datepicker.setDate(Date.now(), true);
});
