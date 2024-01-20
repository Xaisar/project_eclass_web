$('.boolean-setting').on('click', function () {
    let id = $(this).data('id');
    var url = `${window.location.href}/${id}/updateStatus`

    swal.fire({
        title: 'Processing',
        html: 'Please Wait...',
        allowEscapekey: false,
        allowOutsideClick: false,
        didOpen: () => {
            swal.showLoading()
        }
    })

    fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(fetchRes => fetchRes.json().then(data => ({
            status: fetchRes.status,
            response: data
        })))
        .then(res => {
            swal.close()
            if (res.status != 200) {
                showToast('warning', res.response.message)
            }
        })
})
