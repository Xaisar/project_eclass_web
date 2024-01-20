if (typeof table == "undefined") {
    let table = null;
}

if (typeof table2 == "undefined") {
    let table2 = null;
}

// $(function () {
//     $('.input-file-now').dropify();

// $('.showFormUpload').unbind().on('click', function(e){
//     e.preventDefault()
//     console.log('oke')
//     $('#myModal').modal('show')
//     $('input[name="hashid"]').val($(this).data('id'))
//     $('#form').attr('action', $(this).data('url-upload'))
// })

// $('input[name="file_type"]').click(function(){
//     if($(this).val() == 'link'){
//         $('#formLink').removeClass('d-none')
//         $('#formFile').addClass('d-none')
//     } else {
//         $('#formLink').addClass('d-none')
//         $('#formFile').removeClass('d-none')
//     }
// })
// })

// $.each($('.dataTable'), function (i, e) {
//     // console.log($(e).attr('id'))
//     table = initDataTable(
//         $(e),
//         [
//             {
//                 name: "hashid",
//                 data: "hashid",
//                 sortable: false,
//                 searchable: false,
//                 width: "4%",
//                 mRender: function (data, type, row, meta) {
//                     return meta.row + meta.settings._iDisplayStart + 1;
//                 },
//             },
//             {
//                 name: "name",
//                 data: "name",
//             },
//             {
//                 name: "scheme",
//                 data: "scheme",
//                 mRender: function (data, i, row) {
//                     let render = ``;
//                     switch(data) {
//                         case "writing_test":
//                             render = `<span class="badge bg-danger">Tes Tulis</span> <span class="badge bg-success">PH-${row.day_assessment}</span>`
//                         break;
//                         case "oral_test":
//                             render = `<span class="badge bg-danger">Tes Lisan</span> <span class="badge bg-success">PH-${row.day_assessment}</span>`
//                         break;
//                         case "assignment":
//                             render = `<span class="badge bg-danger">Penugasan</span> <span class="badge bg-success">PH-${row.day_assessment}</span>`
//                         break;
//                         case "practice":
//                             render = `<span class="badge bg-danger">Praktek</span> <span class="badge bg-success">PH-${row.day_assessment}</span>`
//                         break;
//                         case "product":
//                             render = `<span class="badge bg-danger">Produk</span> <span class="badge bg-success">PH-${row.day_assessment}</span>`
//                         break;
//                     }

//                     return render;
//                 }
//             },
//             {
//                 name: "time",
//                 data: "time",
//             },
//             {
//                 name: "description",
//                 data: "description",
//                 mRender: function (data) {
//                     return data || "-";
//                 },
//             },
//             {
//                 name: "status",
//                 data: "status",
//                 mRender: function (data) {
//                     // console.log(data == "Sudah Dikerjakan")
//                     return data == "Sudah Dikerjakan" ? `<span class="badge bg-success">${data}</span>` : `<span class="badge bg-danger">${data}</span>`
//                 }
//             },
//             {
//                 name: "attachment",
//                 data: "attachment",
//                 sortable: false,
//                 searchable: false,
//                 mRender: function (data, i, row) {
//                     var render = ``;

//                     if (userPermissions.includes("create-student-dashboard-class-detail")) {
//                         render = data == "upload" ? `<button class="btn btn-sm btn-primary waves-effect waves-light showFormUpload" data-url-upload="${row.urlUpload}" data-id="${row.hashid}"><i class="fa fa-upload"></i></button>` : (data == 'download' ? `<a href="${row.urlDownloadAssignment}" target="_blank"><i class="fas fa-file-word text-primary"></i> FILE TUGAS</a>` : '');
//                     }

//                     return render;
//                 },
//             },
//         ],
//         function () {
//             if ($('.showFormUpload').length > 0) {
//                 $('.input-file-now').dropify();

//                 $('.showFormUpload').unbind().on('click', function(e){
//                     e.preventDefault()
//                     console.log('oke')
//                     $('#myModal').modal('show')
//                     $('input[name="hashid"]').val($(this).data('id'))
//                     $('#form').attr('action', $(this).data('url-upload'))
//                 })

//                 $('input[name="file_type"]').click(function(){
//                     if($(this).val() == 'link'){
//                         $('#formLink').removeClass('d-none')
//                         $('#formFile').addClass('d-none')
//                     } else {
//                         $('#formLink').addClass('d-none')
//                         $('#formFile').removeClass('d-none')
//                     }
//                 })
//             }
//         }
//     );
// })

