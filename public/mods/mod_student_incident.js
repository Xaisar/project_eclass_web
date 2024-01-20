initDataTable('#dataTable', [{
            name: 'hashid',
            data: 'hashid',
            width: "1%",
            sClass: "text-center",
            mRender: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            },
        },
        {
            name: 'date',
            data: 'date',
        },
        {
            name: 'identity_number',
            data: 'identity_number',
        },
        {
            name: 'name',
            data: 'name',
        },
        {
            name: 'incident',
            data: 'incident',
        },
        {
            name: 'attitude_item',
            data: 'attitude_item',
            mRender: function (data, type, row) {
                let attitude = ``;
                switch (data) {
                    case 'responsibility':
                        attitude = `Tanggung Jawab`;
                        break;
                    case 'honest':
                        attitude = `Jujur`;
                        break;
                    case 'mutual_cooperation':
                        attitude = `Gotong Royong`;
                        break;
                    case 'self_confident':
                        attitude = `Percaya Diri`;
                        break;
                    case 'discipline':
                        attitude = `Disiplin`;
                        break;
                    default:
                        attitude = `-`;

                }
                return attitude;
            },
        },
        {
            name: 'attitude_value',
            data: 'attitude_value',
            mRender: function (data, type, row) {
                return `<div class="badge badge-soft-${data == 'positive' ? 'success' : 'warning'} font-size-12">${data == 'positive' ? 'Positif' : 'Negatif'}</div>`;
            }
        },
        {
            name: 'follow_up',
            data: 'follow_up',
        },
        {
            name: 'hashid',
            data: 'hashid',
            sortable: false,
            searchable: false,
            mRender: function (data) {
                var render = ``
                if (userPermissions.includes('update-student-incident')) {
                    render += `<button class="btn btn-sm btn-primary waves-effect edit waves-light mx-1" data-id="${data}"><i class="bx bx-edit-alt"></i></button>`
                }
                if (userPermissions.includes('delete-student-incident')) {
                    render += `<button class="btn btn-sm btn-danger waves-effect waves-light mx-1" data-toggle="delete" data-id="${data}"><i class="bx bx-trash"></i></button>`
                }
                return render
            }
        }
    ],
    function () {
        $('.edit').on('click', function () {
            resetInvalid();
            var id = $(this).data('id')
            $('#myModal .modal-title').html('Edit Jurnal Siswa');
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
                        $('#myModal').find('#date').val(res.data.data.date)
                        $('#myModal').find('#student').val(res.data.student_id)
                        $('#myModal').find('#incident').val(res.data.data.incident)
                        $('#myModal').find('#attitude_item').val(res.data.data.attitude_item)
                        $('#myModal').find('#attitude_value').val(res.data.data.attitude_value)
                        $('#myModal').find('#follow_up').val(res.data.data.follow_up)
                    } else {
                        showToast('success', res.response.message)
                    }
                }).catch(function (error) {
                    console.log(error)
                })
        })
    });
$(function () {
    $('.flatpickr').flatpickr();
})
$('.add').on('click', function () {
    resetInvalid();
    $('#myModal form').trigger('reset');
    $('#myModal .modal-title').html('Tambah Jurnal Siswa');
    $('#myModal form').attr('action', `${window.location.href}`);
})
