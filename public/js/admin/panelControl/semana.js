    var titulo = "";
    var table = "";
    $(document).ready(function () {
        
        $('.note-statusbar').hide();

        $("#show-sidebar").click(function () {
            $('#semanas').DataTable().ajax.reload(null, false);
        });

        $(function () {
            registerSummernote('.summernote', 'Descripción general del evento', 1000, function (max) {
                $('#maxContentPost').text(max)
            });
        });


        $.extend($.fn.dataTableExt.oStdClasses, {
            "sFilterInput": "busqueda",
            "sLengthSelect": ""
        });

        $('#semanas tfoot  th.text-input').each(function (i) {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="' + title + '" name="' + i + '" />');
        });

        table = $('#semanas').DataTable({
            "order": [
                [6, "desc"]
            ],
            pageLength: 5,
            lengthMenu: [
                [5, 10, 20],
                [5, 10, 20]
            ],
            responsive: true,
            autoWidth: false,
            "language": {
                "url": turaIdioma
            },
            "processing": true,
            "serverSide": true,
            "search": true,
            "ajax": {
                "url": rutalistSemanas,
                /*"data": function (d) {
                    d.busqueda = checkSemana
                }*/
            },
            "columns": [{
                    data: 'id',
                    name: 'id',
                    'visible': false,
                    searchable: false
                },
                {
                    data: 'semana_nombre',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'institucion_nombre',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'fecha_inicio',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'fecha_fin',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'url_convocatoria',
                    name: 'url_convocatoria',
                    render: function (data, type, full, meta) {
                        if (data == "no_disponible")
                            return data.replace("_", " ");
                        else
                            return "<a style='cursor:pointer' target='_blank' href="+SITEURL+"/storage/pdf/convocatoria/" +
                                data + '/?'+ $.now() + ">" + data + "<a/>";
                    },
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'fecha_actualizacion',
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            columnDefs: [{
                    responsivePriority: 1,
                    targets: 1
                },
                {
                    responsivePriority: 2,
                    targets: 7
                },
                {
                    width: 105,
                    targets: 7
                }
            ]
        });

        $('#semanas tbody').on('click', '.eliminar, .reactivar', function (e) {
            var tr = $(this).closest("tr");
            var data = $("#semanas").DataTable().row(tr).data();
            titulo = data.titulo;
        });
    });



    /*Al presionar el boton editar*/
    $('body').on('click', '.editar', function () {
        reiniciar();
        var semana_id = $(this).data('id');
        var ruta = rutaBaseSemana + "/" + semana_id + "/editar";


        $.get(ruta, function (data) {
            $('#semanaForm').trigger("reset");
            var unique = $.now();
            $('#semanaCrudModal').html("Editar semana: " + data.nombre);
            $('#btn-save').val("editar");
            $('#semana-crud-modal').modal('show');
            $('#semana_id').val(data.id_semana);
            $('#nombre').val(data.nombre);
            $('#contenido').summernote('code', data.desc_general);
            $('#fecha').val(data.fecha);
            $("#institucionSelect").val(data.instituciones[0].id);
            $('#contenido').summernote('code', data.contenido);
            $('#imglogo').prop('src', logoURL+"/" + data.url_logo + '/?' + unique);
            $('#logoactual').html('Logo actual');
            $('#logoAnterior').removeClass('d-none');
            $('#fecha').data('daterangepicker').setStartDate(data.fecha_inicio);
            $('#fecha').data('daterangepicker').setEndDate(data.fecha_fin);
            if (data.url_convocatoria == 'no_disponible')
                $('#ligaConvo').html('No se ha cargado convocatoria')
            else
                $('#ligaConvo').html(
                    'Convocatoria <a target="_blank" href='+SITEURL+'/storage/pdf/convocatoria/' + data
                    .url_convocatoria + '/?'+ $.now() + '>' + data.url_convocatoria + '<a/>');

        })
    });


    /*Accion al presionar el boton crear-semana*/
    $('#crear-semana').click(function () {
        reiniciar();
        $('#btn-save').val("crear-semana");
        $('#semana_id').val('');
        $('#semanaForm').trigger("reset");
        $('#imglogo').prop('src', "");
        $('#logoactual').html('');
        $('#semanaCrudModal').html("Nueva Evento Semana de Posgrado");
        $('#semana-crud-modal').modal({
            backdrop: 'static',
            keyboard: false
        })
        $('#semana-crud-modal').modal('show');
        $('#fecha').data('daterangepicker').setStartDate(moment().format('YYYY-MM-DD'));
        $('#fecha').data('daterangepicker').setEndDate(moment().add(4, 'days').format('YYYY-MM-DD'));
    });

    $('.modal-btn').click(function () {
        $('#btn-save').val("crear-semana");
        $('#semana_id').val('');
        $('#semanaForm').trigger("reset");
        $('#semanaCrudModal').html("Agregar nueva institución");
        $('#semana-crud-modal').modal({
            backdrop: 'static',
            keyboard: false
        })
        $('#semana-crud-modal').modal('show');
    });


    /*Accion al presionar el boton save*/
    $("#btn-save").click(function () {
        $('.mensajeError').text("");
        $("#btn-save").prop("disabled", true);
        $("#btn-close").prop("disabled", true);
        var actionType = $('#btn-save').val();
        $('#btn-save').html('Guardando..');
        if (actionType == "editar") {
            var id = $('#semana_id').val();
            var ruta = rutaBaseSemana + "/" + id + "";
            var datos = new FormData($("#semanaForm")[0]);
            var rFechas = $('#fecha').val().split(' - ');
            datos.append('fecha_inicio', rFechas[0]);
            datos.append('fecha_fin', rFechas[1]);
            datos.append('_method', 'PUT');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: ruta,
                type: "POST",
                data: datos,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {

                    $('#semanaForm').trigger("reset");
                    $('#semana-crud-modal').modal('hide');
                    $('#btn-save').html('Guardar');
                    //recargar serverside
                    var oTable = $('#semanas').dataTable();
                    oTable.fnDraw(false);

                    mostrarSnack("Actualización exitosa.");
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                    $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');

                },
                error: function (data) {
                    mostrarSnackError('Error al actualizar evento');
                    if (data.status == 422) {
                        
                        var errores = data.responseJSON['errors'];
                        $.each(errores, function (key, value) {
                            $('#' + key + "_error").text(value);
                        });
                    }
                    $('#btn-save').html('Guardar');
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                },
                complete: function (data) {
                    var unique = $.now();
                    if (data.responseJSON['vigente'] == 1) {
                        $('#logoMenu').prop('src', SITEURL+'/storage/img/semanaLogo/' + data
                            .responseJSON['url_logo'] + '/?' + unique);
                    }
                }

            });
        } else if (actionType == "crear-semana") {
            $("#btn-save").prop("disabled", true);
            $("#btn-close").prop("disabled", true);
            var datos = new FormData($("#semanaForm")[0]);
            var rFechas = $('#fecha').val().split(' - ');
            datos.append('fecha_inicio', rFechas[0]);
            datos.append('fecha_fin', rFechas[1]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: datos,
                url: rutaBaseSemana,
                type: "POST",
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $('#semanaForm').trigger("reset");
                    $('#semana-crud-modal').modal('hide');
                    $('#btn-save').html('Guardar');
                    //recargar serverside
                    var oTable = $('#semanas').dataTable();
                    oTable.fnDraw(false);
                    //recargar sin serverside
                    mostrarSnack("Evento registrado exitosamente.");
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                    $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
                    $('#nuevoLogo').addClass('d-none');
                    if (data.vigente == 1) {
                        $('#logoMenu').prop('src', SITEURL+'/storage/img/semanaLogo/' + data
                            .url_logo);
                    }
                },
                error: function (data) {
                    mostrarSnackError('Error al guardar evento');
                    if (data.status == 422) {
                        
                        var errores = data.responseJSON['errors'];
                        $.each(errores, function (key, value) {
                            $('#' + key + "_error").text(value);
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
        var semana_id = $(this).data("id");
        $.confirm({
            columnClass: 'col-md-6',
            title: '¿Desea eliminar la semana ?',
            content: 'Este mensaje activará automáticamente \'cancelar\' en 8 segundos si no responde.',
            autoClose: 'cancelAction|8000',
            buttons: {
                cancelAction: {
                    text: 'Cancelar',
                    btnClass: 'btn-red',
                    action: function () {}
                },
                confirm: {
                    text: 'Aceptar',
                    icon: 'fas fa-warning',
                    btnClass: 'btn-blue',
                    action: function () {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "DELETE",
                            url: rutaBaseSemana + '/' + semana_id,
                            success: function (data) {
                                var oTable = $('#semanas').dataTable();
                                if (table.data().count() == 1) {
                                    $('#semanas').DataTable().ajax.reload();
                                } else {
                                    oTable.fnDraw(false);
                                }
                                mostrarSnack("Evento eliminado exitosamente.");
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                if (xhr.status == 422) {
                    
                                    var errores = xhr.responseJSON['errors'];
                                    if(errores!=null)
                                        mostrarSnackError(errores);
                                }
                            }
                        });


                    }
                }
            }
        });
    });


    /*Accion al presionar el boton reactivar*/
    $('body').on('click', '.reactivar', function () {
        var semana_id = $(this).data("id");
        $.confirm({
            columnClass: 'col-md-6',
            title: '¿Desea reactivar la semana titulada ' + titulo + '?',
            content: 'Este mensaje activará automáticamente \'cancelar\' en 8 segundos si no responde.',
            autoClose: 'cancelAction|8000',
            buttons: {
                cancelAction: {
                    text: 'Cancelar',
                    btnClass: 'btn-red',
                    action: function () {}
                },
                confirm: {
                    text: 'Aceptar',
                    icon: 'fas fa-warning',
                    btnClass: 'btn-blue',
                    action: function () {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "PUT",
                            url: rutaReactivar + '/' + semana_id,
                            success: function (data) {
                                var oTable = $('#semanas').dataTable();
                                if (table.data().count() == 1) {
                                    $('#semanas').DataTable().ajax.reload();
                                } else {
                                    oTable.fnDraw(false);
                                }
                                mostrarSnack("Evento activado exitosamente.");
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
        $('#contenido').summernote("reset");
        $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
        $('#nuevoLogo').addClass('d-none');
        $('#ligaConvo').html('Convocatoria');
    }

    $('.custom-file-input').on('change', function () {
        let fileName = $(this).val().split('\\').pop();
        if (!fileName.trim()) {
            $(this).next('.custom-file-label').removeClass("selected").html('Ningún archivo seleccionado');
        } else {
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        }
    });

