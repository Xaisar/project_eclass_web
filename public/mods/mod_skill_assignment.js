$('.input-file-now').dropify();

$('.showFormUpload').unbind().on('click', function(e){
    e.preventDefault()
    $('#myModal').modal('show')
    $('input[name="hashid"]').val($(this).data('id'))
})

$('input[name="file_type"]').click(function(){
    if($(this).val() == 'link'){
        $('#formLink').removeClass('d-none')
        $('#formFile').addClass('d-none')
    } else {
        $('#formLink').addClass('d-none')
        $('#formFile').removeClass('d-none')
    }
})