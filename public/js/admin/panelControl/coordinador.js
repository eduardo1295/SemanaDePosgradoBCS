    var SITEURL = "{{URL::to('/')}}";
    var checkCoord = 'activos';
    var selectIDIns= "";
    $(document).ready(function () {
        
        $.extend($.fn.dataTableExt.oStdClasses, {
            "sFilterInput": "busqueda",
            "sLengthSelect": ""
        });

        $('#coordinadoresdt tfoot  th.text-input').each(function (i) {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="' + title + '" name="' + i + '" />');
        });

        var table = $('#coordinadoresdt').DataTable({
            "order": [[ 7, "desc" ]],
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
                "url": rutalistCoordinador,
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
                { data: 'coordinadores.puesto', searchable: false },
                { data: 'email', searchable: true },
                { data: 'instituciones.nombre', searchable: true },
                { data: 'fecha_actualizacion', searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            columnDefs: [
                { responsivePriority: 1, targets: 1 },
                { responsivePriority: 2, targets: 8 },
                { width: 105, targets: 8 }
            ]
        });



        $("#close-sidebar").click(function () {
            $('.mensajeError').text("");
            
        });

        $("#show-sidebar").click(function () {
            $('#coordinadoresdt').DataTable().ajax.reload(null, false);
        });



        /*Al presionar el boton editar*/
        $('body').on('click', '.editar', function () {
            reiniciar();
            var coordinador_id = $(this).data('id');
            var ruta = rutaBaseCoordinador + "/" + coordinador_id + "/editar";
            $.get(ruta, function (data) {
                //ocultar errores
                $('#password').attr("placeholder", "Nueva contraseña");
                $('#coordinadorCrudModal').html("Editar coordinador:" + data.nombre);
                $('#btn-save').val("editar");
                $('#coordinador-crud-modal').modal('show');
                console.log(data);
                $('#coordinador_id').val(data.id);
                $('#puesto').val(data.coordinadores.puesto);
                $('#institucion').val(data.institucion);
                $('#nombre').val(data.nombre);
                $('#primer_apellido').val(data.primer_apellido);
                $('#segundo_apellido').val(data.segundo_apellido);
                $('#email').val(data.email);
                $("#institucionSelect").val(data.instituciones.id);
                

            })
        });

        //var info = table.page.info();
        /*Accion al presionar el boton eliminar*/
        $('body').on('click', '.eliminar', function () {
            var coordinador_id = $(this).data("id");
            $.confirm({
                columnClass: 'col-md-6',
                title: '¿Desea eliminar el coordinador?',
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
                                url: rutaBaseCoordinador + '/' + coordinador_id,
                                success: function (data) {

                                    if (table.data().count() == 1) {
                                        $('#coordinadoresdt').DataTable().ajax.reload();
                                    } else {
                                        var oTable = $('#coordinadoresdt').dataTable();
                                        oTable.fnDraw(false);
                                    }
                                    
                                    mostrarSnack("Cuenta eliminada exitosamente.");
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
        $('body').on('click', '.reactivar', function () {
            var coordinador_id = $(this).data("id");
            $.confirm({
                columnClass: 'col-md-6',
                title: "¿Desea reactivar el coordinador?",
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
                                url: rutaReactivar + '/' + coordinador_id,
                                success: function (data) {
                                    if (table.data().count() == 1) {
                                        $('#coordinadoresdt').DataTable().ajax.reload();
                                    } else {
                                        var oTable = $('#coordinadoresdt').dataTable();
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

    /*Accion al presionar el boton crear-coordinador*/
    $('#crear-coordinador').click(function () {
        reiniciar();
        $('#btn-save').val("crear-coordinador");
        $('#coordinador_id').val('');
        $('#password').attr("placeholder", "Contraseña para el usuario");
        $('#coordinadorForm').trigger("reset");
        $('#coordinadorCrudModal').html("Agregar nueva cuenta de coordinador");
        $('#coordinador-crud-modal').modal({ backdrop: 'static', keyboard: false })
        $('#coordinador-crud-modal').modal('show');

    });

    $('#btn-close').click(function () {
        $('.mensajeError').text("");
    })

    $("input[name='verCoor']").change(function (e) {
        checkCoord = $(this).val();
        $('#coordinadoresdt').DataTable().ajax.reload();
    });

    /*Accion al presionar el boton save*/
    $("#btn-save").click(function () {
        $('.mensajeError').text("");
        $("#btn-save").prop("disabled", true);
        $("#btn-close").prop("disabled", true);
        var actionType = $('#btn-save').val();
        $('#btn-save').html('Guardando..');
        if (actionType == "editar") {
            var id = $('#coordinador_id').val();
            var ruta = rutaBaseCoordinador + "/" + id + "";
            var datos = new FormData($("#coordinadorForm")[0]);
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
                    $('#coordinadorForm').trigger("reset");
                    $('#coordinador-crud-modal').modal('hide');
                    $('#btn-save').html('Guardar');
                    //recargar serverside
                    var oTable = $('#coordinadoresdt').dataTable();
                    oTable.fnDraw(false);
                    
                    mostrarSnack("Actualización exitosa.");

                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                    console.log(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    if (xhr.status == 422) {
                        
                        var errores = xhr.responseJSON['errors'];
                        $.each(errores, function (key, value) {
                            $('#' + key + "_error").text(value);
                        });
                    }
                    $('#btn-save').html('Guardar');
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                },
                complete: function (data) {
                    $(".loader").hide();
                    $('#btn-save').html('Guardar');
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                }
            });
        } else if (actionType == "crear-coordinador") {
            $("#btn-save").prop("disabled", true);
            $("#btn-close").prop("disabled", true);
            var datos = new FormData($("#coordinadorForm")[0]);
            //datos.append('id_institucion', $('#institucionSelect').find("option:selected").val());
            console.log(Array.from(datos));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: datos,
                url: rutaBaseCoordinador,
                type: "POST",
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){
                    $(".loader").show();
                },
                success: function (data) {
                    $('#coordinadorForm').trigger("reset");
                    $('#coordinador-crud-modal').modal('hide');
                    //recargar serverside
                    var oTable = $('#coordinadoresdt').dataTable();
                    oTable.fnDraw(false);
                    
                    mostrarSnack("Coordinador registrado exitosamente.");
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    if (xhr.status == 422) {
                        
                        var errores = xhr.responseJSON['errors'];
                        $.each(errores, function (key, value) {
                            $('#' + key + "_error").text(value);
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

    })
    
    $('#institucionSelect').change(function () {
        selectIDIns = $(this).find("option:selected").val();
    });

    
    

    function reiniciar() {
        $('.mensajeError').text("");
    }

