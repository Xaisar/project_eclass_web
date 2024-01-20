$(function () {
    if (typeof drEvent === "undefined") {
        const drEvent = $("#input-file-now").dropify();

        drEvent.on("dropify.beforeClear", function (event, element) {
            return swal.fire({
                title: "Question?",
                type: "question",
                text:
                    'Do you really want to delete "' +
                    element.file.name +
                    '" ?',
            });
        });

        drEvent.on("dropify.afterClear", function (event, element) {
            swal.fire({
                title: "Success",
                type: "success",
                text: "File deleted",
            });
        });
    }
    $(".flatpickr").flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
    });
});
