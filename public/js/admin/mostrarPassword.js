function mostrarContra(idInput,btnPass){
    if($('#'+idInput).attr('type') === 'password') {
        $('#'+idInput).attr('type','text');
        $(btnPass).find('i').removeClass('fa-eye');
        $(btnPass).find('i').addClass('fa-eye-slash');
    }
    else if($('#'+idInput).attr('type') === 'text') {
        $('#'+idInput).attr('type','password');
        $(btnPass).find('i').addClass('fa-eye');
        $(btnPass).find('i').removeClass('fa-eye-slash');
    }
}