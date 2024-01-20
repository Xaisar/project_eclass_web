$(function () {
    let to = null;

    let html5QrcodeScanner = new Html5QrcodeScanner("qr-scanner", {
        fps: 30,
        qrbox: { width: 300, height: 300 },
    });

    html5QrcodeScanner.render(onScanSuccess);

    function onScanSuccess(decodedText, decodedResult) {
        if (typeof to != null) {
            clearTimeout(to);
        }
        to = setTimeout(async () => {
            try {
                swal.fire({
                    title: "Processing",
                    html: "Loading...",
                    allowEscapekey: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        swal.showLoading();
                    },
                });
                const data = await $.ajax({
                    url: `${$("meta[name=base-url]").attr(
                        "content"
                    )}/student/presence`,
                    method: "post",
                    dataType: "json",
                    data: {
                        _token: $("meta[name=csrf-token]").attr("content"),
                        data: decodedText,
                    },
                });
                swal.close();
                pushState(
                    `${$("meta[name=base-url]").attr(
                        "content"
                    )}/student/dashboard`
                );
                showToast("success", data.message);
            } catch (err) {
                if (err.responseJSON) {
                    showToast("danger", err.responseJSON.message);
                } else {
                    console.error(err);
                    showToast("danger", "Kesalahan saat mengenali QR Code");
                }
            }
        }, 100);
    }
});
