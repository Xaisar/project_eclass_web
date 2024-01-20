if (typeof typeDictionary == "undefined") {
    let typeDictionary = null;
}

if (typeof table == "undefined") {
    let table = null;
}

typeDictionary = {
    file: ["file", "image", "video", "audio"],
    link: ["youtube", "article"],
};

table = initDataTable(
    "#dataTable",
    [{
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
            name: "name",
            data: "name",
        },
        {
            name: "core_competence_name",
            data: "core_competence_name",
        },
        {
            name: "basic_competence_name",
            data: "basic_competence_name",
        },
        {
            name: "attachment",
            data: "attachment",
            mRender: function (data, r, row) {
                let link = "#";
                let icon = "";
                if (typeDictionary.file.includes(row.type)) {
                    // prettier-ignore
                    link = `${$("meta[name=base-url]").attr("content")}/storages/teaching-materials/${data}`;
                    switch (row.type) {
                        case "file":
                            icon = `<i class="bx bx-file-blank mr-2"></i>`;
                            break;
                        case "image":
                            icon = `<i class="bx bx-image-alt mr-2"></i>`;
                            break;
                        case "video":
                            icon = `<i class="bx bx-video mr-2"></i>`;
                            break;
                        case "audio":
                            icon = `<i class="bx bx-headphone mr-2"></i>`;
                            break;
                    }
                } else {
                    if (row.type == "youtube") {
                        icon = `<i class="bx bxl-youtube mr-2"></i>`;
                    } else {
                        icon = `<i class="bx bxs-book-content mr-2"></i>`;
                    }
                    link = data;
                }
                return data ?
                    `<a href="${link}" target="_blank">${icon} Buka File Lampiran</a>` :
                    "-";
            },
        },
        {
            name: "is_share",
            data: "is_share",
            mRender: (data) => {
                return data ? "Iya" : "Tidak";
            },
        },
        {
            name: "description",
            data: "description",
            mRender: function (data) {
                return data || "-";
            },
        },
        {
            name: "hashid",
            data: "hashid",
            sortable: false,
            searchable: false,
            mRender: function (data) {
                var render = ``;

                if (userPermissions.includes("update-teaching-materials")) {
                    render += `
                    <button class="btn btn-sm btn-primary waves-effect waves-light edit-btn" data-id="${data}"><i class="bx bx-edit-alt"></i></button>
                `;
                }

                if (userPermissions.includes("delete-teaching-materials")) {
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

async function editBtnAction() {
    const res = await fetch(
        `${window.location.href}/${$(this).data("id")}/show`
    );
    const {
        data
    } = await res.json();
    $("#type").val(data.teaching_material.type).trigger("change");
    $("#name").val(data.teaching_material.name);
    $("#core-competence").val(data.teaching_material.core_competence_id);
    $("#basic-competence").val(data.teaching_material.basic_competence_id);
    if (typeDictionary.link.includes(data.teaching_material.type)) {
        $("#attachment-link").val(data.teaching_material.attachment);
    }
    $("#description").html(data.teaching_material.description);
    $("#teaching-material-modal-title").html("Edit Bahan Ajar Baru");
    if (data.teaching_material.is_share == "1") {
        $("#share-material").prop("checked", true).trigger("change");
    } else {
        $("#share-material").prop("checked", false).trigger("change");
    }
    $("#teaching-material-form").attr(
        "action",
        `${window.location.href}/${$(this).data("id")}/update`
    );
    $("#myModal").modal("show");
}

$(".add-btn").on("click", function () {
    $("#teaching-material-modal-title").html("Tambah Bahan Ajar Baru");
    $("#teaching-material-form")[0].reset();
    $("#description").html("");
    $("#type").trigger("change");
    $("#teaching-material-form").attr("action", `${window.location.href}`);
});

$("#attachment-media").dropify();

$("#type").on("change", function () {
    if (typeDictionary.file.includes($(this).val())) {
        $(".attachment-media").removeClass("d-none");
        $(".attachment-link").addClass("d-none");
        $("#attachment-link").val("");
    } else {
        $(".attachment-media").addClass("d-none");
        $("#attachment-media").val("");
        $(".attachment-link").removeClass("d-none");
    }
});
