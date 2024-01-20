// registered serviceWorker
if ("serviceWorker" in navigator) {
    navigator.serviceWorker
        .register("/sw.js")
        .then((reg) => console.log("Service worker registered", reg))
        .catch((err) => console.log("Service worker not registered", err));
}

// main
const mainAct = () => {
    $('form[data-request="ajax"]').unbind().on("submit", submitForm);

    $('a[data-toggle="ajax"]')
        .unbind()
        .on("click", function (e) {
            e.preventDefault();
            pushState($(this).attr("href"));
        });

    $('button[data-toggle="ajax"]')
        .unbind()
        .on("click", function (e) {
            e.preventDefault();
            var target = $(this).data("target");
            pushState(target);
        });

    $('a[data-toggle="confirm"]')
        .unbind()
        .on("click", function (e) {
            e.preventDefault();
            var msg = $(this).data("message"),
                redirect = $(this).data("redirect"),
                url = $(this).attr("href");

            swal.fire({
                title: "Warning!",
                icon: "warning",
                text: msg,
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                // confirmButtonColor: '#de4035',
            }).then((res) => {
                if (res.isConfirmed) {
                    if (redirect) window.location.assign(url);
                    else pushState(url);
                }
            });
            confirmAct(this);
        });

    $('button[data-toggle="confirm"]')
        .unbind()
        .on("click", function (e) {
            e.preventDefault();
            confirmAct(this);
        });

    $('a[data-toggle="edit"]')
        .unbind()
        .on("click", function (e) {
            e.preventDefault();
            var id = $(this).data("id");
            url = `${window.location.href}/${id}/edit`;

            pushState(url);
        });

    $('button[data-toggle="edit"]')
        .unbind()
        .on("click", function (e) {
            e.preventDefault();
            var id = $(this).data("id");
            url = `${window.location.href}/${id}/edit`;

            pushState(url);
        });

    $('a[data-toggle="delete"]')
        .unbind()
        .on("click", function (e) {
            e.preventDefault();
            confirmDelete(this);
        });

    $('button[data-toggle="delete"]')
        .unbind()
        .on("click", function (e) {
            e.preventDefault();
            confirmDelete(this);
        });

    $("#checkAll").click(function () {
        if ($("#checkAll:checkbox:checked").length) {
            $(".bulk-delete:checkbox").prop("checked", true);
            $("#bulkDelete").removeClass("d-none");
        } else {
            $(".bulk-delete:checkbox").prop("checked", false);
            $("#bulkDelete").addClass("d-none");
        }
    });

    $(".bulk-delete").click(function () {
        if (
            $(".bulk-delete:checkbox:checked").length ==
            $(".bulk-delete:checkbox").length
        ) {
            $("#checkAll:checkbox").prop("checked", true);
            $("#bulkDelete").removeClass("d-none");
        } else {
            if ($(".bulk-delete:checkbox:checked").length > 0) {
                $("#checkAll:checkbox").prop("checked", false);
                $("#bulkDelete").removeClass("d-none");
            } else {
                $("#checkAll:checkbox").prop("checked", false);
                $("#bulkDelete").addClass("d-none");
            }
        }
    });

    $("#bulkDelete")
        .unbind()
        .on("click", function (e) {
            e.preventDefault();
            var formData = new FormData(),
                url = `${window.location.href}/multipleDelete`;

            $.each($(".bulk-delete:checkbox:checked"), (key, val) => {
                formData.append("hashid[]", $(val).val());
            });

            swal.fire({
                title: "Hapus Item ?",
                icon: "question",
                text: "Data yang dihapus tidak dapat dikembalikan",
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: "Yes, delete it",
                cancelButtonText: "No",
            }).then((res) => {
                if (res.isConfirmed) {
                    swal.fire({
                        title: "Processing",
                        html: "Loading...",
                        allowEscapekey: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            swal.showLoading();
                        },
                    });

                    fetch(url, {
                        method: "post",
                        headers: {
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        body: formData,
                    })
                        .then((fetchRes) =>
                            fetchRes.json().then((data) => ({
                                status: fetchRes.status,
                                response: data,
                            }))
                        )
                        .then((res) => {
                            swal.close();

                            if (res.status == 200) {
                                $("#checkAll:checkbox").prop("checked", false);
                                showToast("success", res.response.message);
                                if (tableDataTable == null) handleLocation();
                                else tableDataTable.ajax.reload();
                            } else {
                                showToast("warning", res.response.message);
                            }
                        });
                }
            });
        });

    $(".select2").select2();

    if ($(".js-choices").length) {
        $.each($(".js-choices"), (key, val) => {
            new Choices(val, {
                duplicateItemsAllowed: false,
                position: "bottom",
            });
        });
    }
};

