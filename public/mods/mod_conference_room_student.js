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

$(".refresh-btn").on("click", function () {
    pushState(window.location.href);
});
