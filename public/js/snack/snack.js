function mostrarSnack(mensaje){
    $("#snackbar").html(mensaje);
    $("#snackbar").addClass("show");
    setTimeout(function(){ $("#snackbar").removeClass("show"); }, 5000);
}

function mostrarSnackError(mensaje){
    $("#snackbarError").html(mensaje);
    $("#snackbarError").addClass("show");
    setTimeout(function(){ $("#snackbarError").removeClass("show"); }, 5000);
}