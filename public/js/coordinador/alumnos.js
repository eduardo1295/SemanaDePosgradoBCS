

$.extend($.fn.dataTableExt.oStdClasses, {
    "sFilterInput": "busqueda",
    "sLengthSelect": ""
});

$('#alumnosdt tfoot  th.text-input').each(function (i) {
    var title = $(this).text();
    $(this).html('<input type="text" placeholder="' + title + '" name="' + i + '" />');
});

function cargarDataTableAlumnos(){
    $("#mensajeAlumnos").hide();
    if(!tableAlumno){
        tableAlumno = $('#alumnosDT').DataTable({
            "order": [[ 8, "desc" ]],
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
                "url": rutaBaseAlumno + '/listAlumnos',
                "data": function (d) {
                    d.busqueda = checkAlumno
                }
            },
            /*initComplete: function () {
                var api = this.api();
                api.columns(2).every(function () {
                    var that = this;
                    $('input', this.footer()).on('keyup change', function () {
                        if (that.search() !== this.value) {
                            that
                                .search(this.value)
                                .draw();
                        }
                    });
                })
            },*/
            "columns": [
                { data: 'id', name: 'id', 'visible': false,searchable: false },
                { data: 'num_control', searchable: true },
                { data: 'programa_nombre', searchable: true },
                { data: 'nombre', searchable: true },
                { data: 'primer_apellido', searchable: true },
                { data: 'segundo_apellido', searchable: true },
                { data: 'email', searchable: true },
                
                { data: 'director', searchable: true },
                { data: 'fecha_usuario', searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
                
            ],
            columnDefs: [
                { responsivePriority: 1, targets: 1 },
                { responsivePriority: 2, targets: 9 },
                { width: 105, targets: 9 }
            ]
        });
    }else{
        $('#alumnosDT').DataTable().ajax.reload();
    }
}

$("input[name='verAlumno']").change(function (e) {
    checkAlumno = $(this).val() + 'coor';
    $('#alumnosDT').DataTable().ajax.reload();
});


/*Al presionar el boton editar*/
$('body').on('click', '.editarAlumno', function () {
    var alumno_id = $(this).data('id');
    var ruta = rutaBaseAlumno + '/' + alumno_id + "/editar";
    
    $.get(ruta, function (data) {
        $("#mensajeAlumnos").hide();
        $('.mensajeError').text("")
        $('#alumnoCrudModal').text("Editar alumno: " + data[0].nombre + ' ' + data[0].primer_apellido + ' ' + data[0].segundo_apellido);
        $('#btn-save-alumno').val("editar");
        $('#alumno-crud-modal').modal('show');
        $('#alumno_id_al').val(data[0].id);
        $('#institucion_al').val(data.institucion);
        $('#nombre_al').val(data[0].nombre);
        $('#primer_apellido_al').val(data[0].primer_apellido);
        $('#segundo_apellido_al').val(data[0].segundo_apellido);
        $('#email_al').val(data[0].email);
        $('#semestre_al').val(data[0].alumnos.semestre);
        $('#num_control_al').val(data[0].alumnos.num_control);
        $("#institucionSelect_al").val(data[0].instituciones.id);
        
        buscarProgramas(data[0].instituciones.id,data[0].alumnos.id_programa,data[0].alumnos.id_director,true);
    })
});


