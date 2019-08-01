$(document).ready(function(){
    $('#guardar').click(function(){
        var id = $('#alumno_id').val();
        var ruta = rutaBase;
        //var ruta = "{{url('programa')}}/" + id + "";
        var datos = new FormData($("#programaGeneralForm")[0]);
         
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: ruta,
            type: "POST",
            data: datos,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function(){
                $(".loader").show();
            },
            success: function (data) {
                
                if(data == "error"){
                    mostrarSnackError('Error al guardar');
                    $('#convocatoria_error').text("El campo es requerido");
                }
                else{
                    $('#convocatoria_error').text("");
                    mostrarSnack('Archivo guardado');
                }
                $('.mensajeError').text("");
            },
            error: function (data) {
                
                if (data.status == 422) {
                    var errores = data.responseJSON['errors'];
                    $.each(errores, function (key, value) {
                        $('#' + key + "_error").text(value);
                    });                    
                }
                
               mostrarSnackError('Error al guardar');
            },
            complete: function (data) {
                $(".loader").hide();
                
            }
        });
    });
});