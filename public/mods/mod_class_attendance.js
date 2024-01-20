$(function(){
    $('#year').unbind().on('change', function(e){
        var year = $('#year').val(),
            numberOfMeeting = $('#number-of-meeting-attendance-recap').val(),
            filter = $('#filter').val()

        if(year != '' && numberOfMeeting != ''){
            var excelUrl = filter == '' ? `${window.location.href}/${year}/${numberOfMeeting}/print-excel` : `${window.location.href}/${year}/${numberOfMeeting}/${filter}/print-excel-by-name`
            var pdfUrl = filter == '' ? `${window.location.href}/${year}/${numberOfMeeting}/print-pdf` : `${window.location.href}/${year}/${numberOfMeeting}/${filter}/print-pdf-by-name`

            $('#printExcel').attr('href', excelUrl)
            $('#printPdf').attr('href', pdfUrl)
            loadView(year, numberOfMeeting)
        }
    })

    $('#number-of-meeting-attendance-recap').unbind().on('change', function(e){
        var year = $('#year').val(),
            numberOfMeeting = $('#number-of-meeting-attendance-recap').val(),
            filter = $('#filter').val()

        if(year != '' && numberOfMeeting != ''){
            var excelUrl = filter == '' ? `${window.location.href}/${year}/${numberOfMeeting}/print-excel` : `${window.location.href}/${year}/${numberOfMeeting}/${filter}/print-excel-by-name`
            var pdfUrl = filter == '' ? `${window.location.href}/${year}/${numberOfMeeting}/print-pdf` : `${window.location.href}/${year}/${numberOfMeeting}/${filter}/print-pdf-by-name`

            $('#printExcel').attr('href', excelUrl)
            $('#printPdf').attr('href', pdfUrl)
            loadView(year, numberOfMeeting)
        }
    })

    $('#filter').on('click keyup', function (e) { 
        var year = $('#year').val(),
            numberOfMeeting = $('#number-of-meeting-attendance-recap').val(),
            filter = $('#filter').val()
        
        if (year != '' && numberOfMeeting != '') {
            var excelUrl = filter != '' ? `${window.location.href}/${year}/${numberOfMeeting}/${filter}/print-excel-by-name` : `${window.location.href}/${year}/${numberOfMeeting}/print-excel`
            var pdfUrl = filter == '' ? `${window.location.href}/${year}/${numberOfMeeting}/print-pdf` : `${window.location.href}/${year}/${numberOfMeeting}/${filter}/print-pdf-by-name`

        
            $('#printExcel').attr('href', excelUrl)
            $('#printPdf').attr('href', pdfUrl)
            loadViewByName(year, numberOfMeeting, filter)
        }
    })

    $('#number-of-meeting').on('change', function (e) {
        let numberOfMeeting = $('#number-of-meeting').val()

        if (numberOfMeeting != '') {
            loadViewAttendance(numberOfMeeting)
        }
    })

})

function loadViewAttendance(numberOfMeeting)
{
    let url = encodeURI(`${window.location.href}/getDataAttendance?number_of_meeting=${numberOfMeeting}`);

    let dataTableResponse = $('#dataTable').DataTable().ajax.url(url).load();
    // let dtRes = await dataTableResponse.context[0].jqXHR.status
    // dataTableResponse.context[0].json.then(res => {
    //     console.log(res);

    // })
    // if (dataTableResponse.context[0].jqXHR.status == 200) {
        $('.no-data-attendance').addClass('d-none')
        $('#viewDataAttendance').removeClass('d-none')
    // } else {
    //     if(dataTableResponse.context[0].jqXHR.status == 401){
    //         window.location.reload()
    //     } else {
    //         var response = dataTableResponse.context[0].json
    //         showToast('warning', response.message)
    //     }
    // }
}

