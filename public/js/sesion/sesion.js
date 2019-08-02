var checkInsti = 'activos';
var titulo = "";
var table = "";
$(document).ready(function () {
    $('.checkbox').click(function (){
        //numberOfChecked = $('input:checkbox:checked').length
        //console.log('Presionado');
    });
    $("#show-sidebar").click(function () {
        $('#sesion').DataTable().ajax.reload(null, false);
    });

    $.extend($.fn.dataTableExt.oStdClasses, {
        "sFilterInput": "busqueda",
        "sLengthSelect": ""
    });

    table = $('#sesion').DataTable({
        "order":[[1,"asc"]],
        pageLength: 5,
        lengthMenu: [[5, 10, 20, 100], [5, 10, 20, 100]],
        responsive: true,
        autoWidth: false,
        "language": {
            "url": turaIdioma
        },
        "processing": true,
        "serverSide": true,
        "search": true,
        "ajax": {
            "url": rutaList,
            "data": function (d) {
                d.busqueda = checkInsti
            }
        },
        "columns": [
            { data: 'id', name: 'id', 'visible': false, searchable: false },
            { data: 'nombre', searchable: true },
            { data: 'dia', searchable: true , 'visible': true },
            { data: 'hora_inicio', searchable: true , 'visible': true },
            { data: 'hora_fin', searchable: true , 'visible': true },
            { data: 'lugar', searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        columnDefs: [
            { responsivePriority: 1, targets: 1 },
            { responsivePriority: 2, targets: 6 },
            { width: 105, targets: 4 }
        ]
    });


    $("input[name='verNoti']").change(function (e) {
        checkInsti = $(this).val();
        $('#sesion').DataTable().ajax.reload();
    });

    $('#sesion tbody').on('click', '.eliminar, .reactivar', function (e) {
        var tr = $(this).closest("tr");
        var data = $("#sesion").DataTable().row(tr).data();
        titulo = data.titulo;
    });
});
/*Al presionar el boton editar*/
$('body').on('click', '.editarSesion', function () {
    var sesion_id = $(this).data('id');
    var ruta = rutaBase +"/" + sesion_id + "/editar";
    reiniciar();
    $.get(ruta, function (data) {
        $('#sesionCrudModal').html("Editar sesion: " + data.nombre);
        $('#btn-save').val("editar");
        $('#sesion-crud-modal').modal('show');
        $('#sesion_id').val(data.id_sesion);
        $('#modalidad').val(data.id_modalidad);
        $('#dia').val(data.dia);
        $('#hora_inicio').val(data.hora_inicio);
        $('#hora_fin').val(data.hora_fin);
        $('#lugar').val(data.lugar);
        $('#cantidad').val(data.cantidad);
        cambio(2,data.id_sesion);

        
    })
});
/*Accion al presionar el boton crear-sesion*/
$('#crear-sesion').click(function () {
    reiniciar();
    $('#btn-save').val("crear-sesion");
    $('#sesion_id').val('');
    $('#sesionForm').trigger("reset");
    $('#sesionCrudModal').html("Agregar nueva sesión");
    $('#sesion-crud-modal').modal({ backdrop: 'static', keyboard: false })
    $('#sesion-crud-modal').modal('show');
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
        var id = $('#sesion_id').val();
        var ruta = rutaBase + "/" + id;
        var datos = new FormData($("#sesionForm")[0]);
        console.log(Array.from(datos));
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
            
            beforeSend: function(){
                $(".loader").show();
            },
            success: function (data) {
                if(data == "cruze"){
                    $('#hora_inicio_error').text('El horario se cruza con otra sesión');
                }
                else if(data =="seleccion"){
                    $('#participantes_error').text('Debe seleccionar por lo menos un alumno');
                }
                else{
                    $('#mostrar_alumnos').html('');
                    mostrarSnack("Sesión actualizada exitosamente.");
                    $('#sesion-crud-modal').modal('hide');
                    $('#sesionForm').trigger("reset");
                }
                
                //recargar serverside
                var oTable = $('#sesion').dataTable();
                oTable.fnDraw(false);
                //recargar sin serverside
                //$('#instituciones').DataTable().ajax.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                mostrarSnackError('Error al actualizar sesión');
                if (data.status == 422) {
                    var errores = data.responseJSON["errors"];
                    $.each(errores, function(key, value) {
                        $("#" + key + "_error").text(value);
                    });
                }
                
            },
            complete: function (data) {
                $(".loader").hide();
                $('#btn-save').html('Guardar');
                $("#btn-save").prop("disabled", false);
                $("#btn-close").prop("disabled", false);
            }
        });
    } else if (actionType == "crear-sesion") {
        $("#btn-save").prop("disabled", true);
        $("#btn-close").prop("disabled", true);
        var datos = new FormData($("#sesionForm")[0]);
        console.log(Array.from(datos));
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: rutaBase,
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
                if(data == "cruze"){
                    $('#hora_inicio_error').text('El horario se cruza con otra sesión');
                }
                else if(data =="seleccion"){
                    $('#participantes_error').text('Debe seleccionar por lo menos un alumno');
                }
                else{
                    $('#mostrar_alumnos').html('');
                    mostrarSnack("Sesión creada exitosamente.");
                    $('#sesion-crud-modal').modal('hide');
                    $('#sesionForm').trigger("reset");
                }
                
                //recargar serverside
                var oTable = $('#sesion').dataTable();
                oTable.fnDraw(false);
                //recargar sin serverside
                //$('#instituciones').DataTable().ajax.reload();
            },
            error: function (data) {
                mostrarSnackError('Error al guardar sesión');
                if (data.status == 422) {
                    var errores = data.responseJSON['errors'];
                    var key2;
                    $.each(errores, function (key, value) {
                        key2= key.replace('.','\\.');
                        $('#' + key2 + '_error').text(value);
                        console.log(($('#' + key + "_error")));
                    });
                }
                
            },
            complete: function (data) {
                $(".loader").hide();
                $('#btn-save').html('Guardar');
                $("#btn-save").prop("disabled", false);
                $("#btn-close").prop("disabled", false);
            }

        });
    }
});
/*Accion al presionar el boton eliminar*/
$('body').on('click', '.eliminarSesion', function () {
    var carrusel_id = $(this).data("id");
    $.confirm({
        columnClass: 'col-md-6',
        title: '¿Desea eliminar la sesión ?',
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
                        url: rutaBase + "/" + carrusel_id,
                        success: function (data) {

                            if (table.data().count() == 1) {
                                $('#sesion').DataTable().ajax.reload();
                            } else {
                                var oTable = $('#sesion').dataTable();
                                oTable.fnDraw(false);
                            }
                            mostrarSnack('Sesión eliminada exitosamente');
                            
                        },
                        error: function (data) {
                            mostrarSnackError('Error al eliminar sesión');
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