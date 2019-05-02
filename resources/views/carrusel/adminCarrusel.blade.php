@extends('admin.plantilla')
@section('contenido')


<div class="container-fluid" id="#contenedor">
    <div class="row">
        <div class="col-12 mx-auto">
            <h1>
                Imagenes en carrusel
            </h1>
        </div>

        <div id="mensaje-acciones" class="col-12 alert alert-success alert-dismissible" role="alert"
            style="display:none">
            <strong> </strong>
        </div>
    </div>
    <div class="row mb-2">
        <legend class="col-form-label col-12 col-md-2 col-lg-2 pt-0">Mostras carrusel</legend>
        <div class="col-12 col-md-4 col-lg-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio1" checked name="verSlider" value="activos">
                <label class="form-check-label" for="inlineRadio1">Activas</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio2" name="verSlider" value="eliminados">
                <label class="form-check-label" for="inlineRadio2">Eliminadas</label>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-6">
            <div class="d-flex justify-content-end">
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="crear-carrusel"><span><i
                            class="fas fa-plus"></i></span> Nueva Imagen</a>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="display" cellspacing="0" style="width:100%" id="carruselLista">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Titulo</th>
                        <th>Imagen</th>
                        <th id="lad">Última actualización</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>

                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div id="snackbar"></div>
</div>


@endsection
@section('extra')
@include('carrusel.modal')
@endsection
@section('scripts')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>

<script src="/js/imagenes/vistaprevia.js"></script>

