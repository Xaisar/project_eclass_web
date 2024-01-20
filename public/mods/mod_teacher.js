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
        name: 'name',
        data: 'name',
        mRender: function (data, type, row) {
            return ` <div class="row">
                            <div class="col-md-2">
                                <img src="${$('meta[name="base-url"]').attr('content')}/assets/images/teachers/${row.picture}" alt="" class="avatar-sm rounded-circle me-2">
                            </div>
                            <div class="col-md-10">
                                <strong>${row.name}</strong><br>
                                <span class="small">${row.identity_number}</span>
                            </div>
                        </div>`
        }
    },
    {
        name: 'gender',
        data: 'gender',
        mRender: function (data, type, row) {
            let gender;
            if (data == 'male') {
                gender = 'Laki-Laki';
            } else if (data == 'female') {
                gender = 'Perempuan';
            } else {
                gender = 'Lainnya';
            }

            return gender;
        }
    },
    {
        name: 'phone_number',
        data: 'phone_number',
    },
    {
        name: 'email',
        data: 'email',
    },
    {
        name: 'year_of_entry',
        data: 'year_of_entry',
    },
    {
        name: 'last_education',
        data: 'last_education',
    },
    {
        name: 'position_name',
        data: 'position_name',
    },
    {
        name: 'status',
        data: 'status',
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

            if (userPermissions.includes('update-teacher')) {
                render += `
                        <button class="btn btn-sm btn-primary waves-effect waves-light" data-toggle="edit" data-id="${data}"><i class="bx bx-edit-alt"></i></button>
                        `
            }

            if (userPermissions.includes('read-teacher')) {
                render += `
                <button class="btn btn-sm btn-warning waves-effect detail waves-light" title="detail" data-toggle="ajax" data-target="${$('meta[name="base-url"]').attr('content')}/administrator/teacher/${data}/show"><i class="bx bxs-user-detail"></i></button>
            `
            }

            if (userPermissions.includes('delete-teacher')) {
                render += `
                <button class="btn btn-sm btn-danger waves-effect waves-light" title="hapus" data-toggle="delete" data-id="${data}"><i class="bx bx-trash"></i></button>
            `
            }

            return render
        }
    }
]);

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

$('.add').on('click', function () {
    resetInvalid();
    $('#myModal form').trigger('reset');
    $('#myModal .modal-title').html('Tambah Guru Baru');
    $('#myModal form').attr('action', `${window.location.href}/store`);
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
$(function () {
    $('.flatpickr').flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
    });
})
