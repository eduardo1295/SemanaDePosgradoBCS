$(document).ready(function(){

    var showPass = 0;
    $('.btn-show-pass').on('click', function(){
        if(showPass == 0) {
            $("#password").attr('type','text');
            $(this).find('i').removeClass('fa-eye');
            $(this).find('i').addClass('fa-eye-slash');
            showPass = 1;
        }
        else {
            $("#password").attr('type','password');
            $(this).find('i').addClass('fa-eye');
            $(this).find('i').removeClass('fa-eye-slash');
            showPass = 0;
        }
        
    });

    $("#btn-save").click(function () {
        $('.mensajeError').text("");
        $("#btn-save").prop("disabled", true);
        var actionType = $('#btn-save').val();
        $('#btn-save').html('Guardando..');
            var id = $('#alumno_id').val();
            var ruta = rutaBase;
            //var ruta = "{{url('programa')}}/" + id + "";
            var datos = new FormData($("#alumnoForm")[0]);
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
                    $('#email').val(data["email"]);
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                    mostrarSnack('Se ha actualizado correctamente');
                    console.log(data);
                },
                error: function (data) {
                    if (data.status == 422) {
                        
                        var errores = data.responseJSON['errors'];
                        $.each(errores, function (key, value) {
                            $('#' + key + "_error").text(value);
                        });                    
                    }
                    mostrarSnackError('Error al actualizar datos');
                    $('#btn-save').html('Guardar');
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                },

            });
        

    })
});