    
    var checkInsti = 'activos';
    $(document).ready(function () {

        $.extend($.fn.dataTableExt.oStdClasses, {
            "sFilterInput": "busqueda",
            "sLengthSelect": ""
        });


        var table = $('#slidersC').DataTable({
            "order": [[ 3, "desc" ]],
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
                "url": rutalistCarrusel ,
                "data": function (d) {
                    d.busqueda = checkInsti
                }
            },
            "columns": [
                { data: 'id', name: 'id', 'visible': false,searchable: false },
                {
                    data: 'url_imagen',
                    name: 'url_imagen',
                    render: function (data, type, full, meta) {
                        return "<img src="+SITEURL+"/img/carrusel/" + data + " width='250px'  class='img-thumbnail imgmodal' onclick='mostrarModal(this);' />";
                    },
                    orderable: false, searchable: false
                },
                {
                    data: 'link_web',
                    name: 'link_web',
                    render: function (data, type, full, meta) {
                        if (data == null)
                            return 'Sin url asignada';
                        else
                            return "<a style='cursor:pointer' target='_blank' href=" +data + ">" + data + "<a/>";
                    },
                    orderable: false, searchable: false
                },
                { data: 'fecha_actualizacion', searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            columnDefs: [
                { responsivePriority: 1, targets: 1 },
                { responsivePriority: 2, targets: 4 },
                { width: 250, targets: 2 },
                { width: 105, targets: 4 }
            ]
        });



        $("#close-sidebar").click(function () {
            $('.mensajeError').text("");
            $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
        });

        $("#show-sidebar").click(function () {
            $('#slidersC').DataTable().ajax.reload(null, false);
        });



        /*Al presionar el boton editar*/
        $('body').on('click', '.editar', function () {
            var carrusel_id = $(this).data('id');
            var ruta = rutaBaseCarrusel +"/" + carrusel_id + "/editar";
            $.get(ruta, function (data) {
                //ocultar errores
                $('#carruselCrudModal').html("Editar imagen");
                $('#btn-save').val("editar");
                $('#carrusel-crud-modal').modal('show');
                
                $('#carrusel_id').val(data.id);
                $('#link_web').val(data.link_web);
                
                $('#imgslide').prop('src', baseImagenes + "/" + data.url_imagen);
                $('#imagenactualT').html('Imagen actual');
                $('#imagenAnterior').removeClass('d-none');

            })
        });

        //var info = table.page.info();
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
                                url: rutaBaseCarrusel + '/' + carrusel_id,
                                success: function (data) {

                                    if (table.data().count() == 1) {
                                        $('#slidersC').DataTable().ajax.reload();
                                    } else {
                                        var oTable = $('#slidersC').dataTable();
                                        oTable.fnDraw(false);
                                    }
                                    mostrarSnack("Imagen eliminada exitosamente.");
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
            var carrusel_id = $(this).data("id");
            $.confirm({
                columnClass: 'col-md-6',
                title: "¿Desea reactivar la imagen?",
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
                                url: rutaBaseCarrusel + '/' + carrusel_id,
                                success: function (data) {
                                    if (table.data().count() == 1) {
                                        $('#slidersC').DataTable().ajax.reload();
                                    } else {
                                        var oTable = $('#slidersC').dataTable();
                                        oTable.fnDraw(false);
                                    }
                                    
                                    mostrarSnack("Imagen activada exitosamente.");
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

    /*Accion al presionar el boton crear-carrusel*/
    $('#crear-carrusel').click(function () {
        $('#btn-save').val("crear-carrusel");
        $('#carrusel_id').val('');
        $('#carruselForm').trigger("reset");
        $('#carruselCrudModal').html("Agregar nueva imagen");
        $('#carrusel-crud-modal').modal({ backdrop: 'static', keyboard: false })
        $('#carrusel-crud-modal').modal('show');
        $('#imgslide').prop('src', "");
        $('#imagenactualT').html('');
        $('#imagenactual').addClass('d-none');

    });

    $('#btn-close').click(function () {
        $('.mensajeError').text("");
        $('#vistaPrevia').prop('src', "");
        $('#nuevaImagen').addClass('d-none');
        $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
    })

    $("input[name='verInsti']").change(function (e) {
        checkInsti = $(this).val();
        $('#slidersC').DataTable().ajax.reload();
    });

    /*Accion al presionar el boton save*/
    $("#btn-save").click(function () {
        $("#btn-save").prop("disabled", true);
        $("#btn-close").prop("disabled", true);
        var actionType = $('#btn-save').val();
        $('#btn-save').html('Guardando..');
        if (actionType == "editar") {
            var id = $('#carrusel_id').val();
            var ruta = rutaBaseCarrusel + "/" + id + "";
            var datos = new FormData($("#carruselForm")[0]);
            datos.append('_method', 'PUT');
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
                    $('#carruselForm').trigger("reset");
                    $('#carrusel-crud-modal').modal('hide');
                    $('#btn-save').html('Guardar');
                    //recargar serverside
                    var oTable = $('#slidersC').dataTable();
                    oTable.fnDraw(false);
                    
                    mostrarSnack("Actualización exitosa.");

                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                    $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
                    $('#nuevaImagen').addClass('d-none');
                    $('#vistaPrevia').prop('src', "");
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
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

            });
        } else if (actionType == "crear-carrusel") {
            $("#btn-save").prop("disabled", true);
            $("#btn-close").prop("disabled", true);



            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: new FormData($("#carruselForm")[0]),
                url: rutaBaseCarrusel,
                type: "POST",
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $('#carruselForm').trigger("reset");
                    $('#carrusel-crud-modal').modal('hide');
                    $('#btn-save').html('Guardar');
                    //recargar serverside
                    var oTable = $('#slidersC').dataTable();
                    oTable.fnDraw(false);
                    
                    mostrarSnack("Imagen guardada exitosamente.");

                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                    $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
                    $('#nuevaImagen').addClass('d-none');
                    $('#vistaPrevia').prop('src', "");
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    $('#btn-save').html('Guardar');
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                },


            });
        }

    })

    $('.custom-file-input').on('change', function () {
        let fileName = $(this).val().split('\\').pop();
        if (!fileName.trim()) {
            $(this).next('.custom-file-label').removeClass("selected").html('Ningún archivo seleccionado');
        } else {
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        }
    })
    function mostrarModal(imagenMini){
        $('#img01').prop('src',imagenMini.src);
        $('#modalImagenes').css('display','block');
    }
    function cerrarModal(){
        $('#modalImagenes').css('display','none');
    }

    $('#modalImagenes').on('click',function(){
        $('#modalImagenes').css('display','none');
    })
