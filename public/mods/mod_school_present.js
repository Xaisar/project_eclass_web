$(function(){
    $('#year').unbind().on('change', function(e){
        var year = $('#year').val(),
            month = $('#month').val(),
            classGroup = $('#class_group').val()

        if(year != '' && month != '' && classGroup != ''){
            var excelUrl = `${window.location.href}/${year}/${month}/${classGroup}/print-excel`,
                pdfUrl = `${window.location.href}/${year}/${month}/${classGroup}/print-pdf`

            $('#printExcel').attr('href', excelUrl)
            $('#printPdf').attr('href', pdfUrl)
            loadView(year, month, classGroup)
        }
    })

    $('#month').unbind().on('change', function(e){
        var year = $('#year').val(),
            month = $('#month').val(),
            classGroup = $('#class_group').val()

        if(year != '' && month != '' && classGroup != ''){
            var excelUrl = `${window.location.href}/${year}/${month}/${classGroup}/print-excel`,
                pdfUrl = `${window.location.href}/${year}/${month}/${classGroup}/print-pdf`

            $('#printExcel').attr('href', excelUrl)
            $('#printPdf').attr('href', pdfUrl)
            loadView(year, month, classGroup)
        }
    })

    $('#class_group').unbind().on('change', function(e){
        var year = $('#year').val(),
            month = $('#month').val(),
            classGroup = $('#class_group').val()

        if(year != '' && month != '' && classGroup != ''){
            var excelUrl = `${window.location.href}/${year}/${month}/${classGroup}/print-excel`,
                pdfUrl = `${window.location.href}/${year}/${month}/${classGroup}/print-pdf`

            $('#printExcel').attr('href', excelUrl)
            $('#printPdf').attr('href', pdfUrl)
            loadView(year, month, classGroup)
        }
    })
})

async function loadView(year, month, classGroup)
{
    swal.fire({
        title: "Processing",
        html: "Please Wait...",
        allowOutsideClick: false,
        didOpen: () => {
            swal.showLoading();
        },
    });

    var url = `${window.location.href}/${year}/${month}/${classGroup}/getData`
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