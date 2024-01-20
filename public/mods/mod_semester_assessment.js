if ($('#dataTable').length) {
    initDataTable('#dataTable',
        [{
                name: "hashid",
                data: "hashid",
                sortable: false,
                searchable: false,
                width: "5%",
                mRender: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            {
                name: 'name',
                data: 'name',
                sClass: 'nowrap',
                mRender: function (data, type, row, meta) {
                    var render = ``

                    render = `
                        <strong>${data}</strong><br>
                        <i class="text-muted small">${row.identity_number}</i>
                    `

                    return render
                }
            },
            {
                name: 'birthdate',
                data: 'birthdate',
                sClass: 'nowrap',
                mRender: function (data, type, row) {
                    return row.ttl
                }
            },
            {
                name: 'gender',
                data: 'gender',
                sClass: 'nowrap',
                mRender: function (data) {
                    var render = ``

                    if (data == 'male') {
                        render += 'Laki - laki'
                    } else {
                        render += 'Perempuan'
                    }

                    return render
                }
            },
            {
                name: null,
                data: null,
                sClass: 'nowrap',
                mRender: function (data, type, row) {
                    return `<input type="number" class="form-control edit-nilai" placeholder="0" data-hashid="${row.hashid}" data-id="#${row.hashid}" value="${row.semester_assessment.length > 0 ? row.semester_assessment[0].score : ''}">`
                }
            },
            {
                name: null,
                data: null,
                sClass: 'nowrap',
                mRender: function (data, type, row) {
                    return `<span id="${row.hashid}">${row.semester_assessment.length > 0 ? row.semester_assessment[0].score : '0'}</span>`
                }
            }
        ],
        () => {
            var timeout
            $('#alert-unsaved').hide()
            $('#alert-saved').hide()
            $('#alert-unsaved').removeClass('d-none')
            $('#alert-saved').removeClass('d-none')

            $('.edit-nilai').keyup(function () {
                var target = $(this).data('id')
                $(target).html($(this).val() == '' ? 0 : $(this).val())
                $('#alert-unsaved').show('fade')
                $('#alert-saved').hide()

                clearTimeout(timeout)
                timeout = setTimeout(() => {
                    fetch(`${window.location.href}/store-or-update`, {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData()
                    }).then(res => {
                        $('#alert-unsaved').hide('fade')
                        if (res.status == 200) {
                            $('#alert-saved').show('fade')

                            setTimeout(() => {
                                $('#alert-saved').hide('fade')
                            }, 3000)
                        } else {
                            swal.fire({
                                title: 'Peringatan!',
                                icon: 'warning',
                                text: 'Opps! terjadi kesalahan saat menyimpan data'
                            })
                        }
                    })
                }, 5000)
            })
        }
    )
}

function formData() {
    var fd = new FormData()
    $.each($('.edit-nilai'), (key, val) => {
        fd.append('student_id[]', $(val).data('hashid'))
        fd.append('score[]', $(val).val())
    })

    return fd
}
