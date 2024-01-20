$(function () {
    $('.open-class').on('click', function () {
        let id = $(this).data('id');
        let url = `${$('meta[name="base-url"]').attr('content')}/teacher/${id}/class-open`;
        swal.fire({
            title: 'Buka Kelas',
            icon: 'question',
            text: 'Anda yakin ingin membuka kelas ini ?',
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya, Buka Kelas',
            cancelButtonText: 'No'
        }).then(res => {
            if (res.isConfirmed) {
                swal.fire({
                    title: 'Processing',
                    html: 'Loading...',
                    allowEscapekey: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        swal.showLoading()
                    }
                })
                fetch(url)
                    .then(fetchRes => fetchRes.json().then(data => ({
                        status: fetchRes.status,
                        response: data
                    })))
                    .then(res => {
                        console.log(res)
                        swal.close()

                        if (res.status == 200) {
                            showToast('success', res.response.message)
                            handleLocation()
                        } else {
                            showToast('waning', res.response.message)
                        }
                    })
            }
        })
    });

    var subjects = new Choices('#subjects')
    var classes = new Choices('#class')

    $('select[name="major_id"]').on('change', function(e){
        e.preventDefault()
        var val = $(this).val(),
            url = `${$('meta[name="base-url"]').attr('content')}/teacher/dashboard/${val}/getSubjects`
            
        subjects.clearChoices()
        subjects.setChoices(async () => {
            try {
                return fetchGetRequest(url)
            } catch(err){
                console.error(err)
            }
        })
    })

    $('select[name="major_id"]').on('change', function(e){
        e.preventDefault()
        var val = $(this).val(),
            url = `${$('meta[name="base-url"]').attr('content')}/teacher/dashboard/${val}/getClasses`

        classes.clearChoices()
        classes.setChoices(async () => {
            try {
                return fetchGetRequest(url)
            } catch(err){
                console.error(err)
            }
        })
    })

    if (typeof drEvent === 'undefined') {
        const drEvent = $('#input-file-now').dropify();

        drEvent.on('dropify.beforeClear', function (event, element) {
            return swal.fire({
                title: 'Question?',
                type: 'question',
                text: "Do you really want to delete \"" + element.file.name + "\" ?"
            })
        });

        drEvent.on('dropify.afterClear', function (event, element) {
            swal.fire({
                title: 'Success',
                type: 'success',
                text: 'File deleted'
            })
        });
    }
});
$(function () {
    $('.flatpickr').flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
    });
})

async function fetchGetRequest(url)
{
    const res = await fetch(url)
    return await res.json()
}