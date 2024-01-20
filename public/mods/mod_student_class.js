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
        name: 'degree',
        data: 'degree',
    },
    {
        name: 'major',
        data: 'major',
    },
    {
        name: 'name',
        data: 'name',
    },
    {
        name: 'studentCount',
        data: 'studentCount',
        mRender: function (data, type, row, meta) {
            let render = `<button type="button" class="btn btn-${data == 0 ? 'danger' : 'primary'} waves-effect btn-label waves-light show-student" data-id="${row.hashid}"><i class="bx bx-user label-icon"></i>${data} Siswa</button>`;
            return render;
        }
    },
    {
        name: 'hashid',
        data: 'hashid',
        sortable: false,
        searchable: false,
        width: "3%",
        sClass: "text-center",
        mRender: function (data) {
            var render = ``

            if (userPermissions.includes('create-student-classes')) {
                render += `
                    <button data-toggle="ajax" data-target="${window.location.href}/${data}/students" class="btn btn-sm btn-success waves-effect edit waves-light" ><i class="bx bx-plus"></i> Tambah Siswa</button>
                `
            }

            return render
        }
    }
], function () {
    $('.show-student').on('click', function () {
        let id = $(this).data('id');
        fetch(`${window.location.href}/${id}/get-student-class`)

            .then(res => res.json())
            .then(res => {
                if (res.status == 'success') {
                    let html = ``;
                    $('#studentClassModal').modal('show');
                    $('#studentClassModal .modal-title').html(`Siswa Kelas ${res.degree.degree} ${res.class.name}`);
                    if (res.data.length > 0) {
                        $('.student-content').removeClass('d-none');
                        $('.ilustration-content').addClass('d-none');
                        let i = 1;
                        res.data.forEach(student => {
                            console.log(student.name)
                            html += `
                                <tr>
                                <td>${i++}</td>
                                <td>${student.identity_number}</td>
                                <td>${student.name}</td>
                                <td>${student.email}</td>
                                <td>${student.phone_number}</td>
                                <td>${student.gender == 'male' ? 'Laki-Laki' : student.gender == 'female' ? 'Perempuan' : 'Lainnya'}</td>
                                <td>${student.status == true ? '<div class="badge badge-soft-success font-size-12">Aktif</div>' : '<div class="badge badge-soft-danger font-size-12">Tidak Aktif</div>'}</td>
                                </tr>`;
                        })
                        $('#studentClassModal table #student-body').html(html);
                    } else {
                        $('.student-content').addClass('d-none');
                        $('.ilustration-content').removeClass('d-none');
                    }


                } else {
                    toastr.error(res.message);
                }
            });
    })
});
