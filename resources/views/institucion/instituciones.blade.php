@extends('admin.plantilla')
@section('contenido')


<div class="container-fluid" id="#contenedor">
    <div class="row">
        <div class="col-12 mx-auto">
            <h1>
                Instituciones registradas
            </h1>
        </div>

        <div id="mensaje-acciones" class="col-12 alert alert-success alert-dismissible" role="alert"
            style="display:none">
            <strong> </strong>
        </div>
    </div>
    <div class="row mb-2">
        <legend class="col-form-label col-12 col-md-2 col-lg-2 pt-0">Mostras instituciones</legend>
        <div class="col-12 col-md-4 col-lg-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio1" checked name="verInsti" value="activos">
                <label class="form-check-label" for="inlineRadio1">Activas</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio2" name="verInsti" value="eliminados">
                <label class="form-check-label" for="inlineRadio2">Eliminadas</label>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-6">
            <div class="d-flex justify-content-end">
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="crear-institucion"><span><i
                            class="fas fa-plus"></i></span> Nueva Institución</a>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="display" cellspacing="0" style="width:100%" id="instituciones">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nombre</th>
                        <th>Direccion Web</th>
                        <th>Telefono</th>
                        <th id="lad">Última actualización</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th class="text-input">Direccion Web</th>
                        <th></th>
                        <th></th>
                        <th></th>

                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    
</div>


@endsection
@section('extra')
@include('institucion.modal')
<div id="snackbar"></div>
@endsection
@section('scripts')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&amp;sensor=false"></script>
<script src="/js/imagenes/vistaprevia.js"></script>
<script src="/js/snack/snack.js"></script>

<script>
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


    var SITEURL = "{{URL::to('/')}}";
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
                "url": '{{ route("institucion.listInstituciones")}}',
                "data": function (d) {
                    d.busqueda = checkInsti
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
                { data: 'direccion_web', searchable: true },
                { data: 'telefono', searchable: true },
                { data: 'direccion', searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            columnDefs: [
                { responsivePriority: 1, targets: 1 },
                { responsivePriority: 2, targets: 5 },
                { width: 105, targets: 5 }
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
            var ruta = "{{url('institucion')}}/" + institucion_id + "/editar";
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
                $('#cp').val(data.cp);
                $('#imglogo').prop('src', "{{url('img/logo')}}/" + data.url_logo);
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
                                url: "{{ url('institucion')}}" + '/' + institucion_id,
                                success: function (data) {

                                    if (table.data().count() == 1) {
                                        $('#instituciones').DataTable().ajax.reload();
                                    } else {
                                        var oTable = $('#instituciones').dataTable();
                                        oTable.fnDraw(false);
                                    }
                                    mostrarSnack("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Institución eliminada exitosamente.");
                                    
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
                                url: "{{ url('admin/institucion/reactivar')}}" + '/' + institucion_id,
                                success: function (data) {
                                    if (table.data().count() == 1) {
                                        $('#instituciones').DataTable().ajax.reload();
                                    } else {
                                        var oTable = $('#instituciones').dataTable();
                                        oTable.fnDraw(false);
                                    }
                                    mostrarSnack("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Institución activada exitosamente.");
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
        $('#institucion-crud-modal').modal({ backdrop: 'static', keyboard: false })
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
        
        $("#btn-save").prop("disabled", true);
        $("#btn-close").prop("disabled", true);
        var actionType = $('#btn-save').val();
        $('#btn-save').html('Guardando..');
        if (actionType == "editar") {
            var id = $('#institucion_id').val();
            var ruta = "{{url('institucion')}}/" + id + "";
            var datos = new FormData($("#institucionForm")[0]);
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
                    $('#institucionForm').trigger("reset");
                    $('#institucion-crud-modal').modal('hide');
                    $('#btn-save').html('Guardar');
                    //recargar serverside
                    var oTable = $('#instituciones').dataTable();
                    oTable.fnDraw(false);
                    
                    mostrarSnack("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Actualización exitosa.");
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                    $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
                    $('#nuevoLogo').addClass('d-none');

                },
                error: function (data) {
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
        } else if (actionType == "crear-institucion") {
            $("#btn-save").prop("disabled", true);
            $("#btn-close").prop("disabled", true);



            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: new FormData($("#institucionForm")[0]),
                url: "{{route('institucion.store')}}",
                type: "POST",
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $('#institucionForm').trigger("reset");
                    $('#institucion-crud-modal').modal('hide');
                    $('#btn-save').html('Guardar');
                    //recargar serverside
                    var oTable = $('#instituciones').dataTable();
                    oTable.fnDraw(false);
                    mostrarSnack("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Institución registrada exitosamente.");
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                    $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
                    $('#nuevoLogo').addClass('d-none');
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
        $('.mensajeError').text("");
        $('#vistaPrevia').prop('src', "");
        $('#nuevoLogo').addClass('d-none');
        $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
    }
</script>
@endsection

@section('estilos')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="/css/datatable/colores.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
<link href="/css/modales/modalresponsivo.css" rel="stylesheet">
<link href="/css/modales/snackbar.css" rel="stylesheet">

<style>
    .custom-file-input~.custom-file-label::after {
        content: "Elegir";
    }
</style>

@endsection