    var SITEURL = "{{URL::to('/')}}";
    var checkCoord = 'activos';
    var selectIDIns= "";
    $(document).ready(function () {
        
        $.extend($.fn.dataTableExt.oStdClasses, {
            "sFilterInput": "busqueda",
            "sLengthSelect": ""
        });

        var table = $('#directoresdt').DataTable({
            "order": [[ 6, "desc" ]],
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
                "url": rutalistDirector,
                "data": function (d) {
                    d.busqueda = checkCoord
                }
            },
            initComplete: function () {
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
            },
            "columns": [
                { data: 'id', name: 'id', 'visible': false,searchable: false },
                { data: 'nombre', searchable: true },
                { data: 'primer_apellido', searchable: true },
                { data: 'segundo_apellido', searchable: true },
                
                { data: 'email', searchable: true },
                { data: 'institucion_nombre', searchable: true },
                { data: 'fecha_usuario', searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            columnDefs: [
                { responsivePriority: 1, targets: 1 },
                { responsivePriority: 2, targets: 7 },
                { width: 105, targets: 7 }
            ]
        });



        $("#close-sidebar").click(function () {
            $('.mensajeError').text("");
            
        });

        $("#show-sidebar").click(function () {
            $('#directoresdt').DataTable().ajax.reload(null, false);
        });



        /*Al presionar el boton editar*/
        $('body').on('click', '.editarDirector', function () {
            reiniciar();
            var director_id = $(this).data('id');
            var ruta = rutaBaseDirector + "/" + director_id + "/editar";
            $.get(ruta, function (data) {
                //ocultar errores
                $('#password_di').attr("placeholder", "Nueva contraseña");
                $('#directorCrudModal').html("Editar director:" + data.nombre);
                $('#btn-save-director').val("editar");
                $('#director-crud-modal').modal('show');
                $('#director_id').val(data.id);
                $('#institucion_di').val(data.institucion);
                $('#nombre_di').val(data.nombre);
                $('#primer_apellido_di').val(data.primer_apellido);
                $('#segundo_apellido_di').val(data.segundo_apellido);
                $('#email_di').val(data.email);
                
                $("#institucionSelect_di").val(data.instituciones.id);
                

            })
        });

        //var info = table.page.info();
        /*Accion al presionar el boton eliminar*/
        $('body').on('click', '.eliminarDirector', function () {
            var director_id = $(this).data("id");
            $.confirm({
                columnClass: 'col-md-6',
                title: '¿Desea eliminar el director?',
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
                                url: rutaBaseDirector + '/' + director_id,
                                success: function (data) {

                                    if (table.data().count() == 1) {
                                        $('#directoresdt').DataTable().ajax.reload();
                                    } else {
                                        var oTable = $('#directoresdt').dataTable();
                                        oTable.fnDraw(false);
                                    }
                                    
                                    mostrarSnack("Cuenta eliminada exitosamente.");
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
        $('body').on('click', '.reactivarDirector', function () {
            var director_id = $(this).data("id");
            $.confirm({
                columnClass: 'col-md-6',
                title: "¿Desea reactivar el director?",
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
                                url: rutaReactivar + '/' + director_id,
                                success: function (data) {
                                    if (table.data().count() == 1) {
                                        $('#directoresdt').DataTable().ajax.reload();
                                    } else {
                                        var oTable = $('#directoresdt').dataTable();
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

    });

    /*Accion al presionar el boton crear-director*/
    $('#crear-director').click(function () {
        reiniciar();
        $('#btn-save-director').val("crear-director");
        $('#director_id').val('');
        $('#password_di').attr("placeholder", "Contraseña para el usuario");
        $('#directorForm').trigger("reset");
        $('#directorCrudModal').html("Agregar nueva cuenta de director");
        $('#director-crud-modal').modal({ backdrop: 'static', keyboard: false })
        $('#director-crud-modal').modal('show');

    });

    $("input[name='verCoor']").change(function (e) {
        checkCoord = $(this).val();
        $('#directoresdt').DataTable().ajax.reload();
    });

    /*Accion al presionar el boton save*/
    $("#btn-save-director").click(function () {
        $('.mensajeError').text("");
        $("#btn-save-director").prop("disabled", true);
        $("#btn-close").prop("disabled", true);
        var actionType = $('#btn-save-director').val();
        $('#btn-save-director').html('Guardando..');
        if (actionType == "editar") {
            var id = $('#director_id').val();
            var ruta = rutaBaseDirector+"/" + id + "";
            var datos = new FormData($("#directorForm")[0]);
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
                    $('#directorForm').trigger("reset");
                    $('#director-crud-modal').modal('hide');
                    //recargar serverside
                    var oTable = $('#directoresdt').dataTable();
                    oTable.fnDraw(false);
                    mostrarSnack("Actualización exitosa.");
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    mostrarSnackError('Error al actualizar usuario');
                    if (xhr.status == 422) {
                        
                        var errores = xhr.responseJSON['errors'];
                        $.each(errores, function (key, value) {
                            $('#' + key + "_error").text(value);
                        });
                    }
                    
                },
                complete: function (data) {
                    $(".loader").hide();
                    $('#btn-save-director').html('Guardar');
                    $("#btn-save-director").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                }
            });
        } else if (actionType == "crear-director") {
            $("#btn-save-director").prop("disabled", true);
            $("#btn-close").prop("disabled", true);
            var datos = new FormData($("#directorForm")[0]);
            
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: datos,
                url: rutaBaseDirector,
                type: "POST",
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){
                    $(".loader").show();
                },
                success: function (data) {
                    $('#directorForm').trigger("reset");
                    $('#director-crud-modal').modal('hide');
                    //recargar serverside
                    var oTable = $('#directoresdt').dataTable();
                    oTable.fnDraw(false);
                    
                    mostrarSnack("Director registrado exitosamente.");

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
                    $('#btn-save-director').html('Guardar');
                    $("#btn-save-director").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                }
            });
        }

    })
    
    $('#institucionSelect').change(function () {
        selectIDIns = $(this).find("option:selected").val();
    });

    function reiniciar() {
        $('.mensajeError').text("");
        $('#password_di').val("");
    }
