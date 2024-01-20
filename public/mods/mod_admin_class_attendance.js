$(function () {
    $('#year').change(function () {
        let studyYear = $(this).val()
        let semester = $('#semester').val()
        let classGroup = $('#class_group').val()
        let course = $('#course').val()
        if (studyYear != '' && semester != '' && classGroup != '') {
            getCourse(classGroup, studyYear, semester)
            var excelUrl = course == '' ? `#` : `${window.location.href}/${classGroup}/${course}/${studyYear}/${semester}/print-excel`
            var pdfUrl = course == '' ? `#` : `${window.location.href}/${classGroup}/${course}/${studyYear}/${semester}/print-pdf`

            $('#printExcel').attr('href', excelUrl)
            $('#printPdf').attr('href', pdfUrl)
        }
    })

    $('#semester').change(function () {
        let semester = $(this).val()
        let studyYear = $('#year').val()
        let classGroup = $('#class_group').val()
        let course = $('#course').val()

        if (studyYear != '' && semester != '' && classGroup != '') {
            getCourse(classGroup, studyYear, semester)
            var excelUrl = course == '' ? `#` : `${window.location.href}/${classGroup}/${course}/${studyYear}/${semester}/print-excel`
            var pdfUrl = course == '' ? `#` : `${window.location.href}/${classGroup}/${course}/${studyYear}/${semester}/print-pdf`

            $('#printExcel').attr('href', excelUrl)
            $('#printPdf').attr('href', pdfUrl)
        }
    })

    $('#class_group').change(function () {
        let classGroup = $(this).val()
        let studyYear = $('#year').val()
        let semester = $('#semester').val()
        let course = $('#course').val()

        if (studyYear != '' && semester != '' && classGroup != '') {
            getCourse(classGroup, studyYear, semester)
            var excelUrl = course == '' ? `#` : `${window.location.href}/${classGroup}/${course}/${studyYear}/${semester}/print-excel`
            var pdfUrl = course == '' ? `#` : `${window.location.href}/${classGroup}/${course}/${studyYear}/${semester}/print-pdf`

            $('#printExcel').attr('href', excelUrl)
            $('#printPdf').attr('href', pdfUrl)
        }
    })
    $('#course').change(function () {
        let course = $(this).val()
        let studyYear = $('#year').val()
        let semester = $('#semester').val()
        let classGroup = $('#class_group').val()

        if (studyYear != '' && semester != '' && classGroup != '' && course != '') {
            loadView(classGroup, course, studyYear, semester)
            var excelUrl = `${window.location.href}/${classGroup}/${course}/${studyYear}/${semester}/print-excel`
            var pdfUrl = `${window.location.href}/${classGroup}/${course}/${studyYear}/${semester}/print-pdf`

            $('#printExcel').attr('href', excelUrl)
            $('#printPdf').attr('href', pdfUrl)
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

async function loadView(classGroup, course, studyYear, semester)
{
    swal.fire({
        title: "Processing",
        html: "Please Wait...",
        allowOutsideClick: false,
        didOpen: () => {
            swal.showLoading();
        },
    });

    var url = `${window.location.href}/${classGroup}/${course}/${studyYear}/${semester}/getData`
    const res = await fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })

    swal.close()
    if(await res.status == 200){
        var text = await res.text()
        $('.no-data').addClass('d-none')
        $('#viewData').removeClass('d-none')
        $('#viewData').html(text)
    } else {
        if(await res.status == 401){
            window.location.reload()
        } else {
            var response = await res.json()
            showToast('warning', response.message)
        }
    }
}