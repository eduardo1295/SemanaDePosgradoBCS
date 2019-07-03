

$.extend($.fn.dataTableExt.oStdClasses, {
    "sFilterInput": "busqueda",
    "sLengthSelect": ""
});

$('#sesionesDT tfoot  th.text-input').each(function (i) {
    var title = $(this).text();
    $(this).html('<input type="text" placeholder="' + title + '" name="' + i + '" />');
});

function cargarDataTableSesiones(){
    console.log(tableSesion);
    if(!tableSesion){
        console.log('hola');
        tableSesion = $('#sesionesDT').DataTable({
            "order":[[2,"asc"]],
        pageLength: 5,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']],
        responsive: true,
        autoWidth: false,
        "language": {
            "url": "/js/datatableJS/es.json"
        },
        "processing": true,
        "serverSide": true,
        "search": true,
        "ajax": {
            "url": rutaBaseSesion + '/listSesiones',
            "data": function (d) {
                d.busqueda = checkSesion
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
            { width: 105, targets: 6 }
        ]
        });
    }else{
        console.log('Nel');
        $('#sesionesDT').DataTable().ajax.reload();
    }
}

$("input[name='versesion']").change(function (e) {
    checksesion = $(this).val();
    $('#sesionesDT').DataTable().ajax.reload();
});


/*Al presionar el boton editar*/
$('body').on('click', '.editarSesion', function () {
    var sesion_id = $(this).data('id');
    var ruta = rutaBaseSesion + '/' + sesion_id + "/editar";
    
    $.get(ruta, function (data) {
        console.log(data);    
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


/*Accion al presionar el boton eliminar*/
$('body').on('click', '.eliminarSesion', function () {
    var sesion_id = $(this).data("id");
    $.confirm({
        columnClass: 'col-md-6',
        title: '¿Desea eliminar el sesion?',
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
                        url: rutaBaseSesion + '/' + sesion_id,
                        success: function (data) {

                            if (tableSesion.data().count() == 1) {
                                $('#sesionesDT').DataTable().ajax.reload();
                            } else {
                                var oTable = $('#sesionesDT').dataTable();
                                oTable.fnDraw(false);
                            }
                            mostrarSnack("sesion borrado exitosamente.");
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


        /*Accion al presionar el boton reactivar*/
        $('body').on('click', '.reactivarsesion', function () {
            var sesion_id = $(this).data("id");
            $.confirm({
                columnClass: 'col-md-6',
                title: "¿Desea reactivar el sesion?",
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
                                type: "PUT",
                                url: rutaBaseSesion + '/' + 'reactivar/' + sesion_id,
                                success: function (data) {
                                    if (tablesesion.data().count() == 1) {
                                        $('#sesionesDT').DataTable().ajax.reload();
                                    } else {
                                        var oTable = $('#sesionesDT').dataTable();
                                        oTable.fnDraw(false);
                                    }
                                    mostrarSnack("Cuenta activada exitosamente.");
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


        /*Accion al presionar el boton save*/
    $("#btn-save-sesion").click(function () {
        $('.mensajeError').text("");
        $("#btn-save-sesion").prop("disabled", true);
        $("#btn-close").prop("disabled", true);
        var actionType = $('#btn-save-sesion').val();
        $('#btn-save-sesion').html('Guardando..');
        if (actionType == "editar") {
            var id = $('#sesion_id_al').val();
            var ruta = rutaBaseSesion + '/' + id;
            var datos = new FormData($("#sesionForm")[0]);
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
                    $('#sesionForm').trigger("reset");
                    $('#sesion-crud-modal').modal('hide');
                    $('#btn-save-sesion').html('Guardar');
                    //recargar serverside
                    var oTable = $('#sesionesDT').dataTable();
                    oTable.fnDraw(false);
                    
                    mostrarSnack("Actualización exitosa.");
                    $("#btn-save-sesion").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                    console.log(data);
                },
                error: function (data) {
                    
                    
                    if (data.status == 422) {
                        
                        var errores = data.responseJSON['errors'];
                        $.each(errores, function (key, value) {
                            $('#' + key + "_error").text(value);
                        });
                    }
                    $('#btn-save-sesion').html('Guardar');
                    $("#btn-save-sesion").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                },

            });
        } else if (actionType == "crear-sesion") {
            $("#btn-save-sesion").prop("disabled", true);
            $("#btn-close").prop("disabled", true);
            var datos = new FormData($("#sesionForm")[0]);
            //datos.append('id_institucion', $('#institucionSelect').find("option:selected").val());
            console.log(Array.from(datos));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: datos,
                url: rutaBaseSesion,
                type: "POST",
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $('#sesionForm').trigger("reset");
                    $('#sesion-crud-modal').modal('hide');
                    $('#btn-save-sesion').html('Guardar');
                    //recargar serverside
                    var oTable = $('#sesionesDT').dataTable();
                    oTable.fnDraw(false);
                    
                    mostrarSnack("sesion registrado exitosamente.");
                    $("#btn-save-sesion").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    if (xhr.status == 422) {
                        mostrarSnackError('Error al guardar el sesion');
                        var errores = xhr.responseJSON['errors'];
                        $.each(errores, function (key, value) {
                            $('#' + key + "_error").text(value);
                        });
                    }
                    $('#btn-save-sesion').html('Guardar');
                    $("#btn-save-sesion").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                },


            });
        }

    })

/*Al presionar el boton editar*/
$('body').on('click', '.editar', function () {
    var sesion_id = $(this).data('id');
    var ruta = "/sesion/" + sesion_id + "/editar";
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
        var ruta = rutaBaseSesion + '/' + id;
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
            success: function (data) {
                if(data == "cruze"){
                    $('#hora_inicio_error').text('Los horarios se Cruzan con otra sesión');
                }
                else if(data =="seleccion"){
                    $('#participantes_error').text('No ha seleccionado ningun Alumno');
                }
                else{
                    $('#mostrar_alumnos').html('');
                    mostrarSnack("sesion agregada exitosamente.");
                    $('#sesion-crud-modal').modal('hide');
                }
                $('#sesionForm').trigger("reset");
                $('#btn-save').html('Guardar');
                //recargar serverside
                $('#sesionesDT').DataTable().ajax.reload();
                //recargar sin serverside
                //$('#instituciones').DataTable().ajax.reload();
                $("#btn-save").prop("disabled", false);
                $("#btn-close").prop("disabled", false);
            },
            error: function (xhr, ajaxOptions, thrownError) {
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
    } else if (actionType == "crear-sesion") {
        $("#btn-save").prop("disabled", true);
        $("#btn-close").prop("disabled", true);
        var datos = new FormData($("#sesionForm")[0]);
        console.log(Array.from(datos));
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: rutaBaseSesion,
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
                    mostrarSnack("sesion agregada exitosamente.");
                    $('#sesion-crud-modal').modal('hide');
                }
                $('#sesionForm').trigger("reset");
                $('#btn-save').html('Guardar');
                //recargar serverside
                $('#sesionesDT').DataTable().ajax.reload();
                //recargar sin serverside
                //$('#instituciones').DataTable().ajax.reload();
                $("#btn-save").prop("disabled", false);
                $("#btn-close").prop("disabled", false);
            },
            error: function (data) {
                if (data.status == 422) {
                    var errores = data.responseJSON['errors'];
                    var key2;
                    $.each(errores, function (key, value) {
                        key2= key.replace('.','\\.');
                        $('#' + key2 + '_error').text(value);
                        console.log(($('#' + key + "_error")));
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
$('body').on('click', '.eliminar', function () {
    var carrusel_id = $(this).data("id");
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
                        url: "/sesion/" + carrusel_id,
                        success: function (data) {

                            if (table.data().count() == 1) {
                                $('#sesion').DataTable().ajax.reload();
                            } else {
                                var oTable = $('#sesion').dataTable();
                                oTable.fnDraw(false);
                            }

                            var x = document.getElementById("snackbar");
                            x.innerHTML="<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Imagen eliminada exitosamente.";
                            x.className = "show";
                            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
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