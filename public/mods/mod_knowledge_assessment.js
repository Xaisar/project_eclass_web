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
                name: 'number_of_meeting',
                data: 'number_of_meeting',
                sClass: 'nowrap-normal',
                mRender: function (data, type, row) {
                    return `Ke - ${data} - ${row.course.semester == 1 ? 'Semester Ganjil' : 'Semester Genap'}`
                }
            },
            {
                name: 'assignment_detail',
                data: 'assignment_detail',
                sortable: false,
                width: '60',
                sClass: 'nowrap text-center',
                mRender: function (data) {
                    var render = ``

                    $.each(data, (key, val) => {
                        render += `<p class="p-0 m-0">${val.basic_competence.core_competence.code}.${val.basic_competence.code}</p>`
                    })

                    return render
                }
            },
            {
                name: 'scheme',
                data: 'scheme',
                sClass: 'nowrap',
                mRender: function (data, type, row, meta) {
                    var render = ``,
                        scheme = ``

                    if (data == 'writing_test') {
                        scheme = 'Tes Tulis'
                    } else if (data == 'oral_test') {
                        scheme = 'Tes Lisan'
                    } else {
                        scheme = 'Tugas'
                    }

                    render = `
                        <span class="badge badge-soft-danger p-2">${scheme}</span>
                    `

                    return render
                }
            },
            {
                name: 'description',
                data: 'description',
                sClass: 'nowrap-normal'
            },
            {
                name: 'end_time',
                data: 'end_time',
                sClass: 'nowrap-normal',
                mRender: function (data, type, row) {
                    var render = ``

                    render += `
                        ${row.time}<br>
                        <span class="badge badge-soft-danger p-2"><strong><b>${row.sum_assessment}</b></strong>/${row.student_count} Siswa sudah mengerjakan.</span>
                    `

                    return render
                }
            },
            {
                name: 'id',
                data: 'hashid',
                sortable: false,
                width: '150px',
                sClass: 'text-center',
                mRender: function (data, type, row) {
                    var render = ``
                    if (userPermissions.includes('update-teacher-knowledge-assessment')) {
                        render += `<button class="btn btn-sm btn-success update-ratings" data-id="${data}"><i class="fa fa-pencil-alt"></i> Nilai</button> `
                    }

                    if (userPermissions.includes('update-teacher-knowledge-assessment')) {
                        render += `<button class="btn btn-sm btn-primary update-knowledge-assessment" data-id="${data}"><i class="fa fa-edit"></i></button> `
                    }

                    if (userPermissions.includes('delete-teacher-knowledge-assessment')) {
                        render += `<button class="btn btn-sm btn-danger" data-toggle="delete" data-id="${data}"><i class="fa fa-trash"></i></button> `
                    }

                    return render
                }
            }
        ],
        function () {
            $('.update-ratings').unbind().on('click', async function (e) {
                e.preventDefault()

                swal.fire({
                    title: 'Processing',
                    html: 'Loading...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        swal.showLoading()
                    }
                })

                var url = `${window.location.href}/${$(this).data('id')}/modal-rating`
                const res = await fetchModal(url)
                $('v-modal').html(res)
                swal.close()

                if ($('.js-choices').length) {
                    new Choices('.js-choices', {
                        duplicateItemsAllowed: false,
                        position: 'bottom',
                    })
                }

                $('#ratingTable').DataTable({
                    responsive: true,
                    paging: false
                })
                $('.delete-score').unbind().on('click', function (e) {
                    e.preventDefault()

                    swal.fire({
                        title: 'Delete?',
                        icon: 'question',
                        text: 'Data yang dihapus tidak dapat dikembalikan',
                        showConfirmButton: true,
                        showCancelButton: true,
                        confirmButtonText: 'Delete',
                        cancelButtonText: 'Batal'
                    }).then(async res => {
                        if (res.isConfirmed) {
                            swal.fire({
                                title: 'Processing',
                                html: 'Loading...',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    swal.showLoading()
                                }
                            })

                            var res = await deleteScore($(this).data('id'))

                            if (res.status == 200) {
                                // if ($(this).length) {
                                    
                                // }
                                $(`#status-${$(this).data('delete-id')}`).html(`<input type="hidden" class="form-control" name="is_finished[]" value="0">`)
                                $(`#remedial-${$(this).data('delete-id')}`).html(`<input type="hidden" class="form-control remedial" id="remedial" name="remedial[]" placeholder="Nilai remidi" autocomplete="off" max="100" min="0">`)
                                $(`#score-${$(this).data('delete-id')}`).val(``)
                                $(`#feedback-${$(this).data('delete-id')}`).html(``)
                                console.log($(this).data('delete-id'))
                                $(this).remove()
                                // $(`#status-${$(this).data('id')}`).remove()
                                
                                // if ($('.delete-score').length == 0) {
                                    // $('#tableContent').remove()
                                    if (tableDataTable == null) {
                                        handleLocation();
                                    } else {
                                        tableDataTable.ajax.reload();
                                    }
                                // }
                            } else {
                                showToast('warning', res.response.message)
                            }

                            swal.close()
                        }
                    })
                })
                $('.dropify').dropify()
                $('.modal').modal('dispose')
                $('.modal').modal('show')
                setTimeout(function () {
                    $('body').attr('style', 'overflow: hidden')
                }, 400)
                fileAct()
                mainAct()

                $('button[data-bs-dismiss="modal"]').click(function () {
                    setTimeout(function () {
                        $('body').removeAttr('style')
                    }, 400)
                })

                $('.score').on('keyup click', function (e) { 
                    onChangeScore($(this).data('score'))
                    // console.log($(this).data('score'))
                 })
            })

            $('.update-knowledge-assessment').unbind().on('click', async function (e) {
                e.preventDefault()

                swal.fire({
                    title: 'Processing',
                    html: 'Loading...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        swal.showLoading()
                    }
                })

                var url = `${window.location.href}/${$(this).data('id')}/modal-update`
                const res = await fetchModal(url)
                $('v-modal').html(res)
                swal.close()

                if ($('.js-choices').length) {
                    new Choices('.js-choices', {
                        duplicateItemsAllowed: false,
                        position: 'bottom',
                    })
                }

                $('.dropify').dropify()
                $('.modal').modal('dispose')
                $('.modal').modal('show')
                setTimeout(function () {
                    $('body').attr('style', 'padding-right: 21px')
                }, 400)
                fileAct()
                mainAct()

                $('button[data-bs-dismiss="modal"]').click(function () {
                    setTimeout(function () {
                        $('body').removeAttr('style')
                    }, 400)
                })

                $('.delete-instruksi').unbind().on('click', function (e) {
                    e.preventDefault()

                    swal.fire({
                        title: 'Delete?',
                        icon: 'question',
                        text: 'Data yang dihapus tidak dapat dikembalikan',
                        showConfirmButton: true,
                        showCancelButton: true,
                        confirmButtonText: 'Delete',
                        cancelButtonText: 'Batal'
                    }).then(async res => {
                        if (res.isConfirmed) {
                            swal.fire({
                                title: 'Processing',
                                html: 'Loading...',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    swal.showLoading()
                                }
                            })

                            var res = await deleteInstruksi($(this).data('id'))

                            if (res.status == 200) {
                                $(`#${$(this).data('id')}`).remove()

                                if ($('.delete-instruksi').length == 0) {
                                    $('#tableContent').remove()
                                }
                            } else {
                                showToast('warning', res.response.message)
                            }

                            swal.close()
                        }
                    })
                })
            })
        }
    )
}

