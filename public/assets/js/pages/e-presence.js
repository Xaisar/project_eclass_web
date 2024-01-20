$(async function () {
    updateDateTime();
    setInterval(() => {
        updateDateTime();
    }, 1000);
    setInterval(() => {
        refreshToken();
    }, 300000);
    requestForPresenceQr();
});

async function refreshToken() {
    const data = await $.ajax({
        url: `${$("meta[name=base-url]").attr(
            "content"
        )}/e-presence/refresh-presence-token`,
        method: "post",
        data: {
            _token: $("meta[name=csrf-token]").attr("content"),
            code: window.localStorage.getItem("code"),
        },
    });
    requestForPresenceQr();
}

async function requestForPresenceQr() {
    if (window.localStorage.getItem("code")) {
        try {
            const data = await $.ajax({
                url: `${$("meta[name=base-url]").attr(
                    "content"
                )}/e-presence/get-presence-qr`,
                method: "post",
                data: {
                    _token: $("meta[name=csrf-token]").attr("content"),
                    code: window.localStorage.getItem("code"),
                },
            });
            $(".container").html(`
                <div class="row mt-5">
                    <div class="col text-center">
                        <div class="card d-inline-block p-4 shadow">
                            <div class="card-body text-center">
                                <img src="data:image/png;base64,${data.qrs.a}"></img>
                                <h2 class="mt-5"><h2 class="mt-5">Absensi Kehadiran</h2></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col text-center">
                        <div class="card d-inline-block p-4 shadow">
                            <div class="card-body text-center">
                                <img src="data:image/png;base64,${data.qrs.b}"></img>
                                <h2 class="mt-5">Absensi Pulang</h2>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        } catch (err) {
            window.localStorage.removeItem("code");
            requestForPresenceQr();
            if (err.responseJSON) {
                alert(err.responseJSON.message);
            } else {
                console.log(err);
            }
        }
    } else {
        if ($(".presence-code-form").length <= 0) {
            $(".container").append(`
                <div class="card mt-5">
                    <div class="card-body">
                        <div class="form-group presence-code-form">
                            <label>Kode Masuk</label>
                            <input class="form-control presence-access-code" type="password"></input>
                        </div>
                        <button class="btn btn-primary mt-3 submit-code-btn">Submit</button>
                    </div>
                </div>
            `);
        }
        $(".submit-code-btn")
            .unbind()
            .on("click", function () {
                if ($(".presence-access-code").val()) {
                    window.localStorage.setItem(
                        "code",
                        $(".presence-access-code").val()
                    );
                    requestForPresenceQr();
                } else {
                    $(".presence-access-code").addClass("is-invalid");
                    $(".presence-code-form").append(`
                        <span class="text-danger invalid-feedback">Kode Masuk tidak boleh kosong</span>
                    `);
                }
            });
    }
}

function updateDateTime() {
    $(".date").html(moment().format("DD-MM-YYYY"));
    $(".time").html(moment().format("HH:mm:ss"));
}
