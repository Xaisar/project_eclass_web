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
            mRender: function(data, type, row){
                var render = `
                    <strong>${data}</strong><br>
                    <i class="text-muted small">${row.identity_number}</i>
                `
    
                return render
            }
        },
        {
            name: 'email',
            data: 'email'
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

                if(userPermissions.includes('update-student')){
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
            width: '150',
            sClass: 'text-center',
            sortable: false,
            mRender: function(data){
                var render = ``
                
                render += `<button class="btn btn-outline-info btn-sm mx-1" data-toggle="ajax" data-target="${$('meta[name="base-url"]').attr('content')}/administrator/student/${data}/detail"><i class="fa fa-eye"></i></button>` 
                if(userPermissions.includes('update-student')){
                    render += `<button class="btn btn-outline-primary btn-sm mx-1" data-toggle="edit" data-id="${data}"><i class="fa fa-edit"></i></button>` 
                }
    
                if(userPermissions.includes('delete-student')){
                    render += `<button class="btn btn-outline-danger btn-sm mx-1" data-toggle="delete" data-id="${data}"><i class="fa fa-trash"></i></button>` 
                }
    
                return render
            }
        }
    ])
}

async function updateStatus(id){
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

if(typeof drEvent === 'undefined'){
    let drEvent = null
}
    
drEvent = $('#input-file-now').dropify();