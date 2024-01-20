if (typeof datepicker == "undefined") {
    let datepicker = null;
}

datepicker = flatpickr("#start-time", {
    enableTime: !0,
    defaultDate: new Date(),
    dateFormat: "d-m-Y H:i",
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
            name: "name",
            data: "name",
        },
        {
            name: "code",
            data: "code",
        },
        {
            name: "meeting_number",
            data: "meeting_number",
        },
        {
            name: "members",
            data: "members",
            mRender(col, t, row) {
                return `<span>${col}</span> <a href="${window.location.href}/${row.hashid}/participants" class="detail-participants"><i class='bx bx-link-external'></i></a>`;
            },
        },
        {
            name: "start_time",
            data: "start_time",
        },
        {
            name: "end_time",
            data: "end_time",
        },
        {
            name: "hashid",
            data: "hashid",
            sortable: false,
            searchable: false,
            mRender: function (data, type, row) {
                var render = ``;

                if (
                    userPermissions.includes("join-video-conference") &&
                    row.end_time == "-"
                ) {
                    render += `
                    <a href="${window.location.href}/${data}/conference-room" data-toggle="ajax" class="ml-2 btn btn-sm btn-success waves-effect waves-light edit-btn" data-id="${data}"><i class="bx bx-play"></i></a>
                `;
                }

                if (
                    userPermissions.includes("update-video-conference") &&
                    row.end_time == "-"
                ) {
                    render += `
                    <button class="btn btn-sm btn-primary waves-effect waves-light edit-btn" data-id="${data}"><i class="bx bx-edit-alt"></i></button>
                `;
                }

                if (userPermissions.includes("delete-video-conference")) {
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

        $(".detail-participants").on("click", showParticipants);
    }
);

table.on("responsive-display", function () {
    if ($(".edit-btn").length > 0) {
        $(".edit-btn").on("click", editBtnAction);
    }

    $(".detail-participants").on("click", showParticipants);
});

async function showParticipants(e) {
    e.preventDefault();
    const res = await fetch($(this).attr("href"));
    const data = await res.json();
    $(".participants-list").empty();
    if (data.data.length > 0) {
        for (const d of data.data) {
            $(".participants-list").append(`
                <tr>
                    <td>${d.student.name}</td>
                    <td>${d.created_at_formatted}</td>
                </tr>
            `);
        }
    }
    $("#participants-detail").modal("show");
}

async function editBtnAction() {
    const resVideoConferenceData = await fetch(
        `${window.location.href}/${$(this).data("id")}`
    ).then((data) => data.json());

    let resMeetingNumberData = await fetch(
        `${window.location.href}/unattended-meets?current-number=${resVideoConferenceData.data.meeting_number}`
    ).then((data) => data.json());

    $("#name").val(resVideoConferenceData.data.name);
    $("#meeting-number").children("option.att-val").remove();
    $("#meeting-number").children().removeAttr("selected");

    $("#meeting-number").append(
        Object.keys(resMeetingNumberData.data)
            .map((key) => resMeetingNumberData.data[key])
            .map(
                (data) => `
        <option class="att-val" value="${data}" ${
                    data == resVideoConferenceData.data.meeting_number
                        ? "selected"
                        : ""
                }>${data}</option>
    `
            )
    );

    $("#video-conference-modal-title").html("Edit Video Conference");
    $("#video-conference-form").attr(
        "action",
        `${window.location.href}/${$(this).data("id")}`
    );
    $("#myModal").modal("show");
}

$(".add-btn").on("click", async function () {
    const meetRes = await fetch(
        `${window.location.href}/unattended-meets`
    ).then((data) => data.json());

    $("#meeting-number").children("option.att-val").remove();
    $("#meeting-number").children().removeAttr("selected");

    $("#meeting-number").append(
        Object.keys(meetRes.data)
            .map((key) => meetRes.data[key])
            .map(
                (data) => `
        <option class="att-val" value="${data}">${data}</option>
    `
            )
    );

    $("#video-conference-modal-title").html("Buat Video Conference");
    $("#video-conference-form").attr("action", `${window.location.href}`);
    $("#video-conference-form")[0].reset();
    datepicker.setDate(Date.now(), true);
});