/*Accion al presionar el boton eliminar*/
$('body').on('click', '.eliminarAlumno', function () {
    $("#mensajeAlumnos").hide();
    var alumno_id = $(this).data("id");
    $.confirm({
        columnClass: 'col-md-6',
        title: '¿Desea eliminar el alumno?',
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
                        url: rutaBaseAlumno + '/' + alumno_id,
                        success: function (data) {

                            if (tableAlumno.data().count() == 1) {
                                $('#alumnosDT').DataTable().ajax.reload();
                            } else {
                                var oTable = $('#alumnosDT').dataTable();
                                oTable.fnDraw(false);
                            }
                            mostrarSnack("Alumno borrado exitosamente.");
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
        $('body').on('click', '.reactivarAlumno', function () {
            $("#mensajeAlumnos").hide();
            var alumno_id = $(this).data("id");
            $.confirm({
                columnClass: 'col-md-6',
                title: "¿Desea reactivar el alumno?",
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
                                url: rutaBaseAlumno + '/' + 'reactivar/' + alumno_id,
                                success: function (data) {
                                    if (tableAlumno.data().count() == 1) {
                                        $('#alumnosDT').DataTable().ajax.reload();
                                    } else {
                                        var oTable = $('#alumnosDT').dataTable();
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
    $("#btn-save-alumno").click(function () {
        $('.mensajeError').text("");
        $("#btn-save-alumno").prop("disabled", true);
        $("#btn-close").prop("disabled", true);
        var actionType = $('#btn-save-alumno').val();
        $('#btn-save-alumno').html('Guardando..');
        if (actionType == "editar") {
            var id = $('#alumno_id_al').val();
            var ruta = rutaBaseAlumno + '/' + id;
            var datos = new FormData($("#alumnoForm")[0]);
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
                    $('#alumnoForm').trigger("reset");
                    $('#alumno-crud-modal').modal('hide');
                    //recargar serverside
                    var oTable = $('#alumnosDT').dataTable();
                    oTable.fnDraw(false);
                    
                    mostrarSnack("Actualización exitosa.");
                },
                error: function (data) {
                    
                    mostrarSnackError('Error al actualizar usuario');
                    if (data.status == 422) {
                        
                        var errores = data.responseJSON['errors'];
                        $.each(errores, function (key, value) {
                            $('#' + key + "_error").text(value);
                        });
                    }
                },
                complete: function (data) {
                    $(".loader").hide();
                    $('#btn-save-alumno').html('Guardar');
                    $("#btn-save-alumno").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                }
            });
        } else if (actionType == "crear-alumno") {
            $("#btn-save-alumno").prop("disabled", true);
            $("#btn-close").prop("disabled", true);
            var datos = new FormData($("#alumnoForm")[0]);
            
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: datos,
                url: rutaBaseAlumno,
                type: "POST",
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){
                    $(".loader").show();
                },
                success: function (data) {
                    $('#alumnoForm').trigger("reset");
                    $('#alumno-crud-modal').modal('hide');
                    
                    //recargar serverside
                    var oTable = $('#alumnosDT').dataTable();
                    oTable.fnDraw(false);
                    
                    mostrarSnack("Alumno registrado exitosamente.");
                    
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    mostrarSnackError('Error al guardar usuario');
                    if (xhr.status == 422) {
                        
                        var errores = xhr.responseJSON['errors'];
                        $.each(errores, function (key, value) {
                            $('#' + key + "_error").text(value);
                        });
                    }
                },
                complete: function (data) {
                    $(".loader").hide();
                    $('#btn-save-alumno').html('Guardar');
                    $("#btn-save-alumno").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                }

            });
        }

    })

/*Accion al presionar el boton crear-alumno*/
$('#crear-alumno').click(function () {
    $("#mensajeAlumnos").hide();
    $('#btn-save-alumno').val("crear-alumno");
    $('#alumno_id_al').val('');
    $('#alumnoForm').trigger("reset");
    $('#alumnoCrudModal').html("Agregar nueva cuenta de alumno");
    $('#alumno-crud-modal').modal('show');
    reiniciarselect();
    buscarProgramas('n','n','n',false);
});


    $('#institucionSelect_al').change(function () {
        buscarProgramas('n','n','n',false);
    });

    function buscarProgramas(bInstitucion, bPrograma, bDirector,edicion){
        selectIDIns = bInstitucion;
        var ruta =  rutaBaseAlumno + '/programasLista/' + selectIDIns;
        
        $("#btn-save-alumno").prop("disabled", true);
        $("#btn-close").prop("disabled", true);
        $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: ruta,
                type: "GET",
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){
                    $(".loader").show();
                },
                success: function (data) {
                    $('#programaSelect_al').html('');
                    $('#programaSelect_al').append('<option selected value="">Seleccione un programa de estudios</option>');
                    
                    $.each(data[0], function(key, val) {
                        $('#programaSelect_al').append('<option value="' + val.id + '">'+val.id_programa + ' - ' +val.nombre+'</option>');
                    })

                    $('#directorSelect_al').html('');
                    $('#directorSelect_al').append('<option selected value="">Seleccione un director de tesis</option>');
                    
                    $.each(data[1], function(key, val) {
                        $('#directorSelect_al').append('<option value="' + val.id + '">'+val.nombre+ ' ' +val.primer_apellido+ ' ' +val.segundo_apellido+ '</option>');
                    })
                    
                },
                error: function (data) {
                    reiniciarselect();
                    mostrarSnackError('Error al cargar información');
                    if (data.status == 422) {
                        
                        var errores = data.responseJSON['errors'];
                        $.each(errores, function (key, value) {
                            $('#' + key + "_error").text(value);
                        });
                    }
                    $('#btn-save-alumno').html('Guardar');
                },
                complete: function (data) {
                    if(edicion){
                        $("#programaSelect_al").val(bPrograma);
                        $("#directorSelect_al").val(bDirector);
                    }
                    $(".loader").hide();
                    $("#btn-save-alumno").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                }

            });
    }

    function reiniciarselect(){
        $('#programaSelect_al').html('');
        $('#programaSelect_al').append('<option selected value="">Seleccione una institución</option>');
        $('#directorSelect_al').html('');
        $('#directorSelect_al').append('<option selected value="">Seleccione una institución</option>');
    }

    function importarAlumnos(){
        var datos = new FormData($("#alumnosImportarForm")[0]);
        $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: rutaImportarAlumnos,
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
                    $("#mensajeAlumnos").hide();
                    mostrarSnack('Alumnos registrados exitosamente');    
                    $('#alumnosDT').DataTable().ajax.reload();
                },
                error: function (data) {
                    
                    mostrarSnackError('Error al registrar alumnos');
                    if (data.status == 422) {
                        
                        var errores = data.responseJSON['errors'];
                        var listaErrores = "";
                        $.each(errores, function (key, value) {
                            listaErrores += value;
                        });
                        $('#mensajeAlumnos').html(
                            '<div class="col-12 alert alert-danger alert-dismissible" role="alert">'
                            +
                            listaErrores + "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                        $("#mensajeAlumnos").show();
                    }
                    
                },
                complete: function (data) {
                    $(".loader").hide();
                }

            });
    };