table = initDataTable(
    $("#dataTable-assignment-knowledge"),
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
            // sortable: false,
            // searchable: false,
        },
        {
            name: "scheme",
            data: "scheme",
            mRender: function (data, i, row) {
                let render = ``;
                switch (data) {
                    case "writing_test":
                        render = `<span class="badge bg-danger">Tes Tulis</span> <span class="badge bg-success">PH-${row.day_assessment}</span>`;
                        break;
                    case "oral_test":
                        render = `<span class="badge bg-danger">Tes Lisan</span> <span class="badge bg-success">PH-${row.day_assessment}</span>`;
                        break;
                    case "assignment":
                        render = `<span class="badge bg-danger">Penugasan</span> <span class="badge bg-success">PH-${row.day_assessment}</span>`;
                        break;
                    case "practice":
                        render = `<span class="badge bg-danger">Praktek</span> <span class="badge bg-success">PH-${row.day_assessment}</span>`;
                        break;
                    case "product":
                        render = `<span class="badge bg-danger">Produk</span> <span class="badge bg-success">PH-${row.day_assessment}</span>`;
                        break;
                }

                return render;
            },
        },
        {
            name: "time",
            data: "time",
        },
        {
            name: "description",
            data: "description",
            mRender: function (data) {
                return data || "-";
            },
        },
        {
            name: "status",
            data: "status",
            mRender: function (data) {
                // console.log(data == "Sudah Dikerjakan")
                return data == "Sudah Dikerjakan" ?
                    `<span class="badge bg-success">${data}</span>` :
                    `<span class="badge bg-danger">${data}</span>`;
            },
        },
        {
            name: "attachment",
            data: "attachment",
            sortable: false,
            searchable: false,
            mRender: function (data, i, row) {
                var render = ``, ext = ``;

                if (
                    userPermissions.includes(
                        "create-student-dashboard-class-detail"
                    )
                ) {
                    // render =
                    //     data == "upload" ?
                    //     `<button class="btn btn-sm btn-primary waves-effect waves-light showFormUpload" data-url-upload="${row.urlUpload}" data-id="${row.hashid}"><i class="fa fa-upload"></i></button>` :
                    //     data == "download" ?
                    //     `<a href="${row.urlDownloadAssignment}" target="_blank"><i class="fas fa-file-word text-primary"></i> FILE TUGAS</a>` :
                    //     "";
                    if (row.ext) {
                        if (row.ext == 'pdf') {
                            ext = `
                                <i class="fas fa-file-pdf text-danger"></i>
                                FILE TUGAS
                            `
                        } else if(row.ext == 'doc' || row.ext == 'docx' || row.ext == 'docs') {
                            ext = `
                            <i class="fas fa-file-word text-primary"></i>
                            FILE TUGAS
                            `
                        } else if (row.ext == 'ppt' || row.ext == 'pptx') {
                            ext = `
                            <i class="fas fa-file-ppt text-danger"></i>
                            FILE TUGAS
                            `
                        } else if (row.ext == 'xls' || row.ext == 'xlsx') {
                            ext = `
                                <i class="fas fa-file-excel text-success"></i>
                                FILE TUGAS
                            `
                        } else if (row.ext == 'jpg' || row.ext == 'jpeg' || row.ext == 'png') {
                            ext = `
                            <i class="fas fa-file-image text-secondary"></i>
                            FILE TUGAS
                            `
                        } else {
                            ext = `
                            <i class="fas fa-file-alt text-secondaru"></i>
                            FILE TUGAS
                            `
                        }
                    }

                    if (data == 'download') {
                        if (row.knowledge_assessment && row.knowledge_assessment[0].attachment_type == 'link') {
                            render = `
                            <a href="${row.urlDownloadAssignment}" target="_blank" rel="noopener noreferrer">
                            <i class="fa fa-external-link-alt"></i>
                                Lihat Tugas
                            </a>
                            <hr>
                            `
                        } else {
                            render = `
                            <a href="${row.urlDownloadAssignment}"
                            target="_blank"
                            style="margin-right: 10px;white-space: nowrap">
                                ${ext}
                            </a>
                            `
                        }
                        if (row.editAssignment) {
                            render += `
                            <button class="btn btn-sm btn-primary waves-effect waves-light showFormUpload" data-url-upload="${row.urlUpload}" data-id="${row.hashid}"><i class="fa fa-edit"></i></button>
                            `
                        }
                    } else if (data == 'upload') {
                        render = `
                        <button class="btn btn-sm btn-primary waves-effect waves-light showFormUpload" data-url-upload="${row.urlUpload}" data-id="${row.hashid}"><i class="fa fa-upload"></i></button>
                        `
                    } else {
                        render = ``
                    }

                    // return render
                }

                return render;
            },
        },
    ],
    function () {
        if ($(".showFormUpload").length > 0) {
            $(".input-file-now").dropify();

            $(".showFormUpload")
                .unbind()
                .on("click", function (e) {
                    e.preventDefault();
                    console.log("oke");
                    $("#myModal").modal("show");
                    $('input[name="hashid"]').val($(this).data("id"));
                    $("#form").attr("action", $(this).data("url-upload"));
                });

            $('input[name="file_type"]').click(function () {
                if ($(this).val() == "link") {
                    $("#formLink").removeClass("d-none");
                    $("#formFile").addClass("d-none");
                } else {
                    $("#formLink").addClass("d-none");
                    $("#formFile").removeClass("d-none");
                }
            });
        }
    }
);

