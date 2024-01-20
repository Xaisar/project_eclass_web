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
        name: 'hashid',
        data: 'hashid',
        sortable: false,
        searchable: false,
        mRender: function (data) {
            var render = ``

            if (userPermissions.includes('update-position')) {
                render += `
                    <button class="btn btn-sm btn-primary waves-effect edit waves-light" data-id="${data}"><i class="bx bx-edit-alt"></i></button>
                `
            }

            if (userPermissions.includes('delete-position')) {
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
        $('#myModal .modal-title').html('Edit Jabatan');
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
                } else {
                    showToast('success', res.response.message)
                }
            }).catch(function (error) {
                console.log(error)
            })
    })
});



$('.add').on('click', function () {
    resetInvalid();
    $('#myModal form').trigger('reset');
    $('#myModal .modal-title').html('Tambah Jabatan Baru');
    $('#myModal form').attr('action', `${window.location.href}/store`);
})
