function mostrarContra(idInput){
    if($('#'+idInput).attr('type') === 'password') {
        $('#'+idInput).attr('type','text');
        $(this).find('i').removeClass('fa-eye');
        $(this).find('i').addClass('fa-eye-slash');
    }
    else if($('#'+idInput).attr('type') === 'text') {
        $('#'+idInput).attr('type','password');
        $(this).find('i').addClass('fa-eye');
        $(this).find('i').removeClass('fa-eye-slash');
    }
}