table2 = initDataTable(
    $("#dataTable-assignment-skill"),
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
            // sortable: false,
        },
        {
            name: "scheme",
            data: "scheme",
            mRender: function (data, i, row) {
                let render = ``;
                switch (data) {
                    case "writing_test":
                        render = `<span class="badge bg-danger">Tes Tulis</span>`;
                        break;
                    case "oral_test":
                        render = `<span class="badge bg-danger">Tes Lisan</span>`;
                        break;
                    case "assignment":
                        render = `<span class="badge bg-danger">Penugasan</span>`;
                        break;
                    case "practice":
                        render = `<span class="badge bg-danger">Praktek</span>`;
                        break;
                    case "product":
                        render = `<span class="badge bg-danger">Produk</span>`;
                        break;
                }

                return render;
            },
        },
        {
            name: "time",
            data: "time",
        },
        {
            name: "description",
            data: "description",
            mRender: function (data) {
                return data || "-";
            },
        },
        {
            name: "status",
            data: "status",
            mRender: function (data) {
                // console.log(data == "Sudah Dikerjakan")
                return data == "Sudah Dikerjakan" ?
                    `<span class="badge bg-success">${data}</span>` :
                    `<span class="badge bg-danger">${data}</span>`;
            },
        },
        {
            name: "attachment",
            data: "attachment",
            sortable: false,
            searchable: false,
            mRender: function (data, i, row) {
                var render = ``;

                if (
                    userPermissions.includes(
                        "create-student-dashboard-class-detail"
                    )
                ) {
                    // render =
                    //     data == "upload" ?
                    //     `<button class="btn btn-sm btn-primary waves-effect waves-light showFormUpload" data-url-upload="${row.urlUpload}" data-id="${row.hashid}"><i class="fa fa-upload"></i></button>` :
                    //     data == "download" ?
                    //     `<a href="${row.urlDownloadAssignment}" target="_blank"><i class="fas fa-file-word text-primary"></i> FILE TUGAS</a>` :
                    //     "";
                    if (row.ext) {
                        if (row.ext == 'pdf') {
                            ext = `
                                <i class="fas fa-file-pdf text-danger"></i>
                                FILE TUGAS
                            `
                        } else if(row.ext == 'doc' || row.ext == 'docx' || row.ext == 'docs') {
                            ext = `
                            <i class="fas fa-file-word text-primary"></i>
                            FILE TUGAS
                            `
                        } else if (row.ext == 'ppt' || row.ext == 'pptx') {
                            ext = `
                            <i class="fas fa-file-ppt text-danger"></i>
                            FILE TUGAS
                            `
                        } else if (row.ext == 'xls' || row.ext == 'xlsx') {
                            ext = `
                                <i class="fas fa-file-excel text-success"></i>
                                FILE TUGAS
                            `
                        } else if (row.ext == 'jpg' || row.ext == 'jpeg' || row.ext == 'png') {
                            ext = `
                            <i class="fas fa-file-image text-secondary"></i>
                            FILE TUGAS
                            `
                        } else {
                            ext = `
                            <i class="fas fa-file-alt text-secondaru"></i>
                            FILE TUGAS
                            `
                        }
                    }

                    if (data == 'download') {
                        if (row.knowledge_assessment && row.knowledge_assessment[0].attachment_type == 'link') {
                            render = `
                            <a href="${row.urlDownloadAssignment}" target="_blank" rel="noopener noreferrer">
                            <i class="fa fa-external-link-alt"></i>
                                Lihat Tugas
                            </a>
                            <hr>
                            `
                        } else {
                            render = `
                            <a href="${row.urlDownloadAssignment}"
                            target="_blank"
                            style="margin-right: 10px;white-space: nowrap">
                                ${ext}
                            </a>
                            `
                        }
                        if (row.editAssignment) {
                            render += `
                            <button class="btn btn-sm btn-primary waves-effect waves-light showFormUpload" data-url-upload="${row.urlUpload}" data-id="${row.hashid}"><i class="fa fa-edit"></i></button>
                            `
                        }
                    } else if (data == 'upload') {
                        render = `
                        <button class="btn btn-sm btn-primary waves-effect waves-light showFormUpload" data-url-upload="${row.urlUpload}" data-id="${row.hashid}"><i class="fa fa-upload"></i></button>
                        `
                    } else {
                        render = ``
                    }
                }

                return render;
            },
        },
    ],
    function () {
        if ($(".showFormUpload").length > 0) {
            $(".input-file-now").dropify();

            $(".showFormUpload")
                .unbind()
                .on("click", function (e) {
                    e.preventDefault();
                    console.log("oke");
                    $("#myModal").modal("show");
                    $('input[name="hashid"]').val($(this).data("id"));
                    $("#form").attr("action", $(this).data("url-upload"));
                });

            $('input[name="file_type"]').click(function () {
                if ($(this).val() == "link") {
                    $("#formLink").removeClass("d-none");
                    $("#formFile").addClass("d-none");
                } else {
                    $("#formLink").addClass("d-none");
                    $("#formFile").removeClass("d-none");
                }
            });
        }
    }
);

