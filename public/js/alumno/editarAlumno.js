$(document).ready(function(){
    $("#btn-save").click(function () {
        $('.mensajeError').text("");
        $("#btn-save").prop("disabled", true);
        var actionType = $('#btn-save').val();
        $('#btn-save').html('Guardando..');
        if (actionType == "editar") {
            var id = $('#alumno_id').val();
            var ruta = "/alumno/"+ id;
            //var ruta = "{{url('programa')}}/" + id + "";
            var datos = new FormData($("#alumnoForm")[0]);
            datos.append('_method', 'PUT');
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
                    $('#programaForm').trigger("reset");
                    $('#programa-crud-modal').modal('hide');
                    $('#btn-save').html('Guardar');
                    $('#nombre').val(data["nombre"]);
                    $('#primer_apellido').val(data["primer_apellido"]);
                    $('#segundo_apellido').val(data["segundo_apellido"]);
                    $('#email').val(data["email"]);
                    $(window).scrollTop(0);
                    
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                    $("#snackbar").html("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Se ha Actualizado exitosamente.");
                    $("#snackbar").addClass("show");
                    setTimeout(function () { $("#snackbar").removeClass("show"); }, 5000);
                    console.log(data);
                },
                error: function (data) {
                    if (data.status == 422) {
                        var errores = data.responseJSON['errors'];
                        $.each(errores, function (key, value) {
                            $('#' + key + "_error").text(value);
                        });                    
                    }
                    $("#snackbar").html("<span style='color: red;'><i class='fas fa-times-circle'></i></span> Error al editar.");
                    $("#snackbar").addClass("show");
                    setTimeout(function () { $("#snackbar").removeClass("show"); }, 5000);
                    $(window).scrollTop(0);
                    $('#btn-save').html('Guardar');
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                },

            });
        }

    })
});