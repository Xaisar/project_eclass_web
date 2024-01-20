$(function () {
    $(".read-all-notifications").on("click", async function (e) {
        e.preventDefault();
        const res = await fetch($(this).attr("href"));
        const data = await res.json();
        $(".notification-icon")
            .removeClass("text-primary")
            .addClass("text-secondary");
        $(".unread-notifications-count").remove();
    });
});