async function loadView(year, numberOfMeeting)
{
    swal.fire({
        title: "Processing",
        html: "Please Wait...",
        allowOutsideClick: false,
        didOpen: () => {
            swal.showLoading();
        },
    });

    var url = `${window.location.href}/${year}/${numberOfMeeting}/getData`
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

async function loadViewByName(year, numberOfMeeting, filter)
{
    var url = filter != '' ? `${window.location.href}/${year}/${numberOfMeeting}/${filter}/getDataByName` : `${window.location.href}/${year}/${numberOfMeeting}/getData`
    const res = await fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })

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

if (typeof table == "undefined") {
    let table = null;
}

table = initDataTable(
    $('#dataTable'),
    [
        {
            name: "hashid",
            data: "hashid",
            sortable: false,
            searchable: false,
            width: "4%",
            mRender: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1
            }
        },
        {
            name: "identity_number",
            data: "identity_number",
            sortable: true
        },
        {
            name: "name",
            data: "name"
        },
        {
            name: "gender",
            data: "gender",
            mRender: function (data, i, row) {
                return data == 'male' ? 'L' : 'P'
            }
        },
        {
            name: "number_of_meeting",
            data: "number_of_meeting"
        },
        {
            name: "attendance",
            data: "attendance",
            mRender: function (data, i, row) {
                let render = ``
                if (userPermissions.includes("create-class-attendance")) {
                    render = `
                    <select name="attendance" class="form-control attendance" id="attendance" data-attendance="${row.attendanceId != null ? row.attendanceId : null}" data-number-of-meeting="${row.number_of_meeting}" data-student-id="${row.hashid}">
                        <option value="" ${data[0] != undefined ? '' : 'selected'}>Pilih Presensi</option>
                        <option value="present" ${data[0] != undefined && data[0].status == 'present' ? 'selected' : ''}>Hadir</option>
                        <option value="permission" ${data[0] != undefined && data[0].status == 'permission' ? 'selected' : ''}>Izin</option>
                        <option value="sick" ${data[0] != undefined && data[0].status == 'sick' ? 'selected' : ''}>Sakit</option>
                        <option value="absent" ${data[0] != undefined && data[0].status == 'absent' ? 'selected' : ''}>Alpha</option>
                        <option value="late" ${data[0] != undefined && data[0].status == 'late' ? 'selected' : ''}>Terlambat</option>
                        <option value="forget" ${data[0] != undefined && data[0].status == 'forget' ? 'selected' : ''}>Lupa</option>
                        <option value="holiday" ${data[0] != undefined && data[0].status == 'holiday' ? 'selected' : ''}>Libur</option>
                    </select>
                    `
                }

                return render
            }
        }
    ],
    function () {
        if ($('.attendance').length > 0) {
            $('.attendance').unbind().on('change', function (e) {
                e.preventDefault()
                let data = {
                    status: $(this).val(), 
                    attendance_id: $(this).data('attendance'),
                    number_of_meeting: $(this).data('number-of-meeting'),
                    student_id: $(this).data('student-id')
                }

                postAttendance(data)
            })
        }
    }
)

table.on('responsive-display', function () {
    if ($('.attendance').length > 0) {
        $('.attendance').unbind().on('change', function (e) {
            e.preventDefault()
            let data = {
                status: $(this).val(), 
                attendance_id: $(this).data('attendance'),
                number_of_meeting: $(this).data('number-of-meeting'),
                student_id: $(this).data('student-id')
            }

            postAttendance(data)
        })
    }
})

async function postAttendance(data)
{
    swal.fire({
        title: "Processing",
        html: "Please Wait...",
        allowOutsideClick: false,
        didOpen: () => {
            swal.showLoading();
        },
    });

    var url = `${window.location.href}/attendance`
    const res = await fetch(url, {
        method: 'post',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })

    swal.close()
    if(await res.status == 200){
        var response = await res.json()
        let numberOfMeeting = $('#number-of-meeting').val()

        if (numberOfMeeting != '') {
            loadViewAttendance(numberOfMeeting)
        }
        showToast('success', response.message)
    } else {
        if(await res.status == 401){
            window.location.reload()
        } else {
            var response = await res.json()
            showToast('warning', response.message)
        }
    }

}