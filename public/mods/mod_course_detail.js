initDataTable(
    "#dataTableRpp",
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
    ]
);


initDataTable('#dataTableStudentIncident', [{
        name: 'hashid',
        data: 'hashid',
        width: "1%",
        sClass: "text-center",
        mRender: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        },
    },
    {
        name: 'date',
        data: 'date',
    },
    {
        name: 'identity_number',
        data: 'identity_number',
    },
    {
        name: 'name',
        data: 'name',
    },
    {
        name: 'incident',
        data: 'incident',
    },
    {
        name: 'attitude_item',
        data: 'attitude_item',
        mRender: function (data, type, row) {
            let attitude = ``;
            switch (data) {
                case 'responsibility':
                    attitude = `Tanggung Jawab`;
                    break;
                case 'honest':
                    attitude = `Jujur`;
                    break;
                case 'mutual_cooperation':
                    attitude = `Gotong Royong`;
                    break;
                case 'self_confident':
                    attitude = `Percaya Diri`;
                    break;
                case 'discipline':
                    attitude = `Disiplin`;
                    break;
                default:
                    attitude = `-`;

            }
            return attitude;
        },
    },
    {
        name: 'attitude_value',
        data: 'attitude_value',
        mRender: function (data, type, row) {
            return `<div class="badge badge-soft-${data == 'positive' ? 'success' : 'warning'} font-size-12">${data == 'positive' ? 'Positif' : 'Negatif'}</div>`;
        }
    },
    {
        name: 'follow_up',
        data: 'follow_up',
    },
]);


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

initDataTable(
    "#dataTableTeachingMaterial",
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
    ]
);


initDataTable('#dataTableStudentList', [{
        name: 'hashid',
        data: 'hashid',
        width: "1%",
        sClass: "text-center",
        mRender: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        },
    },
    {
        name: 'picture',
        data: 'picture',
        width: '6%',
        mRender: function (data, type, row) {
            return ` <img src="${$('meta[name="base-url"]').attr('content')}/assets/images/students/${data}" alt="" class="avatar-md rounded-circle me-2">`;
        }
    },
    {
        name: 'identity_number',
        data: 'identity_number',
    },
    {
        name: 'name',
        data: 'name',
    },
    {
        name: 'gender',
        data: 'gender',
    },
    {
        name: 'birthday',
        data: 'birthday',
    },
    {
        name: 'class_group',
        data: 'class_group',
    },
    {
        name: 'status',
        data: 'status',
        mRender: function (data, type, row) {
            return `<div class="badge badge-soft-${data == true ? 'success' : 'danger'} font-size-12">${data == true ? 'Aktif' : 'Tidak Aktif'}</div>`;
        }
    },
]);
