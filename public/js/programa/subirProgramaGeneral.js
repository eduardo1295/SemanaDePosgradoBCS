$(document).ready(function(){
    $('#guardar').click(function(){
        var id = $('#alumno_id').val();
        var ruta = rutaBase;
        //var ruta = "{{url('programa')}}/" + id + "";
        var datos = new FormData($("#programaGeneralForm")[0]);
        console.log(Array.from(datos));
        
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: ruta,
            type: "POST",
            data: datos,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                
                if(data == "error"){
                    $("#snackbar").html("<span style='color: red;'><i class='fas fa-times-circle'></i></span> Error.");
                    $("#snackbar").addClass("show");
                    setTimeout(function () { $("#snackbar").removeClass("show"); }, 5000);
                    $('#convocatoria_error').text("El campo es requerido");
                }
                else{
                    $('#convocatoria_error').text("");
                    $("#snackbar").html(
                        "<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Se ha Actualizado exitosamente."
                    );
                    $("#snackbar").addClass("show");
                    setTimeout(function() {
                        $("#snackbar").removeClass("show");
                    }, 5000);
                }
            },
            error: function (data) {
                console.log(data);
                /*
                if (data.status == 422) {
                    var errores = data.responseJSON['errors'];
                    $.each(errores, function (key, value) {
                        $('#' + key + "_error").text(value);
                    });                    
                }
                */
                $("#snackbar").html("<span style='color: red;'><i class='fas fa-times-circle'></i></span> Error al editar.");
                $("#snackbar").addClass("show");
                setTimeout(function () { $("#snackbar").removeClass("show"); }, 5000);
            },
        });
    });
});