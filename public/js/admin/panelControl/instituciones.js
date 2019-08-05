    var lati = 24.141474;
    var longi = -110.31314;
    var posInicial = new google.maps.LatLng(lati, longi);

    function iniciarMapa(posicion) {
        mapProp = {
            center: posicion,
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMA
        };
        map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
        marker = new google.maps.Marker({
            position: posicion,
            map: map,
            draggable: true
        });
        google.maps.event.addListener(marker, 'drag', function (event) {
            $('#lat').val(event.latLng.lat());
            $('#lng').val(event.latLng.lng());
        })
        //marker drag event end
        google.maps.event.addListener(marker, 'dragend', function (event) {
            $('#lat').val(event.latLng.lat());
            $('#lng').val(event.latLng.lng());
        });
    }
    google.maps.event.addDomListener(window, 'load', iniciarMapa(posInicial));


    //var SITEURL = "{{URL::to('/')}}";
    var checkInsti = 'activos';

    $(document).ready(function () {
        
        $.extend($.fn.dataTableExt.oStdClasses, {
            "sFilterInput": "busqueda",
            "sLengthSelect": ""
        });

        $('#instituciones tfoot  th.text-input').each(function (i) {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="' + title + '" name="' + i + '" />');
        });

        var table = $('#instituciones').DataTable({
            "order": [
                [4, "desc"]
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
                "url": rutalistIntitucion,
                "data": function (d) {
                    d.busqueda = checkInsti
                }
            },
            "columns": [{
                    data: 'id',
                    name: 'id',
                    'visible': false,
                    searchable: false
                },
                {
                    data: 'nombre',
                    searchable: true
                },
                {
                    data: 'direccion_web',
                    name: 'direccion_web',
                    render: function (data, type, full, meta) {
                        if (data == null)
                            return 'Sin url asignada';
                        else
                            return "<a style='cursor:pointer' target='_blank' href=" + data +
                                ">" + data + "<a/>";
                    },
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'telefono',
                    searchable: true
                },
                {
                    data: 'direccion',
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
                    targets: 5
                },
                {
                    width: 105,
                    targets: 5
                }
            ]
        });



        $("#close-sidebar").click(function () {
            $('.mensajeError').text("");
            $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
        });

        $("#show-sidebar").click(function () {
            $('#instituciones').DataTable().ajax.reload(null, false);
        });



        /*Al presionar el boton editar*/
        $('body').on('click', '.editar', function () {
            reiniciar();
            var institucion_id = $(this).data('id');
            var ruta = rutaBaseIntitucion + "/" + institucion_id + "/editar";
            $.get(ruta, function (data) {
                //ocultar errores
                
                $('#institucionCrudModal').html("Editar institución: " + data.nombre);
                $('#btn-save').val("editar");
                $('#institucion-crud-modal').modal('show');
                $('#institucion_id').val(data.id);
                $('#nombre').val(data.nombre);
                $('#direccion_web').val(data.direccion_web);
                $('#telefono').val(data.telefono);
                $('#ciudad').val(data.ciudad);
                $('#calle').val(data.calle);
                $('#numero').val(data.numero);
                $('#colonia').val(data.colonia);
                $('#siglas').val(data.siglas);
                $('#cp').val(data.cp);
                $('#imglogo').prop('src', rutaLogo + "/" + data.url_logo + '/?'+ $.now());
                $('#logoactual').html('Logo actual');
                lati = data.latitud;
                longi = data.longitud;
                $('#lat').val(data.latitud);
                $('#lng').val(data.longitud);
                var Latlng = new google.maps.LatLng(parseFloat(lati), parseFloat(longi));
                iniciarMapa(Latlng);
                $('#logoAnterior').removeClass('d-none');

            })
        });

        //var info = table.page.info();
        /*Accion al presionar el boton eliminar*/
        $('body').on('click', '.eliminar', function () {
            var institucion_id = $(this).data("id");
            $.confirm({
                columnClass: 'col-md-6',
                title: '¿Desea eliminar la institución?',
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
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                        .attr('content')
                                },
                                type: "DELETE",
                                url: rutaBaseIntitucion + '/' +
                                    institucion_id,
                                success: function (data) {

                                    if (table.data().count() == 1) {
                                        $('#instituciones').DataTable().ajax
                                            .reload();
                                    } else {
                                        var oTable = $('#instituciones')
                                            .dataTable();
                                        oTable.fnDraw(false);
                                    }
                                    mostrarSnack("Institución eliminada exitosamente.");

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
            var institucion_id = $(this).data("id");
            $.confirm({
                columnClass: 'col-md-6',
                title: "¿Desea reactivar la institución?",
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
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                        .attr('content')
                                },
                                type: "PUT",
                                url: rutaReactivar +
                                    '/' + institucion_id,
                                success: function (data) {
                                    if (table.data().count() == 1) {
                                        $('#instituciones').DataTable().ajax
                                            .reload();
                                    } else {
                                        var oTable = $('#instituciones')
                                            .dataTable();
                                        oTable.fnDraw(false);
                                    }
                                    mostrarSnack("Institución activada exitosamente.");
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

    /*Accion al presionar el boton crear-institucion*/
    $('#crear-institucion').click(function () {
        reiniciar();
        $('#btn-save').val("crear-institucion");
        $('#institucion_id').val('');
        $('#institucionForm').trigger("reset");
        $('#institucionCrudModal').html("Agregar nueva institución");
        $('#institucion-crud-modal').modal({
            backdrop: 'static',
            keyboard: false
        })
        $('#institucion-crud-modal').modal('show');
        $('#imglogo').prop('src', "");
        $('#logoactual').html('');
        iniciarMapa(posInicial);
        $('#lat').val(lati);
        $('#lng').val(longi);
        $('#logoAnterior').addClass('d-none');

    });


    $("input[name='verInsti']").change(function (e) {
        checkInsti = $(this).val();
        $('#instituciones').DataTable().ajax.reload();
    });

    /*Accion al presionar el boton save*/
    $("#btn-save").click(function () {
        $('.mensajeError').text("");
        $("#btn-save").prop("disabled", true);
        $("#btn-close").prop("disabled", true);
        var actionType = $('#btn-save').val();
        $('#btn-save').html('Guardando..');
        if (actionType == "editar") {
            var id = $('#institucion_id').val();
            var ruta = rutaBaseIntitucion + "/" + id + "";
            var datos = new FormData($("#institucionForm")[0]);
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
                beforeSend: function(){
                    $(".loader").show();
                },
                success: function (data) {
                    $('#institucionForm').trigger("reset");
                    $('#institucion-crud-modal').modal('hide');
                    
                    //recargar serverside
                    var oTable = $('#instituciones').dataTable();
                    oTable.fnDraw(false);

                    mostrarSnack("Actualización exitosa.");
                    
                    $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
                    $('#nuevoLogo').addClass('d-none');

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    mostrarSnackError('Error al actualizar institución');
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
        } else if (actionType == "crear-institucion") {
            $("#btn-save").prop("disabled", true);
            $("#btn-close").prop("disabled", true);



            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: new FormData($("#institucionForm")[0]),
                url: rutaBaseIntitucion,
                type: "POST",
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){
                    $(".loader").show();
                },
                success: function (data) {
                    $('#institucionForm').trigger("reset");
                    $('#institucion-crud-modal').modal('hide');
                    
                    //recargar serverside
                    var oTable = $('#instituciones').dataTable();
                    oTable.fnDraw(false);
                    mostrarSnack("Institución registrada exitosamente.");
                    
                    $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
                    $('#nuevoLogo').addClass('d-none');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    mostrarSnackError('Error al guardar institución');
                    if (xhr.status == 422) {
                        
                        var errores = xhr.responseJSON['errors'];
                        $.each(errores, function (key, value) {
                            $('#' + key + "_error").text(value);
                        });
                    }
                    //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                  
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

    $('.custom-file-input').on('change', function () {
        let fileName = $(this).val().split('\\').pop();
        if (!fileName.trim()) {
            $(this).next('.custom-file-label').removeClass("selected").html('Ningún archivo seleccionado');
        } else {
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        }
    });

    /*
    function iniciarMapa(posicion){
        mapProp = {
            center: posicion,
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMA
        };
        map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
        marker = new google.maps.Marker({
            position: posicion,
            map: map,
            draggable: true
        });
        
    }

    */
    function mostrar(idMostrar) {
        $('#' + idMostrar).removeClass('d-none');
    }

    function reiniciar() {
        $('#institucionForm').trigger("reset");
        $('.mensajeError').text("");
        $('#vistaPrevia').prop('src', "");
        $('#nuevoLogo').addClass('d-none');
        $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
        //$('.custom-file-label').val("");
        
    }

    $('body').on('click', '#Logo-conacyt', function () {
        reiniciar();
        $('#conacytCrudModal').html("Editar Logo del conacyt");
        $('#btn-save').val("editar");
        $('#Conacy-crud-modal').modal('show');
        

        
    });
    
    $("#guardar-conacyt").click(function(){
        $('.mensajeError').text("");
        var ruta = SITEURL + "/admin/institucion/suibirLogoConacyt";
        var datos = new FormData($("#conacytForm")[0]);
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
                $('#conacytCrudModal').trigger("reset");
                $('#Conacy-crud-modal').modal('hide');
                $('#btn-save').html('Guardar');
                mostrarSnack("Actualización exitosa.");
            },
            error: function (xhr, ajaxOptions, thrownError) {
                if (xhr.status == 422) {
                    var errores = xhr.responseJSON['errors'];
                    $.each(errores, function (key, value) {
                        $('#' + key + "_error").text(value);
                    });
                }
            },
        });
         
    });

