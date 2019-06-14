function mostrarSnack(mensaje){
    var texto = "<span style='color:#FFF;'><i class='far fa-check-circle'></i></span> ";
    var botonCerrar = '<span class="closeSnack" onclick="cerrarSnack();" >&times;</span>';
    $("#snackbar").html(texto + mensaje + botonCerrar);
    $("#snackbar").addClass("show");
    setTimeout(function(){ $("#snackbar").removeClass("show"); }, 5000);
}

function mostrarSnackError(mensaje){
    var textoError = "<span style='color:#FFF;'><i class='fas fa-times'></i></span> "
    var botonCerrarError = '<span class="closeSnack" onclick="cerrarSnack();" >&times;</span>';
    $("#snackbarError").html(textoError + mensaje + botonCerrarError);
    $("#snackbarError").addClass("show");
    setTimeout(function(){ $("#snackbarError").removeClass("show"); }, 5000);
}

function cerrarSnack(){
    $("#snackbar").removeClass("show");
    $("#snackbarError").removeClass("show");
}