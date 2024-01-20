$(function () {
    $('.flatpickr').flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
    });
    $('.flatpickr-range').flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
        mode: 'range'
    });

    $('.btn-reset').click(function () {
        Swal.fire({
            title: 'Warning!',
            text: "Apakah anda yakin melakukan reset?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'rgb(222, 64, 53)',
            // cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            // reverseButtons: true
        }).then(async (result) => {
            if (result.isConfirmed) {
                const fetchRes = await fetch($(this).data('reset-url'), {
                    method: 'post',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                })
                const {status, response} = {
                    status: await fetchRes.status,
                    response: await fetchRes.json()
                }
                if (status == 200) {
                    $('.dropify-clear').click()
                    showToast('success', response.message)
            
                    if ($('form[data-request="ajax"]').data('redirect')) {
                        window.location.assign($('form[data-request="ajax"]').data('success-callback'))
                    } else {
                        let callback = $('form[data-request="ajax"]').data('success-callback')
                        if (typeof callback != 'undefined') pushState(callback)
                    }
                }
            }
        })
    })
})