const confirmDelete = (el) => {
    let id = $(el).data("id"),
        url =
            typeof $(el).data("url") != "undefined"
                ? $(el).data("url")
                : `${window.location.href}/${id}/delete`,
        callback = $(el).data("callback");

    swal.fire({
        title: "Hapus Item ?",
        icon: "question",
        text: "Data yang dihapus tidak dapat dikembalikan",
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonText: "Yes, delete it",
        cancelButtonText: "No",
    }).then((res) => {
        if (res.isConfirmed) {
            swal.fire({
                title: "Processing",
                html: "Please Wait...",
                allowEscapekey: false,
                allowOutsideClick: false,
                didOpen: () => {
                    swal.showLoading();
                },
            });

            fetch(url, {
                method: "delete",
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            })
                .then((fetchRes) =>
                    fetchRes.json().then((data) => ({
                        status: fetchRes.status,
                        response: data,
                    }))
                )
                .then((res) => {
                    swal.close();

                    if (res.status == 200) {
                        $(".modal").modal("hide");
                        $(".modal-backdrop").remove();
                        $("body").removeClass("modal-open");
                        showToast("success", res.response.message);

                        if (typeof callback != "undefined") {
                            pushState(callback);
                        }

                        if (tableDataTable == null) {
                            handleLocation();
                        } else {
                            tableDataTable.ajax.reload();
                        }
                    } else {
                        if (res.status == 422) {
                            showInvalid(res.response.errors);
                        } else if (res.status == 500) {
                            showToast("warning", res.response.message);
                        } else {
                            showToast("danger", "Opps! Terjadi kesalahan");
                        }
                    }
                });
        }
    });
};

const confirmAct = (el) => {
    var msg = $(el).data("message"),
        redirect = $(el).data("redirect"),
        url = $(el).attr("href");

    swal.fire({
        title: "Warning!",
        icon: "warning",
        text: msg,
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        confirmButtonColor: "#de4035",
    }).then((res) => {
        if (res.isConfirmed) {
            if (redirect) window.location.assign(url);
            else pushState(url);
        }
    });
};

/*
    function - function
    - route
    - pushState
    - handleLocation
    - submitForm
    - generateFormData
    - sendFormRequest
    - showToast
    - showInvalid
    - resetInvalid
*/
const route = (event) => {
    event = event || window.event;
    event.preventDefault();
    window.history.pushState({}, null, event.target.href);
    handleLocation();
};

const pushState = (url) => {
    if (url != window.location.href) window.history.pushState({}, null, url);
    handleLocation();
};

const handleLocation = () => {
    if ($("#qr-scanner__dashboard_section_csr span button").length)
        $("#qr-scanner__dashboard_section_csr span button").click();
    const route = window.location.href;
    Pace.start;

    swal.fire({
        title: "Processing",
        html: "Please Wait...",
        allowEscapekey: false,
        allowOutsideClick: false,
        didOpen: () => {
            swal.showLoading();
        },
    });

    fetch(route, {
        headers: {
            "X-Requested-With": "XMLHttpRequest",
        },
    })
        .then((fetchRes) =>
            fetchRes.text().then((data) => ({
                status: fetchRes.status,
                response: data,
            }))
        )
        .then((res) => {
            swal.close();
            if (res.status == 401) window.location.reload();
            else $("v-render").html(res.response);
            mainAct();
        });
};

