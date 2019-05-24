@extends('admin.plantilla')
@section('contenido')


<div class="container-fluid" id="#contenedor">
    <div class="row">
        <div class="col-12 mx-auto">
            <h1>
                Programas
            </h1>
        </div>

        <div id="mensaje-acciones" class="col-12 alert alert-success alert-dismissible" role="alert"
            style="display:none">
            <strong> </strong>
        </div>
    </div>
    <div class="row mb-2">
        <legend class="col-form-label col-12 col-md-2 col-lg-2 pt-0">Mostras Programas</legend>
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
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="crear-programa"><span><i
                            class="fas fa-plus"></i></span> Nuevo Programa</a>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="display" cellspacing="0" style="width:100%" id="slidersC">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Clave Programa</th>
                        <th>Nombre</th>
                        <th>Nivel</th>
                        <th>Periodo</th>
                        <th>Institucion</th>
                        <th>Última actualización</th>
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
@include('programa.modal')
@include('admin.modalimagenes')
@endsection
@section('scripts')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>

<script src="/js/imagenes/vistaprevia.js"></script>
<script src="/js/imagenes/modalimagen.js"></script>

<script>

    var SITEURL = "{{URL::to('/')}}";
    var checkInsti = 'activos';
    $(document).ready(function () {

        $.extend($.fn.dataTableExt.oStdClasses, {
            "sFilterInput": "busqueda",
            "sLengthSelect": ""
        });

        $('#slidersC tfoot  th.text-input').each(function (i) {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="' + title + '" name="' + i + '" />');
        });

        var table = $('#slidersC').DataTable({
            "order":[[6,"desc"]],
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
                "url": '{{ route("programa.listPrograma")}}',
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
                { data: 'id', name: 'id', 'visible': false },
                { data: 'id_programa', searchable: true },
                { data: 'nombre', searchable: true },
                { data: 'nivel', searchable: true },
                { data: 'periodo', searchable: true },
                { data: 'institucion.nombre', searchable: true },
                { data: 'fecha_actualizacion', searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            columnDefs: [
                { responsivePriority: 1, targets: 1 },
                { responsivePriority: 2, targets:7 },
                { width: 105, targets: 7 }
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
            var programa_id = $(this).data('id');
            var ruta = "{{url('programa')}}/" + programa_id + "/editar";
            $.get(ruta, function (data) {
                //ocultar errores
                $('#programaCrudModal').html("Editar imagen");
                $('#btn-save').val("editar");
                $('#programa-crud-modal').modal('show');
                console.log(data);
                
                $('#id_institucion').val(data.id_institucion);
                $('#id_programa').val(data.id_programa);
                $('#nombre').val(data.nombre);
                $('#nivel').val(data.nivel);
                $('#nivel').val(data.nivel);
                $('#periodo').val(data.periodo);
                $('#programa_id').val(data.id);
                
                $('#imgslide').prop('src', "{{url('img/programa')}}/" + data.url_imagen);
                $('#imagenactualT').html('Imagen actual');
                $('#imagenAnterior').removeClass('d-none');

            })
        });

        //var info = table.page.info();
        /*Accion al presionar el boton eliminar*/
        $('body').on('click', '.eliminar', function () {
            var programa_id = $(this).data("id");
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
                                url: "{{ url('programa')}}" + '/' + programa_id,
                                success: function (data) {

                                    if (table.data().count() == 1) {
                                        $('#slidersC').DataTable().ajax.reload();
                                    } else {
                                        var oTable = $('#slidersC').dataTable();
                                        oTable.fnDraw(false);
                                    }
                                    //$("#mensaje-acciones").text("imagen eliminada exitosamente.");
                                    //$("#mensaje-acciones").fadeIn();
                                    //$('#mensaje-acciones').delay(3000).fadeOut();
                                    //$('#mensaje-acciones').addClass('alert-warning');
                                    //$('#mensaje-acciones').removeClass('alert-success');

                                    //$('#slidersC').DataTable().ajax.reload(null, false);
                                    //$('#slidersC').DataTable().ajax.reload();
                                    $("#snackbar").html("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> imagen eliminada exitosamente.");
                                    $("#snackbar").addClass("show");
                                    setTimeout(function () { $("#snackbar").removeClass("show"); }, 5000);
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
            var programa_id = $(this).data("id");
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
                                url: "{{ url('admin/programa/reactivar')}}" + '/' + programa_id,
                                success: function (data) {
                                    if (table.data().count() == 1) {
                                        $('#slidersC').DataTable().ajax.reload();
                                    } else {
                                        var oTable = $('#slidersC').dataTable();
                                        oTable.fnDraw(false);
                                    }
                                    $("#snackbar").html("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Imagen activada exitosamente.");
                                    $("#snackbar").addClass("show");
                                    setTimeout(function () { $("#snackbar").removeClass("show"); }, 5000);
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

    /*Accion al presionar el boton crear-programa*/
    $('#crear-programa').click(function () {

        $('#btn-save').val("crear-programa");
        $('#programa_id').val('');
        $('#programaForm').trigger("reset");
        $('#programaCrudModal').html("Agregar nuevo programa");
        $('#programa-crud-modal').modal({ backdrop: 'static', keyboard: false })
        $('#programa-crud-modal').modal('show');
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
        $('.mensajeError').text("");
        $("#btn-save").prop("disabled", true);
        $("#btn-close").prop("disabled", true);
        var actionType = $('#btn-save').val();
        $('#btn-save').html('Guardando..');
        if (actionType == "editar") {
            var id = $('#programa_id').val();
            var ruta = "{{url('programa')}}/" + id + "";
            var datos = new FormData($("#programaForm")[0]);
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
                    $('#programaForm').trigger("reset");
                    $('#programa-crud-modal').modal('hide');
                    $('#btn-save').html('Guardar');
                    //recargar serverside
                    var oTable = $('#slidersC').dataTable();
                    oTable.fnDraw(false);
                    //$("#mensaje-acciones").text("Actualización exitosa.");
                    //var x = document.getElementById("snackbar");
                    //x.html("Actualización exitosa.");
                    //x.className = "show";
                    $("#snackbar").html("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Actualización exitosa.");
                    $("#snackbar").addClass("show");
                    setTimeout(function () { $("#snackbar").removeClass("show"); }, 5000);

                    //$("#mensaje-acciones").fadeIn();
                    //$('#mensaje-acciones').delay(3000).fadeOut();
                    //$('#mensaje-acciones').addClass('alert-success');
                    //$('#mensaje-acciones').removeClass('alert-warning');
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                    $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
                    $('#nuevaImagen').addClass('d-none');
                    $('#vistaPrevia').prop('src', "");
                    console.log(data);
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
        } else if (actionType == "crear-programa") {
            $("#btn-save").prop("disabled", true);
            $("#btn-close").prop("disabled", true);



            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: new FormData($("#programaForm")[0]),
                url: "{{route('programa.store')}}",
                type: "POST",
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $('#programaForm').trigger("reset");
                    $('#programa-crud-modal').modal('hide');
                    $('#btn-save').html('Guardar');
                    //recargar serverside
                    var oTable = $('#slidersC').dataTable();
                    oTable.fnDraw(false);
                    //$("#mensaje-acciones").text("imagen registrada exitosamente.");
                    //$("#mensaje-acciones").fadeIn();
                    //$('#mensaje-acciones').delay(3000).fadeOut();
                    //$('#mensaje-acciones').addClass('alert-success');
                    //$('#mensaje-acciones').removeClass('alert-warning');
                    $("#snackbar").html("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> imagen registrada exitosamente.");
                    $("#snackbar").addClass("show");
                    setTimeout(function () { $("#snackbar").removeClass("show"); }, 5000);
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                    $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
                    $('#nuevaImagen').addClass('d-none');
                    $('#vistaPrevia').prop('src', "");
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
</script>
@endsection

@section('estilos')

{{-- comment 
<link rel="stylesheet" href="/css/datatable/jquery.dataTables.min.css">
<link rel="stylesheet" href="/css/datatable/responsive.dataTables.min.css">
<link rel="stylesheet" href="/css/datatable/jquery-confirm.min.css">
<link rel="stylesheet" href="/css/datatable/buttons.dataTables.min.css">
--}}



<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">

<link rel="stylesheet" href="/css/datatable/colores.css">
<link href="/css/modales/modalresponsivo.css" rel="stylesheet">
<link href="/css/modales/snackbar.css" rel="stylesheet">
<link href="/css/modales/modalimagen.css" rel="stylesheet">

<style>
    .custom-file-input~.custom-file-label::after {
        content: "Elegir";
    }
</style>

@endsection