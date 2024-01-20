initDataTable('#dataTable', [{
        name: 'hashid',
        data: 'hashid',
        sortable: false,
        searchable: false,
        mRender: function (data, type, row) {
            return `
                <td>
                    <div class="form-check font-size-16">
                        <input type="checkbox" class="form-check-input bulk-delete" value="${data}">
                        <label class="form-check-label"></label> 
                    </div> 
                </td>`
        }
    },
    {
        name: 'chat_channel',
        data: 'chat_channel',
        mRender: function (data, type, row) {
            let chatChannel = ``;
            if (data != null) {
                chatChannel = `<strong>${data}</strong>`;
            } else {
                chatChannel = `-- No Chat Channel --`;
            }
            return chatChannel;
        }
    },
    {
        name: 'name',
        data: 'name',
        mRender: function (data, type, row) {
            return `
            <div class="row">
                <div class="col-md-2">
                    <img src="${$('meta[name="base-url"]').attr('content')}/assets/images/users/${row.picture}" alt="" class="avatar-sm rounded-circle me-2">
                </div>
                <div class="col-md-10">
                    <strong>${row.name}</strong><br>
                    <span class="small">${row.username}</span>
                </div>
            </div>`
        }
    },
    {
        name: 'email',
        data: 'email',
    },
    {
        name: 'role_name',
        data: 'role_name',
    },
    {
        name: 'is_online',
        data: 'is_online',
        mRender: function (data, type, row) {
            let render = ``;
            if (data == true) {
                render = `<div class="badge badge-soft-success font-size-12">Online</div>`
            } else {
                render = `<div class="badge badge-soft-danger font-size-12">Offline</div>`
            }
            return render;
        }
    },
    {
        name: 'is_active',
        data: 'is_active',
        mRender: function (data, type, row, meta) {
            let render = `<input type="checkbox" id="switch${meta.row + meta.settings._iDisplayStart + 1}"  onclick="updateStatus('${row.hashid}')" switch="none" ${data == true ? `checked` : ``} />
                            <label for="switch${meta.row + meta.settings._iDisplayStart + 1}" data-on-label="On" data-off-label="Off"></label>`;
            return render;
        }
    },
    {
        name: 'hashid',
        data: 'hashid',
        sortable: false,
        searchable: false,
        mRender: function (data) {
            var render = ``

            if (userPermissions.includes('update-users')) {
                render += `
                    <button class="btn btn-sm btn-primary waves-effect waves-light" data-toggle="edit" data-id="${data}"><i class="bx bx-edit-alt"></i></button>
                `
            }

            if (userPermissions.includes('delete-users')) {
                render += `
                    <button class="btn btn-sm btn-danger waves-effect waves-light" data-toggle="delete" data-id="${data}"><i class="bx bx-trash"></i></button>
                `
            }

            return render
        }
    }
])

function updateStatus(id) {
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

            if (res.status == 200) {
                if (tableDataTable == null) {
                    handleLocation()
                } else {
                    tableDataTable.ajax.reload()
                }
            } else {
                showToast('warning', res.response.message)
            }
        })
}

$('#role')
    .unbind()
    .on('change', function (e) {
        let val = $(this).val()

        if (val == 'Guru') {
            $('.form-teacher').removeClass('d-none')
            $('.form-student').addClass('d-none')
        } else if (val == 'Siswa') {
            $('.form-student').removeClass('d-none')
            $('.form-teacher').addClass('d-none')
        } else {
            $('.form-teacher').addClass('d-none')
            $('.form-student').addClass('d-none')
        }
    })


    if(typeof drEvent === 'undefined'){
        const drEvent = $('#input-file-now').dropify();
        
        drEvent.on('dropify.beforeClear', function(event, element){
            return swal.fire({
                title: 'Question?',
                type: 'question',
                text: "Do you really want to delete \"" + element.file.name + "\" ?"
            })
        });
        
        drEvent.on('dropify.afterClear', function(event, element){
            swal.fire({
                title: 'Success',
                type: 'success',
                text: 'File deleted'
            })
        });
    }