const submitForm = async (e) => {
    e.preventDefault();
    resetInvalid();
    var oldHTMLButton = $('button[type="submit"').html();
    $('button[type="submit"]').html("Loading...").attr("disabled", "disabled");

    var opt = {
        action: $(e.target).attr("action"),
        method: $(e.target).attr("method"),
    };
    const data = await sendFormRequest(opt, new FormData(e.target));

    $('button[type="submit"]').html(oldHTMLButton).removeAttr("disabled");

    $('buttom[data-bs-dismiss="modal"]').click(function () {
        $("body").removeAttr("style");
    });

    if (data.status == 200) {
        if (
            typeof $(e.target).data("modal-close") == "undefined" ||
            $(e.target).data("modal-close")
        ) {
            $(".modal").modal("hide");
            $(".modal-backdrop").remove();
            $("body").removeClass("modal-open");
            $("body").removeAttr("style");
            $("form")[0].reset();
            $(".dropify-clear").click();
        }
        showToast("success", data.response.message);

        if ($(e.target).data("redirect")) {
            window.location.assign($(e.target).data("success-callback"));
        } else {
            let callback = $(e.target).data("success-callback");
            let reloadView = $(e.target).data("reload-view");

            if (typeof callback != "undefined") pushState(callback);

            if (typeof tableDataTable != "undefined")
                tableDataTable.ajax.reload();

            if (typeof reloadView != "undefined") handleLocation();
        }
    } else {
        if (data.status == 422) {
            showInvalid(data.response.errors);
        } else if (data.status == 500) {
            showToast("warning", data.response.message);
        } else {
            showToast("danger", "Opps! Terjadi kesalahan");
        }
    }
};

const generateFormBody = (form) => {
    const formData = new FormData();
    form.forEach((val, key) => {
        formData.append(key, val);
    });

    return formData;
};

const sendFormRequest = async (req, formData) => {
    const fetchRes = await fetch(req.action, {
        method: req.method,
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        body: generateFormBody(formData),
    });

    return {
        status: await fetchRes.status,
        response: await fetchRes.json(),
    };
};

const showToast = (type, msg) => {
    var el =
        type == "primary"
            ? "#toast-primary"
            : type == "success"
            ? "#toast-success"
            : type == "warning"
            ? "#toast-warning"
            : type == "danger"
            ? "#toast-danger"
            : null;

    $(".toast-body").html(msg);

    if (el != null) {
        new bootstrap.Toast(el).show();
    } else {
        console.error("toast type is not null");
    }
};

const showInvalid = (errorMessages) => {
    for (errorField in errorMessages) {
        if ($(`.js-choices[name="${errorField}`).length) {
            $(`.form-control[name="${errorField}"]`)
                .parent()
                .parent()
                .append(
                    `<div class="invalid-feedback d-block">${errorMessages[errorField]}</div>`
                );
            $(`.form-control[name="${errorField}"]`).addClass("is-invalid");
        } else {
            $(
                `<div class="invalid-feedback">${errorMessages[errorField][0]}</div>`
            ).insertAfter(`.form-control[name="${errorField}"]`);
            $(`.form-control[name="${errorField}"]`).addClass("is-invalid");
        }
    }
};

const resetInvalid = () => {
    for (const el of $(".form-control")) {
        $(el).removeClass("is-invalid");
        $(el).siblings(".invalid-feedback").remove();
        $(".invalid-feedback").remove();
    }
};

const initDataTable = (el, columns = [], drawCallback) => {
    let url = $(el).data("url");
    const table = $(el).DataTable({
        serverSide: true,
        processing: true,
        ajax: url,
        columns: columns,
        responsive: true,
        drawCallback,
    });

    table.on("responsive-display", () => {
        mainAct();
    });

    table.on("draw.dt", () => {
        mainAct();
    });
    window.tableDataTable = table;

    return table;
};

if ($("v-render").length) {
    window.onpopstate = handleLocation;
    window.route = route;

    handleLocation();
}

mainAct();

window.userPermissions = [];

if ($('meta[name="user-permissions"]').length) {
    window.userPermissions = $('meta[name="user-permissions"]')
        .attr("content")
        .split(",");
}
