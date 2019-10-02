$.extend($.fn.dataTableExt.oStdClasses, {
    "sFilterInput": "busqueda",
    "sLengthSelect": ""
});

$('#locacionesDT tfoot  th.text-input').each(function (i) {
    var title = $(this).text();
    $(this).html('<input type="text" placeholder="' + title + '" name="' + i + '" />');
});

function cargarDataTableLocaciones(){
    if(!tableLocacion){
        
        tableLocacion = $('#locacionesDT').DataTable({
            "order":[[2,"asc"]],
            pageLength: 5,
            lengthMenu: [[5, 10, 20, 50], [5, 10, 20, 50]],
            responsive: true,
            autoWidth: false,
            "language": {
                "url": turaIdioma
            },
            "processing": true,
            "serverSide": true,
            "search": true,
            "ajax": {
                "url": rutaBaseLocacion + '/listLocacion',
                "data": function (d) {
                    d.busqueda = checkLoca
                }
            },
            "columns": [
                { data: 'id', name: 'id', 'visible': false, searchable: false },
                { data: 'nombre', searchable: true },
                { data: 'fecha_actualizacion', searchable: true , 'visible': true },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            columnDefs: [
                { responsivePriority: 1, targets: 1 },
                { responsivePriority: 2, targets: 3 },
                { width: 105, targets: 3 }
            ]
        });
    }else{
        $('#locacionesDT').DataTable().ajax.reload();
    }
}

/*Al presionar el boton editar*/
$('body').on('click', '.editarLocacion', function () {
    var locacion_id = $(this).data('id');
    var ruta = rutaBaseLocacion + '/' + locacion_id + "/editar";
    reiniciar();
    $.get(ruta, function (data) {
        $('#locacionCrudModal').text("Editar locacion: " + data.nombre);
        $('#btn-save').val("editar");
        $('#locacion-crud-modal').modal('show');
        $('#id_locacion').val(data.id_locacion);
        $('#locacionForm #nombre').val(data.nombre);
    })
});

/*Accion al presionar el boton crear-locacion*/
$('#crear-locacion').click(function () {
    reiniciar();
    $('#btn-save').val("crear-locacion");
    $('#locacion_id').val('');
    $('#locacionForm').trigger("reset");
    $('#locacionCrudModal').html("Agregar nueva locación");
    $('#locacion-crud-modal').modal({ backdrop: 'static', keyboard: false })
    $('#locacion-crud-modal').modal('show');
    $('#mostrar_alumnos').html('');

});

/*Accion al presionar el boton save*/
$("#btn-save").click(function () {
    $('.mensajeError').text("");
    $("#btn-save").prop("disabled", true);
    $("#btn-close").prop("disabled", true);
    var actionType = $('#btn-save').val();
    $('#btn-save').html('Guardando..');
    if (actionType == "editar") {
        var id = $('#id_locacion').val();
        var ruta = rutaBaseLocacion + "/" + id;
        var datos = new FormData($("#locacionForm")[0]);
        
        datos.append('_method', 'PUT');
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
                if(data == "cruze"){
                    $('#hora_inicio_error').text('Los horarios se Cruzan con otra sesión');
                }
                else if(data =="seleccion"){
                    $('#participantes_error').text('No ha seleccionado ningun Alumno');
                }
                else{
                    $('#mostrar_alumnos').html('');
                    mostrarSnack("Locación editada exitosamente.");
                    $('#locacion-crud-modal').modal('hide');
                }
                $('#locacionForm').trigger("reset");
                $('#btn-save').html('Guardar');
                //recargar serverside
                var oTable = $('#locacionesDT').dataTable();
                oTable.fnDraw(false);
                //recargar sin serverside
                //$('#instituciones').DataTable().ajax.reload();
                $("#btn-save").prop("disabled", false);
                $("#btn-close").prop("disabled", false);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                mostrarSnackError('Error al actualizar locación');
                if (data.status == 422) {
                    var errores = data.responseJSON["errors"];
                    $.each(errores, function(key, value) {
                        $("#" + key + "_error").text(value);
                    });
                }
                $('#btn-save').html('Guardar');
                $("#btn-save").prop("disabled", false);
                $("#btn-close").prop("disabled", false);
            },

        });
    } else if (actionType == "crear-locacion") {
        $("#btn-save").prop("disabled", true);
        $("#btn-close").prop("disabled", true);
        var datos = new FormData($("#locacionForm")[0]);
        
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: rutaBaseLocacion,
            type: "POST",
            data: datos,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if(data == "Repetida"){
                    $('#nombre_error').text('La locación esta repetida.');
                }
                else{
                    mostrarSnack("Locación agregada exitosamente.");
                    $('#locacion-crud-modal').modal('hide');
                    $('#locacionForm').trigger("reset");
                }
                
                $('#btn-save').html('Guardar');
                //recargar serverside
                var oTable = $('#locacionesDT').dataTable();
                oTable.fnDraw(false);
                //recargar sin serverside
                //$('#instituciones').DataTable().ajax.reload();
                $("#btn-save").prop("disabled", false);
                $("#btn-close").prop("disabled", false);
            },
            error: function (data) {
                mostrarSnackError('Error al guardar locación');
                if (data.status == 422) {
                    var errores = data.responseJSON['errors'];
                    var key2;
                    $.each(errores, function (key, value) {
                        key2= key.replace('.','\\.');
                        $('#' + key2 + '_error').text(value);
                        
                    });
                }
                $('#btn-save').html('Guardar');
                $("#btn-save").prop("disabled", false);
                $("#btn-close").prop("disabled", false);
            },


        });
    }
});
/*Accion al presionar el boton eliminar*/
$('body').on('click', '.eliminarLocacion', function () {
    var locacion_id = $(this).data("id");
    $.confirm({
        columnClass: 'col-md-6',
        title: '¿Desea eliminar la imagen?',
        content: 'Este mensaje activará automáticamente \'cancelar\' en 8 segundos si no responde.',
        autoClose: 'cancelAction|8000',
        buttons: {
            cancelAction: {
                text: 'Cancelar',
                btnClass: 'btn-red',
                action: function () {
                }
            },
            confirm: {
                text: 'Aceptar',
                icon: 'fas fa-warning',
                btnClass: 'btn-blue',
                action: function () {
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: "DELETE",
                        url: rutaBaseLocacion+ "/" + locacion_id,
                        success: function (data) {

                            if (tableLocacion.data().count() == 1) {
                                $('#locacionesDT').DataTable().ajax.reload();
                            } else {
                                var oTable = $('#locacionesDT').dataTable();
                                oTable.fnDraw(false);
                            }

                            
                            mostrarSnack("Locación eliminada exitosamente.");
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
            }
        }
    });



});

function reiniciar() {
    $('.mensajeError').text("");
}