modalAct()

function modalAct() {
    $('#create').unbind().on('click', async function (e) {
        e.preventDefault()

        swal.fire({
            title: 'Processing',
            html: 'Loading...',
            allowEscapekey: false,
            allowOutsideClick: false,
            didOpen: () => {
                swal.showLoading()
            }
        })

        var url = `${window.location.href}/modal-create`
        const res = await fetchModal(url)
        $('v-modal').html(res)
        swal.close()

        if ($('.js-choices').length) {
            new Choices('.js-choices', {
                duplicateItemsAllowed: false,
                position: 'bottom',
            })
        }

        $('button[data-bs-dismiss="modal"]').click(function () {
            setTimeout(function () {
                $('body').removeAttr('style')
            }, 400)
        })

        $('.dropify').dropify()
        $('.modal').modal('dispose')
        $('.modal').modal('show')
        fileAct()
        mainAct()
    })
}

async function fetchModal(url) {
    const res = await fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    return await res.text()
}

function fileAct() {
    $('.file-link').on('change', function (e) {
        e.preventDefault()
        var val = $($(this).data('id')).find('.file-link').val()

        if (val == 1) {
            $($(this).data('id')).find('.uploadFile').hide()
            $($(this).data('id')).find('.uploadFile').removeClass('d-none')
            $($(this).data('id')).find('.uploadFile').show('fade')
            $($(this).data('id')).find('.inputLink').hide('fade')
            $($(this).data('id')).find('.inputLink').addClass('d-none')
        } else if (val == 2) {
            $($(this).data('id')).find('.inputLink').hide()
            $($(this).data('id')).find('.inputLink').removeClass('d-none')
            $($(this).data('id')).find('.inputLink').show('fade')
            $($(this).data('id')).find('.uploadFile').hide('fade')
            $($(this).data('id')).find('.uploadFile').addClass('d-none')
        } else {
            $($(this).data('id')).find('.inputLink').hide('fade')
            $($(this).data('id')).find('.inputLink').addClass('d-none')
            $($(this).data('id')).find('.uploadFile').hide('fade')
            $($(this).data('id')).find('.uploadFile').addClass('d-none')
        }
    })

    flatpickr("#start_time", {
        defaultDate: new Date($('#start_time').val()),
        enableTime: true,
        dateFormat: 'Y-m-d H:i'
    })

    flatpickr("#end_time", {
        defaultDate: new Date($('#end_time').val()),
        enableTime: true,
        dateFormat: 'Y-m-d H:i'
    })

    $('#addForm').unbind().on('click', function () {
        $('#content').append(createElement())
        $('.dropify').dropify()
        fileAct()
        mainAct()

        $('.delete-el').unbind().on('click', function () {
            $($(this).data('id')).remove()
        })
    })
}

