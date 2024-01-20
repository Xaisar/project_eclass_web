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
    },
    {
        name: 'short_name',
        data: 'short_name',
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

            if (userPermissions.includes('update-majors')) {
                render += `
                    <button class="btn btn-sm btn-primary waves-effect edit waves-light" data-id="${data}"><i class="bx bx-edit-alt"></i></button>
                `
            }

            if (userPermissions.includes('delete-majors')) {
                render += `
                    <button class="btn btn-sm btn-danger waves-effect waves-light" data-toggle="delete" data-id="${data}"><i class="bx bx-trash"></i></button>
                `
            }

            return render
        }
    }
], function () {
    $('.edit').on('click', function () {
        resetInvalid();
        var id = $(this).data('id')
        $('#myModal .modal-title').html('Edit Jurusan');
        $('#myModal form').attr('action', `${window.location.href}/${id}/update`);
        //fetches data from the server
        fetch(`${window.location.href}/${id}/show`)
            .then(fetchRes => fetchRes.json().then(data => ({
                data: data,
                status: fetchRes.status
            })))
            .then(res => {
                if (res.status == 200) {
                    $('#myModal').modal('show')
                    $('#myModal').find('#name').val(res.data.data.name)
                    $('#myModal').find('#short_name').val(res.data.data.short_name)
                } else {
                    showToast('success', res.response.message)
                }
            }).catch(function (error) {
                console.log(error)
            })
    })
});

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
    $('#myModal .modal-title').html('Tambah Jurusan Baru');
    $('#myModal form').attr('action', `${window.location.href}/store`);
})