<script>

    var SITEURL = "{{URL::to('/')}}";
    var checkSlide = 'activos';
    
    $(document).ready(function () {

        $.extend($.fn.dataTableExt.oStdClasses, {
            "sFilterInput": "busqueda",
            "sLengthSelect": ""
        });

        $('#carruselLista tfoot  th.text-input').each(function (i) {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="' + title + '" name="' + i + '" />');
        });

        var table = $('#carruselLista').DataTable({
            pageLength: 5,
            lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']],
            responsive: true,
            autoWidth: false,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "processing": true,
            "serverSide": true,
            "search": true,
            "ajax": {
                "url": '{{ route("carrusel.listcarrusel")}}',
                "data": function (d) {
                    d.busqueda = checkSlide
                }
            },
            "columns": [
                { data: 'id', name: 'id', 'visible': false },
                { data: 'titulo', searchable: true },
                { data: 'url_imagen', searchable: false },
                { data: 'fecha_actualizacion', searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            columnDefs: [
                { responsivePriority: 1, targets: 1 },
                { responsivePriority: 2, targets: 3 },
                { width: 105, targets: 3 }
            ]
        });



        $("#close-sidebar").click(function () {
            $('.mensajeError').text("");
            $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
        });

        $("#show-sidebar").click(function () {
            $('#carruselLista').DataTable().ajax.reload(null, false);
        });



        /*Al presionar el boton editar*/
        $('body').on('click', '.editar', function () {
            var carrusel_id = $(this).data('id');
            var ruta = "{{url('carrusel')}}/" + carrusel_id + "/editar";
            $.get(ruta, function (data) {
                //ocultar errores
                $('#carruselCrudModal').html("Editar imagen: " + data.nombre);
                $('#btn-save').val("editar");
                $('#carrusel-crud-modal').modal('show');
                $('#carrusel_id').val(data.id);
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
                $('#logoAnterior').removeClass('d-none');

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
                                url: "{{ url('carrusel')}}" + '/' + carrusel_id,
                                success: function (data) {

                                    if (table.data().count() == 1) {
                                        $('#carruselLista').DataTable().ajax.reload();
                                    } else {
                                        var oTable = $('#carruselLista').dataTable();
                                        oTable.fnDraw(false);
                                    }
                                    //$("#mensaje-acciones").text("Institución eliminada exitosamente.");
                                    //$("#mensaje-acciones").fadeIn();
                                    //$('#mensaje-acciones').delay(3000).fadeOut();
                                    //$('#mensaje-acciones').addClass('alert-warning');
                                    //$('#mensaje-acciones').removeClass('alert-success');

                                    //$('#carruselLista').DataTable().ajax.reload(null, false);
                                    //$('#carruselLista').DataTable().ajax.reload();
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
                content: 'This dialog will automatically trigger \'cancel\' in 8 seconds if you don\'t respond.',
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
                                url: "{{ url('admin/carrusel/reactivar')}}" + '/' + carrusel_id,
                                success: function (data) {
                                    if (table.data().count() == 1) {
                                        $('#carruselLista').DataTable().ajax.reload();
                                    } else {
                                        var oTable = $('#carruselLista').dataTable();
                                        oTable.fnDraw(false);
                                    }
                                    //$("#mensaje-acciones").text("Institución activada exitosamente.");
                                    //$("#mensaje-acciones").fadeIn();
                                    //$('#mensaje-acciones').delay(3000).fadeOut();
                                    //$('#mensaje-acciones').addClass('alert-warning');
                                    //$('#mensaje-acciones').removeClass('alert-success');
                                    //$('#carruselLista').DataTable().ajax.reload(null, false);
                                    //$('#carruselLista').DataTable().ajax.reload();
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
        $('#imglogo').prop('src', "");
        $('#logoactual').html('');
        
        $('#logoAnterior').addClass('d-none');

    });

    $('#btn-close').click(function () {
        $('.mensajeError').text("");
        $('#vistaPrevia').prop('src', "");
        $('#nuevoLogo').addClass('d-none');
        $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
    })

    $("input[name='verSlider']").change(function (e) {
        checkSlide = $(this).val();
        $('#carruselLista').DataTable().ajax.reload();
    });
    
    /*Accion al presionar el boton save*/
    $("#btn-save").click(function () {
        $("#btn-save").prop("disabled", true);
        $("#btn-close").prop("disabled", true);
        var actionType = $('#btn-save').val();
        $('#btn-save').html('Guardando..');
        if (actionType == "editar") {
            var id = $('#carrusel_id').val();
            var ruta = "{{url('carrusel')}}/" + id + "";
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
                    var oTable = $('#carruselLista').dataTable();
                    oTable.fnDraw(false);
                    //$("#mensaje-acciones").text("Actualización exitosa.");
                    //var x = document.getElementById("snackbar");
                    //x.html("Actualización exitosa.");
                    //x.className = "show";
                    $("#snackbar").html("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Actualización exitosa.");
                    $("#snackbar").addClass("show");
                    setTimeout(function(){ $("#snackbar").removeClass("show"); }, 5000);

                    //$("#mensaje-acciones").fadeIn();
                    //$('#mensaje-acciones').delay(3000).fadeOut();
                    //$('#mensaje-acciones').addClass('alert-success');
                    //$('#mensaje-acciones').removeClass('alert-warning');
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
        } else if (actionType == "crear-carrusel") {
            $("#btn-save").prop("disabled", true);
            $("#btn-close").prop("disabled", true);



            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: new FormData($("#carruselForm")[0]),
                url: "{{route('carrusel.store')}}",
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
                    var oTable = $('#carruselLista').dataTable();
                    oTable.fnDraw(false);
                    //$("#mensaje-acciones").text("Institución registrada exitosamente.");
                    //$("#mensaje-acciones").fadeIn();
                    //$('#mensaje-acciones').delay(3000).fadeOut();
                    //$('#mensaje-acciones').addClass('alert-success');
                    //$('#mensaje-acciones').removeClass('alert-warning');
                    $("#snackbar").html("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Imagen guardada exitosamente.");
                    $("#snackbar").addClass("show");
                    setTimeout(function(){ $("#snackbar").removeClass("show"); }, 5000);
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
    
    function mostrar(idMostrar) {
        $('#' + idMostrar).removeClass('d-none');
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