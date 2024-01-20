if($('#dataTable').length){
    initDataTable('#dataTable', [
        {
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
            sClass: 'nowrap'
        },
        {
            name: 'start_entry',
            data: 'start_entry',
            sClass: 'nowrap'
        },
        {
            name: 'start_time_entry',
            data: 'start_time_entry',
            sClass: 'nowrap'
        },
        {
            name: 'last_time_entry',
            data: 'last_time_entry',
            sClass: 'nowrap'
        },
        {
            name: 'start_exit',
            data: 'start_exit',
            sClass: 'nowrap'
        },
        {
            name: 'start_time_exit',
            data: 'start_time_exit',
            sClass: 'nowrap'
        },
        {
            name: 'last_time_exit',
            data: 'last_time_exit',
            sClass: 'nowrap'
        },
        {
            name: 'status',
            data: 'status',
            mRender: function(data, type, row){
                var render = ``
    
                if(data == 1){
                    render += `<span class="badge badge-soft-success">Aktif</span>`
                } else {
                    render += `<span class="badge badge-soft-danger">Tidak Aktif</span>`
                }

                if(userPermissions.includes('update-shift')){
                    render += `
                        <i class="fa fa-pencil-alt p-2" onclick="updateStatus('${row.hashid}')"></i>
                    `
                }
    
                return render
            }
        },
        {
            name: 'hashid',
            data: 'hashid',
            width: '100',
            sClass: 'text-center',
            sortable: false,
            mRender: function(data){
                var render = ``
                
                if(userPermissions.includes('update-shift')){
                    render += `<button class="btn btn-outline-primary btn-sm mx-1" data-toggle="edit" data-id="${data}"><i class="fa fa-edit"></i></button>` 
                }
    
                if(userPermissions.includes('delete-shift')){
                    render += `<button class="btn btn-outline-danger btn-sm mx-1" data-toggle="delete" data-id="${data}"><i class="fa fa-trash"></i></button>` 
                }
    
                return render
            }
        }
    ])
}

function updateStatus(id){
    swal.fire({
        title: 'Update Status?',
        icon: 'question',
        text: 'Yakin ingin mengubah status?',
        showConfirmButton: true,
        showCancelButton: true,
    }).then(async (res) => {
        if(res.isConfirmed){
            swal.fire({
                title: 'Processing',
                html: 'Please Wait...',
                allowEscapekey: false,
                allowOutsideClick: false,
                didOpen: () => {
                    swal.showLoading()
                }
            })
        
            let res = await fetch(`${window.location.href}/${id}/updateStatus`)
        
            swal.close()
            if(await res.status == 200){
                tableDataTable.ajax.reload()
                var message = await res.json()
                showToast('success', message.message)
            } else {
                showToast('warning', 'Opps! terjadi kesalahan')
            }
        }
    })
}