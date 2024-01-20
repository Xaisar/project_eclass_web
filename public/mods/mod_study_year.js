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
        name: 'year',
        data: 'year',
        mRender: function (data, type, row) {
            return `${data} / ${data + 1}`;
        }
    },
    {
        name: 'semester',
        data: 'semester',
        mRender: function (data, type, row) {
            let odd = (data == 1) ?
                `<span class="text-success">
                    <strong> GANJIL</strong> 
                    <i class="mdi mdi-check-circle mr-1" style="font-size:16px;"></i>
                    </span>` :
                `<span class="text-muted semester" data-id="${row.hashid}" style="cursor:pointer;">
                    <strong> GANJIL</strong>
                </span>`
            let even = (data == 2) ?
                `<span class="text-success"> 
                    <strong> GENAP</strong>  
                    <i class="mdi mdi-check-circle mr-1" style="font-size:16px;"></i>
                </span>` :
                `<span class="text-muted semester" data-id="${row.hashid}" style="cursor:pointer;">
                    <strong> GENAP</strong>
                </span>`

            render = (row.status == true) ? odd + "  /  " + even : "-";
            return render;
        }
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

            if (userPermissions.includes('update-study-years')) {
                render += `
                    <button class="btn btn-sm btn-primary waves-effect edit waves-light" data-id="${data}"><i class="bx bx-edit-alt"></i></button>
                `
            }

            if (userPermissions.includes('delete-study-years')) {
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
        $('#myModal .modal-title').html('Edit Tahun Ajaran');
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
                    $('#myModal').find('#year').val(res.data.data.year)
                } else {
                    showToast('success', res.response.message)
                }
            }).catch(function (error) {
                console.log(error)
            })
    })

    $('.semester').on('click', function () {
        let id = $(this).data('id')
        var url = `${window.location.href}/${id}/updateSemester`
        swal.fire({
            title: 'Ubah Semester ?',
            icon: 'question',
            text: 'Perubahan semester akan mempengaruhi data yang lain',
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonText: 'Yes, Ubah',
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
        })
    });
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
                tableDataTable.ajax.reload()
            }
        })
}

$('.add').on('click', function () {
    resetInvalid();
    $('#myModal form').trigger('reset');
    $('#myModal .modal-title').html('Tambah Tahun Ajaran Baru');
    $('#myModal form').attr('action', `${window.location.href}/store`);
})
