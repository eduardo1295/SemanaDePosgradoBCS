    var checkInsti = 'activos';
    var titulo = "";
    var table = "";
    $(document).ready(function () {
        
          
        $('.note-statusbar').hide();

        $("#show-sidebar").click(function () {
            $('#noticias').DataTable().ajax.reload(null, false);
        });

        $(function () {
            registerSummernote('.summernote', 'Contenido de la noticia', 500, function (max) {
                $('#maxContentPost').text(max)
            });
        });

        $.extend($.fn.dataTableExt.oStdClasses, {
            "sFilterInput": "busqueda",
            "sLengthSelect": ""
        });

        $('#noticias tfoot  th.text-input').each(function (i) {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="' + title + '" name="' + i + '" />');
        });

        table = $('#noticias').DataTable({
            "order": [[ 3, "desc" ]],
            pageLength: 5,
            lengthMenu: [[5, 10, 20, 50], [5, 10, 20, 50]],
            responsive: true,
            autoWidth: false,
            "language": {
                "url": "/js/datatableJS/es.json"
            },
            "processing": true,
            "serverSide": true,
            "search": true,
            "ajax": {
                "url": rutalistNoticia,
                "data": function (d) {
                    d.busqueda = checkInsti
                }
            },
            initComplete: function () {
                var api = this.api();
                api.columns(1).every(function () {
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
                { data: 'titulo',  orderable: false, searchable: true },
                { data: 'resumen',  orderable: false, searchable: true },
                { data: 'fecha_actualizacion', searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            columnDefs: [
                { responsivePriority: 1, targets: 1 },
                { responsivePriority: 2, targets: 4 },
                { width: 105, targets: 4 }
            ]
        });


        $("input[name='verNoti']").change(function (e) {
            checkInsti = $(this).val();
            $('#noticias').DataTable().ajax.reload();
        });

        $('#noticias tbody').on('click', '.eliminar, .reactivar', function (e) {
            var tr = $(this).closest("tr");
            var data = $("#noticias").DataTable().row(tr).data();
            titulo = data.titulo;

        });

    });



    /*Al presionar el boton editar*/
    $('body').on('click', '.editar', function () {
        reiniciar();
        var noticia_id = $(this).data('id');
        var ruta = rutaBaseNoticia +"/" + noticia_id + "/editar";


        $.get(ruta, function (data) {
            $('#noticiaCrudModal').html("Editar noticia: " + data.titulo);
            $('#btn-save').val("editar");
            $('#noticia-crud-modal').modal('show');
            $('#noticia_id').val(data.id_noticia);
            $('#titulo').val(data.titulo);
            $('#resumen').val(data.resumen);

            $('#contenido').summernote('code', data.contenido);
        })
    });


    /*Accion al presionar el boton crear-noticia*/
    $('#crear-noticia').click(function () {
        reiniciar();
        $('#btn-save').val("crear-noticia");
        $('#noticia_id').val('');
        $('#noticiaForm').trigger("reset");
        $('#noticiaCrudModal').html("Agregar nueva noticia");
        $('#noticia-crud-modal').modal({ backdrop: 'static', keyboard: false })
        $('#noticia-crud-modal').modal('show');
    });

    $('.modal-btn').click(function () {
        $('#btn-save').val("crear-noticia");
        $('#noticia_id').val('');
        $('#noticiaForm').trigger("reset");
        $('#noticiaCrudModal').html("Agregar nueva institución");
        $('#noticia-crud-modal').modal({ backdrop: 'static', keyboard: false })
        $('#noticia-crud-modal').modal('show');
    });


    /*Accion al presionar el boton save*/
    $("#btn-save").click(function () {
        $('.mensajeError').text("");
        $("#btn-save").prop("disabled", true);
        $("#btn-close").prop("disabled", true);
        var actionType = $('#btn-save').val();
        $('#btn-save').html('Guardando..');
        if (actionType == "editar") {
            var id = $('#noticia_id').val();
            var ruta = rutaBaseNoticia + "/" + id + "";
            var datos = new FormData($("#noticiaForm")[0]);
            datos.append('_method', 'PUT');
            //console.log(Array.from(datos));
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
                    //console.log(data);
                    $('#noticiaForm').trigger("reset");
                    $('#noticia-crud-modal').modal('hide');
                    $('#btn-save').html('Guardar');
                    //recargar serverside
                    var oTable = $('#noticias').dataTable();
                    oTable.fnDraw(false);
                    //recargar sin serverside
                    
                    mostrarSnack("Actualización exitosa.");
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                    $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');

                },
                error: function (data) {
                    mostrarSnackError('Error al actualizar noticia');
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
        } else if (actionType == "crear-noticia") {
            $("#btn-save").prop("disabled", true);
            $("#btn-close").prop("disabled", true);

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: new FormData($("#noticiaForm")[0]),
                url: rutaBaseNoticia,
                type: "POST",
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $('#noticiaForm').trigger("reset");
                    $('#noticia-crud-modal').modal('hide');
                    $('#btn-save').html('Guardar');
                    //recargar serverside
                    var oTable = $('#noticias').dataTable();
                    oTable.fnDraw(false);
                    //recargar sin serverside
                    mostrarSnack("Noticia guardada exitosamente.");;
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                    $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
                },
                error: function (data) {
                    mostrarSnackError('Error al guardar noticia');
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
        var noticia_id = $(this).data("id");
        $.confirm({
            columnClass: 'col-md-6',
            title: '¿Desea eliminar la noticia titulada ' + titulo + '?',
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
                            url: rutaBaseNoticia + '/' + noticia_id,
                            success: function (data) {
                                var oTable = $('#noticias').dataTable();
                                if (table.data().count() == 1) {
                                    $('#noticias').DataTable().ajax.reload();
                                } else {

                                    oTable.fnDraw(false);
                                }
                                mostrarSnack("Noticia eliminada exitosamente.");
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
        var noticia_id = $(this).data("id");
        $.confirm({
            columnClass: 'col-md-6',
            title: '¿Desea reactivar la noticia titulada ' + titulo + '?',
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
                            url: "{{ url('admin/noticias/reactivar')}}" + '/' + noticia_id,
                            success: function (data) {
                                var oTable = $('#noticias').dataTable();
                                if (table.data().count() == 1) {
                                    $('#noticias').DataTable().ajax.reload();
                                } else {

                                    oTable.fnDraw(false);
                                }
                                mostrarSnack("Noticia activada exitosamente.");
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

    $('.preview-btn').on('click', function (e) {

        e.preventDefault();
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: new FormData($("#noticiaForm")[0]),
            url: rutaVistaPrevia,
            type: "POST",
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                win = window.open("", "_blank");
                win.document.write(data);
                win.document.close();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            },


        });
    });

    function reiniciar() {
        $('.mensajeError').text("");
        $('#contenido').summernote("reset");
        $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
    }