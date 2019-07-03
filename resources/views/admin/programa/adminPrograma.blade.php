@extends('admin.plantilla')
@section('contenido')


<div class="container-fluid" id="#contenedor">
    <div class="row">
        <div class="col-12 mx-auto">
            <h1>
                Programas de estudio
            </h1>
        </div>

        <div id="mensaje-acciones" class="col-12 alert alert-success alert-dismissible" role="alert"
            style="display:none">
            <strong> </strong>
        </div>
    </div>
    <div class="row mb-2">
        <legend class="col-form-label col-12 col-md-3 col-lg-2 pt-0   d-flex d-md-block justify-content-center justify-content-md-start">Mostras Programas</legend>
        <div class="col-12 col-md-4 col-lg-4 d-flex d-md-block justify-content-center justify-content-md-start">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio1" checked name="verPrograma" value="activos">
                <label class="form-check-label" for="inlineRadio1">Activas</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio2" name="verPrograma" value="eliminados">
                <label class="form-check-label" for="inlineRadio2">Eliminadas</label>
            </div>
        </div>
        <div class="col-12 col-md-5 col-lg-6 d-flex d-md-block justify-content-center justify-content-md-start">
            <div class="d-flex justify-content-end">
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="crear-programa"><span><i
                            class="fas fa-plus"></i></span> Nuevo Programa</a>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="display" cellspacing="0" style="width:100%" id="programasDT">
                <thead>
                    <tr>
                        <th>id</th>
                        <th class="all">Nombre</th>
                        <th>Clave Programa</th>
                        <th>Nivel</th>
                        <th>Periodo</th>
                        <th>Institución</th>
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
@include('admin.programa.modal')
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
<script src="/js/snack/snack.js"></script>
<script>

    var SITEURL = "{{URL::to('/')}}";
    var checkInsti = 'activos';
    $(document).ready(function () {

        $.extend($.fn.dataTableExt.oStdClasses, {
            "sFilterInput": "busqueda",
            "sLengthSelect": ""
        });

        $('#programasDT tfoot  th.text-input').each(function (i) {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="' + title + '" name="' + i + '" />');
        });

        var table = $('#programasDT').DataTable({
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
                { data: 'nombre', searchable: true },
                { data: 'id_programa', searchable: true },
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
        });

        $("#show-sidebar").click(function () {
            $('#programasDT').DataTable().ajax.reload(null, false);
        });



        /*Al presionar el boton editar*/
        $('body').on('click', '.editarPrograma', function () {
            $('.mensajeError').text("")
            var programa_id = $(this).data('id');
            var ruta = "{{url('programa')}}/" + programa_id + "/editar";
            $.get(ruta, function (data) {
                //ocultar errores
                $('#programaCrudModal').html("Editar Programa");
                $('#btn-save-pro').val("editar");
                $('#programa-crud-modal').modal('show');
                
                
                $('#id_institucion_pro').val(data.id_institucion);
                $('#id_programa_pro').val(data.id_programa);
                $('#nombre_pro').val(data.nombre);
                $('#nivel_pro').val(data.nivel);
                $('#nivel_pro').val(data.nivel);
                $('#periodo_pro').val(data.periodo);
                $('#programa_id_pro').val(data.id);
                

            })
        });

        //var info = table.page.info();
        /*Accion al presionar el boton eliminar*/
        $('body').on('click', '.eliminarPrograma', function () {
            var programa_id = $(this).data("id");
            $.confirm({
                columnClass: 'col-md-6',
                title: '¿Desea eliminar el programa de estudios?',
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
                                        $('#programasDT').DataTable().ajax.reload();
                                    } else {
                                        var oTable = $('#programasDT').dataTable();
                                        oTable.fnDraw(false);
                                    }
                                    mostrarSnack("Programa borrado exitosamente.");
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
        $('body').on('click', '.reactivarPrograma', function () {
            var programa_id = $(this).data("id");
            $.confirm({
                columnClass: 'col-md-6',
                title: "¿Desea reactivar el programa de estudios?",
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
                                        $('#programasDT').DataTable().ajax.reload();
                                    } else {
                                        var oTable = $('#programasDT').dataTable();
                                        oTable.fnDraw(false);
                                    }
                                    
                                    mostrarSnack("Porgrama activado exitosamente.");
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
        $('.mensajeError').text("")
        $('#btn-save-pro').val("crear-programa");
        $('#programa_id').val('');
        $('#programaForm').trigger("reset");
        $('#programaCrudModal').html("Agregar nuevo programa");
        $('#programa-crud-modal').modal({ backdrop: 'static', keyboard: false })
        $('#programa-crud-modal').modal('show');

    });


    $("input[name='verPrograma']").change(function (e) {
        checkInsti = $(this).val();
        $('#programasDT').DataTable().ajax.reload();
    });

    /*Accion al presionar el boton save*/
    $("#btn-save-pro").click(function () {
        $('.mensajeError').text("");
        $("#btn-save-pro").prop("disabled", true);
        $("#btn-close").prop("disabled", true);
        var actionType = $('#btn-save-pro').val();
        $('#btn-save-pro').html('Guardando..');
        if (actionType == "editar") {
            var id = $('#programa_id_pro').val();
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
                    $('#btn-save-pro').html('Guardar');
                    //recargar serverside
                    var oTable = $('#programasDT').dataTable();
                    oTable.fnDraw(false);
                    
                    mostrarSnack("Actualización exitosa.");
                    
                    $("#btn-save-pro").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                    
                    console.log(data);
                },
                error: function (data) {
                    if (data.status == 422) {
                        var errores = data.responseJSON['errors'];
                        $.each(errores, function (key, value) {
                            $('#' + key + "_error").text(value);
                        });
                    }
                    $('#btn-save-pro').html('Guardar');
                    $("#btn-save-pro").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                },

            });
        } else if (actionType == "crear-programa") {
            $("#btn-save-pro").prop("disabled", true);
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
                    $('#btn-save-pro').html('Guardar');
                    //recargar serverside
                    var oTable = $('#programasDT').dataTable();
                    oTable.fnDraw(false);
                    
                    mostrarSnack("Pograma registrado exitosamente.");
                    $("#btn-save-pro").prop("disabled", false);
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
                    $('#btn-save-pro').html('Guardar');
                    $("#btn-save-pro").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                    
                },


            });
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