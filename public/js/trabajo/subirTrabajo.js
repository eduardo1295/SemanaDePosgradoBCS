var SITEURL = "{{URL::to('/')}}";
$(document).ready(function() {
    
    $("#btn-save").click(function() {
        $(".mensajeError").text("");
        $("#btn-save").prop("disabled", true);
        var actionType = $("#btn-save").val();
        $("#btn-save").html("Guardando..");
        var id = $("#alumno_id").val();
        var datos = new FormData($("#trabajoForm")[0]);
        
        //console.log(Array.from(datos))
        $.ajax({
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
            url: rutaBase,
            //url: "{{route('trabajo.store')}}",
            type: "POST",
            data: datos,
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log(data)
                if(data == "ya autorizado"){
                    mostrarSnackError('Error.')
                }else{
                    $("#btn-save").html("Guardar");
                    $('#link').html(data.url);
                    $('#link').prop('href','/documentos/trabajos/'+ data.url );
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                    mostrarSnack('Trabajo entregado exitosamente');
                    $("#btn-save").html("Pendiente de revisión");
                }
                
            },
            error: function(data) {
                if (data.status == 422) {
                    var errores = data.responseJSON["errors"];
                    $.each(errores, function(key, value) {
                        $("#" + key + "_error").text(value);
                        $("." + key + "_error").text(value);
                    });
                }
                
                mostrarSnackError('Error al subir trabajo')
                $("#btn-save").html("Guardar");
                $("#btn-save").prop("disabled", false);
                $("#btn-close").prop("disabled", false);
            }
        });
    });
});