table.on("responsive-display", function () {
    if ($(".showFormUpload").length > 0) {
        $(".input-file-now").dropify();

        $(".showFormUpload")
            .unbind()
            .on("click", function (e) {
                e.preventDefault();
                console.log("oke");
                $("#myModal").modal("show");
                $('input[name="hashid"]').val($(this).data("id"));
                $("#form").attr("action", $(this).data("url-upload"));
            });

        $('input[name="file_type"]').click(function () {
            if ($(this).val() == "link") {
                $("#formLink").removeClass("d-none");
                $("#formFile").addClass("d-none");
            } else {
                $("#formLink").addClass("d-none");
                $("#formFile").removeClass("d-none");
            }
        });
    }
});

$("#meeting-presence-form").on("submit", async function (e) {
    try {
        e.preventDefault();
        const fd = new FormData($("#meeting-presence-form")[0]);
        await $.ajax({
            url: `${$(this).attr("action")}`,
            data: fd,
            processData: false,
            contentType: false,
            method: "post",
        });
        $("#meeting-presence-modal").modal("hide");
        pushState(window.location.href);
        showToast("success", "Berhasil presensi");
    } catch (err) {
        if (err.status == 422) {
            for (const errKey in err.responseJSON.errors) {
                $(`select[name=${errKey}]`).addClass("is-invalid");
                $(
                    `<span class="invalid-feedback">${err.responseJSON.errors[errKey][0]}</span>`
                ).insertAfter($(`select[name=${errKey}]`));
            }
        } else {
            console.log(err.status);
        }
    }
});

// $(function () {
//     $('.input-file-now').dropify();

//     $('.showFormUpload').unbind().on('click', function(e){
//         e.preventDefault()
//         $('#myModal').modal('show')
//         $('input[name="hashid"]').val($(this).data('id'))
//         $('#form').attr('action', $(this).data('url-upload'))
//     })

//     $('input[name="file_type"]').click(function(){
//         if($(this).val() == 'link'){
//             $('#formLink').removeClass('d-none')
//             $('#formFile').addClass('d-none')
//         } else {
//             $('#formLink').addClass('d-none')
//             $('#formFile').removeClass('d-none')
//         }
//     })
// })
