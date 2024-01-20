function renderDataTable() {
    initDataTable('#dataTable', [{
            name: 'hashid',
            data: 'hashid',
            width: '5%',
            sortable: false,
            searchable: false,
            mRender: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            },
        },
        {
            name: 'identity_number',
            data: 'identity_number',
        },
        {
            name: 'student_name',
            data: 'student_name'
        },
        {
            name: 'gender',
            data: 'gender',
        },
        {
            name: 'birthday',
            data: 'birthday',
        },
        {
            name: 'status',
            data: 'status',
            mRender: function (data, type, row) {
                return `<div class="badge badge-soft-${data == true ? 'success' : 'danger'} font-size-12">${data == true ? 'Aktif' : 'Tidak Aktif'}</div>`;
            }
        },
        {
            name: 'score',
            data: 'score',
        },
    ])
}
$(function () {
    $('#year').change(function () {
        let studyYear = $(this).val()
        let semester = $('#semester').val()
        let classGroup = $('#class_group').val()
        if (studyYear != '' && semester != '' && classGroup != '') {
            getCourse(classGroup, studyYear, semester)
        }
    })

    $('#semester').change(function () {
        let semester = $(this).val()
        let studyYear = $('#year').val()
        let classGroup = $('#class_group').val()

        if (studyYear != '' && semester != '' && classGroup != '') {
            getCourse(classGroup, studyYear, semester)
        }
    })

    $('#class_group').change(function () {
        let classGroup = $(this).val()
        let studyYear = $('#year').val()
        let semester = $('#semester').val()

        if (studyYear != '' && semester != '' && classGroup != '') {
            getCourse(classGroup, studyYear, semester)
        }
    })
    $('#course').change(function () {
        let course = $(this).val()
        let studyYear = $('#year').val()
        let semester = $('#semester').val()
        let classGroup = $('#class_group').val()

        if (studyYear != '' && semester != '' && classGroup != '' && course != '') {
            getSemesterAssesment(course, studyYear, semester)
        }
    })
})

function getCourse(classGroup, studyYear, semester) {
    fetch(`${window.location.href}/getCourse?periode=${studyYear}&semester=${semester}&classGroup=${classGroup}`)
        .then(res => res.json())
        .then(res => {
            let render = `<option value="">Pilih Pelajaran</option>`

            res.data.forEach(data => {
                render += `<option value="${data.hashid}">${data.subject.name}</option>`
            })

            $('#course').html(render)
        })
}

function getSemesterAssesment(course, studyYear, semester) {
    let url = `${window.location.href}/getData?periode=${studyYear}&semester=${semester}&course=${course}`;
    fetch(url)
        .then(res => res.json())
        .then(res => {
            if (res.data.length > 0) {
                $('.no-data').addClass('d-none');
                $('.data').removeClass('d-none');
                $('#dataTable').DataTable().destroy();
                $('#dataTable').data('url', url);
                renderDataTable();
            } else {
                $('.no-data').removeClass('d-none');
                $('.data').addClass('d-none');
            }
        })
}
$('.btn-export-excel').on('click', function () {
    let course = $('#course').val()
    let periode = $('#year').val()
    let semester = $('#semester').val()
    window.open(
        `${window.location.href}/export?type=excel&periode=${periode}&semester=${semester}&course=${course}`,
    );
})
$('.btn-export-pdf').on('click', function () {
    let course = $('#course').val()
    let periode = $('#year').val()
    let semester = $('#semester').val()
    window.open(
        `${window.location.href}/export?type=pdf&periode=${periode}&semester=${semester}&course=${course}`,
    );
})
