var lati = 24.141474;
var longi = -110.31314; 

var posInicial = new google.maps.LatLng(lati,longi);

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
    
function cargarInstitucion(){
    //var ruta = "{{url('institucion')}}/" + "{{ auth()->user()->id_institucion }}" + "/editar";
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: rutaEditarInstitucion,
        type: "GET",
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function(){
            $(".loader").show();
        },
        success: function (data) {
            $('#nombre').val(data.nombre);
            $('#direccion_web').val(data.direccion_web);
            $('#telefono').val(data.telefono);
            $('#ciudad').val(data.ciudad);
            $('#calle').val(data.calle);
            $('#numero').val(data.numero);
            $('#colonia').val(data.colonia);
            $('#siglas').val(data.siglas);
            $('#cp').val(data.cp);
            $('#imglogo').prop('src', imagenRuta +'/'+ data.url_logo);
            $('#logoactual').html('Logo actual');
            lati = data.latitud;
            longi = data.longitud;
            $('#lat').val(data.latitud);
            $('#lng').val(data.longitud);
            var Latlng = new google.maps.LatLng(parseFloat(lati), parseFloat(longi));
            iniciarMapa(Latlng);
            $('#logoAnterior').removeClass('d-none');
        },
        error: function (data) {
            
        },
        complete: function (data) {
            $(".loader").hide();
        }

    });

}

$(document).ready(function () {
    
});

function cargarDataTableDirectores(){
    if(!table){
        table = $('#directoresdt').DataTable({
            "order": [[ 5, "desc" ]],
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
                "url": rutaBaseDirector + '/' + 'listDirector',
                "data": function (d) {
                    d.busqueda = checkDir
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
                { data: 'fecha_usuario', searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            columnDefs: [
                { responsivePriority: 1, targets: 2 },
                { responsivePriority: 2, targets: 6 },
                { width: 105, targets: 6 }
            ]
        });
    }else{
        $('#directoresdt').DataTable().ajax.reload();
    }
    
}


$("input[name='verDir']").change(function (e) {
    checkDir = $(this).val();
    $('#directoresdt').DataTable().ajax.reload();
});

        /*Al presionar el boton editar*/
        $('body').on('click', '.editarDirector', function () {
            reiniciarDirector();
            var director_id = $(this).data('id');
            var ruta = rutaBaseDirector + '/' + director_id + "/editar";
            $.get(ruta, function (data) {
                //ocultar errores
                console.log(data);
                $('#password_di').val("");
                $('#password').attr("placeholder", "Nueva contraseña");
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
                                url: rutaBaseDirector + '/reactivar/' + director_id,
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

        function reiniciarDirector() {
            $('.mensajeError').text("");
        }

    /*Accion al presionar el boton save*/
    $("#btn-save-director").click(function () {
        reiniciarDirector();
        $("#btn-save-director").prop("disabled", true);
        $("#btn-close").prop("disabled", true);
        var actionType = $('#btn-save-director').val();
        $('#btn-save-director').html('Guardando..');
        if (actionType == "editar") {
            var id = $('#director_id').val();
            var ruta = rutaBaseDirector+'/' + id;
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
                success: function (data) {
                    $('#directorForm').trigger("reset");
                    $('#director-crud-modal').modal('hide');
                    $('#btn-save-director').html('Guardar');
                    //recargar serverside
                    var oTable = $('#directoresdt').dataTable();
                    oTable.fnDraw(false);
                    
                    
                    
                    mostrarSnack("Actualización exitosa.");
                    $("#btn-save-director").prop("disabled", false);
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
                    $('#btn-save-director').html('Guardar');
                    $("#btn-save-director").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                },

            });
        } else if (actionType == "crear-director") {
            $("#btn-save-director").prop("disabled", true);
            $("#btn-close").prop("disabled", true);
            var datos = new FormData($("#directorForm")[0]);
            //datos.append('id_institucion', $('#institucionSelect').find("option:selected").val());
            console.log(Array.from(datos));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: datos,
                url: rutaBaseDirector,
                type: "POST",
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $('#directorForm').trigger("reset");
                    $('#director-crud-modal').modal('hide');
                    $('#btn-save-director').html('Guardar');
                    //recargar serverside
                    var oTable = $('#directoresdt').dataTable();
                    oTable.fnDraw(false);
                    mostrarSnack("Director de tesis registrado exitosamente.");
                    $("#btn-save-director").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    if (xhr.status == 422) {
                        
                        var errores = xhr.responseJSON['errors'];
                        $.each(errores, function (key, value) {
                            $('#' + key + "_error").text(value);
                        });
                    }
                    $('#btn-save-director').html('Guardar');
                    $("#btn-save-director").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                },


            });
        }

    })

    /*Accion al presionar el boton crear-director*/
    $('#crear-director').click(function () {
        
        $('#password_di').val("");
        reiniciarDirector();
        $('#btn-save-director').val("crear-director");
        $('#director_id').val('');
        $('#password').attr("placeholder", "Contraseña para el usuario");
        $('#directorForm').trigger("reset");
        $('#directorCrudModal').html("Agregar nueva cuenta de director");
        $('#director-crud-modal').modal({ backdrop: 'static', keyboard: false })
        $('#director-crud-modal').modal('show');

    });



    /*Al presionar el boton editar*/
    $('body').on('click', '.guardarInstitucion', function () {
            $('.mensajeError').text("");
            var id = $('#institucion_id').val();
            var ruta = rutaBaseInstitucion;
            var datos = new FormData($("#institucionForm")[0]);
            datos.append('_method', 'PUT');
            console.log(Array.from(datos));
            $("#guardarInstitucion").prop("disabled", true);
            $('#guardarInstitucion').html('Guardando..');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: ruta + '/' + id,
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
                    mostrarSnack("Actualización exitosa.");
                    $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
                    $('#nuevoLogo').addClass('d-none');
                    var unique = $.now();
                    $('#imglogo').prop('src', imagenRuta + '/' + data.url_logo + '/?' + unique);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if (xhr.status == 422) {
                        var errores = xhr.responseJSON['errors'];
                        $.each(errores, function (key, value) {
                            $('#' + key + "_error").text(value);
                        });
                    }
                },
                complete: function (data) {
                    $(".loader").hide();
                    $('#guardarInstitucion').html('Guardar');
                    $('#guardarInstitucion').prop("disabled", false);
                }
            });
    });

    $('.custom-file-input').on('change', function () {
        let fileName = $(this).val().split('\\').pop();
        if (!fileName.trim()) {
            $(this).next('.custom-file-label').removeClass("selected").html('Ningún archivo seleccionado');
        } else {
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        }
    })


    