function createElement() {
    var randomId = Math.floor(Math.random() * 1000)
    var element = `
        <div class="element" id="ID${ randomId }">
            <hr>
            <div class="col-12 text-end mb-3">
                <button class="btn btn-danger btn-sm delete-el" type="button" data-id="#ID${ randomId }"><i class="fa fa-trash"></i> Hapus</button>
            </div>
            <div class="mb-3">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-12">
                            <label for="">Apa yang mau anda kirim ?</label>
                        </div>
                        <div class="col">
                            <select class="form-control file-link" name="attachment_type[]" data-id="#ID${ randomId }">
                                <option value="">Pilih jenis pengiriman</option>
                                <option value="1">Upload file instruksi berupa dokumen atau video</option>
                                <option value="2">Link instruksi berupa link eksternal</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3 d-none uploadFile">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-12">
                            <label for="">Upload File</label>
                        </div>
                        <div class="col">
                            <input type="file" name="file[]" id="input-file-now" class="dropify" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3 d-none inputLink">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-12">
                            <label for="">Masukkan Link</label>
                        </div>
                        <div class="col">
                            <input type="text" name="link[]" class="form-control" placeholder="Contoh : https://m.youtube.com" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `

    return element
}

async function deleteInstruksi(hashid) {
    const url = `${window.location.href}/${hashid}/delete-instruksi`
    const res = await fetch(url, {
        method: 'delete',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    })

    return {
        status: await res.status,
        response: await res.json()
    }
}

async function deleteScore(hashid) {
    const url = `${window.location.href}/${hashid}/delete-score`
    const res = await fetch(url, {
        method: 'delete',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    })

    return {
        status: await res.status,
        response: await res.json()
    }
}

function onChangeScore(e) {
    let score = $(`#score-${e}`).val()
    let grade = $(`#score-${e}`).data('grade')
    // console.log(typeof(score))
    if (score != '') {
        if (score >= grade) {
            $(`#status-${e}`).html(`
                <h5><span class="badge bg-success">Tuntas</span></h5>
                <input type="hidden" class="form-control" name="is_finished[]" value="1">
            `)
            $(`#remedial-${e}`).html(`<input type="hidden" class="form-control remedial" id="remedial" name="remedial[]" placeholder="Nilai remidi" autocomplete="off" max="100" min="0">`)
        } else {
            $(`#status-${e}`).html(`
                <h5><span class="badge bg-danger">Belum Tuntas</span></h5>
                <input type="hidden" class="form-control" name="is_finished[]" value="0">
            `)
            $(`#remedial-${e}`).html(`
                <input type="number" class="form-control remedial" id="remedial" name="remedial[]" placeholder="Nilai remidi" autocomplete="off" max="100" min="0">
            `)
        }
    } else {
        $(`#status-${e}`).html(`<input type="hidden" class="form-control" name="is_finished[]" value="0">`)
         $(`#remedial-${e}`).html(`<input type="hidden" class="form-control remedial" id="remedial" name="remedial[]" placeholder="Nilai remidi" autocomplete="off" max="100" min="0">`)
    }
}