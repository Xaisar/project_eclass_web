if (typeof api == "undefined") {
    let api = null;
}

if ($("#meet").length > 0) {
    api = new JitsiMeetExternalAPI("meet.jit.si", {
        roomName: `${$("#room-name").val()}-${$("#meet-code").val()}`,
        parentNode: document.querySelector("#meet"),
        userInfo: {
            email: $("#email").val(),
            displayName: $("#name").val(),
        },
    });
}

$(".back-btn").on("click", function () {
    pushState($(this).data("href"));
});

$(".end-btn").on("click", async function () {
    const { isConfirmed } = await Swal.fire({
        title: "Akhiri Video Conference ?",
        text: "Setelah video conference di akhiri, anda tidak dapat lagi menggunakan room ini.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Akhiri",
    });
    if (isConfirmed) {
        // kickAllParticipants();
        api.executeCommand("hangup");
        const res = await fetch($("#end-meet-url").val(), {
            headers: {
                "X-CSRF-TOKEN": $("meta[name=csrf-token]").attr("content"),
            },
            method: "post",
        });
        const data = await res.json();
        if (data.status == "success") {
            showToast("success", data.message);
        } else {
            showToast("danger", "Gagal mengakhiri video conference !");
        }
        pushState($(".back-btn").data("href"));
    }
});

function kickAllParticipants() {
    const participants = api.getParticipantsInfo();
    // if (participants.length > 0) {
    //     for (const participant of participants) {
    //         if (
    //             api.getDisplayName(participant.participantId) !=
    //             $("#name").val()
    //         ) {
    //             api.executeCommand("kickParticipant", {
    //                 participantID: participant.participantId,
    //             });
    //         }
    //     }
    // }
}

$(".copy-link").on("click", function () {
    const inputEl = document.createElement("input");
    inputEl.value = `${$("meta[name=base-url]").attr(
        "content"
    )}/student/classroom/${$("#course-id").val()}/video-conference/${$(
        "#video-conference-id"
    ).val()}/conference-room`;
    inputEl.select();
    inputEl.setSelectionRange(0, 999999);
    navigator.clipboard.writeText(inputEl.value);
    showToast("success", "Berhasil menyalin link meet untuk siswa");
});
