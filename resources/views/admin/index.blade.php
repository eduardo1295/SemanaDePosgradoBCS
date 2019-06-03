@extends('admin.plantilla')
@section('contenido')


<div class="container-fluid" id="#contenedor">

    <div class="row">
        <div class="col-12 mx-auto">
            <h1>
                Eventos Semana de Posgrado
            </h1>
        </div>

        <div id="mensaje-acciones" class="col-12 alert alert-success alert-dismissible" role="alert"
            style="display:none">
            <strong> </strong>
        </div>
    </div>
    <div class="row mb-3">

        <div class="col-12 col-md-12 col-lg-12">
            <div class="d-flex justify-content-end">
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="crear-semana"><span><i
                            class="fas fa-plus"></i></span> Nuevo evento</a>

            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="display" cellspacing="0" style="width:100%" id="semanas">
                <thead>
                    <tr>
                        <th>id_semana</th>
                        <th>Nombre</th>
                        <th>Sede</th>
                        <th>Fecha inicio</th>
                        <th>Fecha fin</th>
                        <th>Convocatoria</th>
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

</div>

@endsection
@section('extra')
@include('admin.semana.modal')
<div id="snackbar"></div>
<div id="snackbarError" style="z-index:1051;"></div>
@endsection
@section('scripts')


<script src="/plugins/datatables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables/Responsive-2.2.2/js/dataTables.responsive.min.js"></script>
<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
-->

<script src="/js/imagenes/vistaprevia.js"></script>
<script src="/js/snack/snack.js"></script>

<script src="/plugins/summernote/summernote-bs4.js"></script>
<script src="/plugins/summernote/lang/summernote-es-ES.js"></script>
<script src="/plugins/summernote/plugin/cleaner/summernote-cleaner.js"></script>
<script src="/plugins/summernote/plugin/summernote-table-headers-master/summernote-table-headers.js"></script>
<script src="/plugins/summernote/plugin/list-styles-bs4/summernote-list-styles-bs4.js"></script>
<script src="/plugins/summernote/iniciarSummernote.js"></script>


<script src="/plugins/daterangepicker/moment.min.js"></script>
<script src="/plugins/daterangepicker/daterangepicker.js"></script>
<script src="/plugins/daterangepicker/iniciardaterangepicker.js"></script>

<script>
    //aqupi tenia lo de rangepicker
</script>
<script>

    var checkSemana = 'activos';
    var titulo = "";
    var table = "";
    $(document).ready(function () {
        $('.note-statusbar').hide();

        $("#show-sidebar").click(function () {
            $('#semanas').DataTable().ajax.reload(null, false);
        });

        $(function () {
            registerSummernote('.summernote', 'Descripción general del evento', 1000, function (max) {
                $('#maxContentPost').text(max)
            });
        });


        $.extend($.fn.dataTableExt.oStdClasses, {
            "sFilterInput": "busqueda",
            "sLengthSelect": ""
        });

        $('#semanas tfoot  th.text-input').each(function (i) {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="' + title + '" name="' + i + '" />');
        });

        table = $('#semanas').DataTable({
            "order": [[6, "desc"]],
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
                "url": '{{ route("semana.listSemanas")}}',
                "data": function (d) {
                    d.busqueda = checkSemana
                }
            },
            "columns": [
                { data: 'id', name: 'id', 'visible': false, searchable: false },
                { data: 'nombre', orderable: false, searchable: true },
                { data: 'instituciones[0].nombre', orderable: true, searchable: true },
                { data: 'fecha_inicio', orderable: false, searchable: false },
                { data: 'fecha_fin', orderable: false, searchable: false },
                {
                    data: 'url_convocatoria',
                    name: 'url_convocatoria',
                    render: function (data, type, full, meta) {
                        if (data == "no_disponible")
                            return data.replace("_", " ");
                        else
                            return "<a style='cursor:pointer' target='_blank' href={{ URL::to('/') }}/pdf/convocatoria/" + data + ">" + data + "<a/>";
                    },
                    orderable: false, searchable: false
                },
                { data: 'fecha_actualizacion', searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            columnDefs: [
                { responsivePriority: 1, targets: 1 },
                { responsivePriority: 2, targets: 7 },
                { width: 105, targets: 7 }
            ]
        });

        $('#semanas tbody').on('click', '.eliminar, .reactivar', function (e) {
            var tr = $(this).closest("tr");
            var data = $("#semanas").DataTable().row(tr).data();
            titulo = data.titulo;
        });
    });



    /*Al presionar el boton editar*/
    $('body').on('click', '.editar', function () {
        reiniciar();
        var semana_id = $(this).data('id');
        var ruta = "{{url('semana')}}/" + semana_id + "/editar";


        $.get(ruta, function (data) {

            $('#semanaCrudModal').html("Editar semana: " + data.nombre);
            $('#btn-save').val("editar");
            $('#semana-crud-modal').modal('show');
            $('#semana_id').val(data.id_semana);
            $('#nombre').val(data.nombre);
            $('#contenido').summernote('code', data.desc_general);
            $('#fecha').val(data.fecha);
            $("#institucionSelect").val(data.instituciones[0].id);
            $('#contenido').summernote('code', data.contenido);
            $('#imglogo').prop('src', "{{url('img/semanaLogo')}}/" + data.url_logo);
            $('#logoactual').html('Logo actual');
            $('#logoAnterior').removeClass('d-none');
            $('#fecha').data('daterangepicker').setStartDate(data.fecha_inicio);
            $('#fecha').data('daterangepicker').setEndDate(data.fecha_fin);
            if (data.url_convocatoria == 'no_disponible')
                $('#ligaConvo').html('No se ha cargado convocatoria')
            else
                $('#ligaConvo').html('Convocatoria <a target="_blank" href={{ URL::to("/") }}/pdf/convocatoria/' + data.url_convocatoria + '>' + data.url_convocatoria + '<a/>');

        })
    });


    /*Accion al presionar el boton crear-semana*/
    $('#crear-semana').click(function () {
        reiniciar();
        $('#btn-save').val("crear-semana");
        $('#semana_id').val('');
        $('#semanaForm').trigger("reset");
        $('#imglogo').prop('src', "");
        $('#logoactual').html('');
        $('#semanaCrudModal').html("Nueva Evento Semana de Posgrado");
        $('#semana-crud-modal').modal({ backdrop: 'static', keyboard: false })
        $('#semana-crud-modal').modal('show');
        $('#fecha').data('daterangepicker').setStartDate(moment().format('YYYY-MM-DD'));
        $('#fecha').data('daterangepicker').setEndDate(moment().add(4, 'days').format('YYYY-MM-DD'));
    });

    $('.modal-btn').click(function () {
        $('#btn-save').val("crear-semana");
        $('#semana_id').val('');
        $('#semanaForm').trigger("reset");
        $('#semanaCrudModal').html("Agregar nueva institución");
        $('#semana-crud-modal').modal({ backdrop: 'static', keyboard: false })
        $('#semana-crud-modal').modal('show');
    });


    /*Accion al presionar el boton save*/
    $("#btn-save").click(function () {
        $('.mensajeError').text("");
        $("#btn-save").prop("disabled", true);
        $("#btn-close").prop("disabled", true);
        var actionType = $('#btn-save').val();
        $('#btn-save').html('Guardando..');
        if (actionType == "editar") {
            var id = $('#semana_id').val();
            var ruta = "{{url('semana')}}/" + id + "";
            var datos = new FormData($("#semanaForm")[0]);
            var rFechas = $('#fecha').val().split(' - ');
            datos.append('fecha_inicio', rFechas[0]);
            datos.append('fecha_fin', rFechas[1]);
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
                    console.log(data);
                    
                    $('#semanaForm').trigger("reset");
                    $('#semana-crud-modal').modal('hide');
                    $('#btn-save').html('Guardar');
                    //recargar serverside
                    var oTable = $('#semanas').dataTable();
                    oTable.fnDraw(false);
                    //recargar sin serverside

                    mostrarSnack("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Actualización exitosa.");
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                    $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
                    if(data.vigente==1){
                        $('#logoMenu').prop('src', '{{ URL::to("/") }}/img/semanaLogo/'+data.url_logo);
                    }
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
        } else if (actionType == "crear-semana") {
            $("#btn-save").prop("disabled", true);
            $("#btn-close").prop("disabled", true);
            var datos = new FormData($("#semanaForm")[0]);
            var rFechas = $('#fecha').val().split(' - ');
            datos.append('fecha_inicio', rFechas[0]);
            datos.append('fecha_fin', rFechas[1]);
            console.log(Array.from(datos));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: datos,
                url: "{{route('semana.store')}}",
                type: "POST",
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    console.log(Array.from(data));
                    $('#semanaForm').trigger("reset");
                    $('#semana-crud-modal').modal('hide');
                    $('#btn-save').html('Guardar');
                    //recargar serverside
                    var oTable = $('#semanas').dataTable();
                    oTable.fnDraw(false);
                    //recargar sin serverside
                    mostrarSnack("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> semana guardada exitosamente.");;
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                    $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
                    $('#nuevoLogo').addClass('d-none');
                    if(data.vigente==1){
                        $('#logoMenu').prop('src', '{{ URL::to("/") }}/img/semanaLogo/'+data.url_logo);
                    }
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
        }

    });

    /*Accion al presionar el boton eliminar*/
    $('body').on('click', '.eliminar', function () {
        var semana_id = $(this).data("id");
        $.confirm({
            columnClass: 'col-md-6',
            title: '¿Desea eliminar la semana titulada ' + titulo + '?',
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
                            url: "{{ url('semana')}}" + '/' + semana_id,
                            success: function (data) {
                                var oTable = $('#semanas').dataTable();
                                if (table.data().count() == 1) {
                                    $('#semanas').DataTable().ajax.reload();
                                } else {
                                    oTable.fnDraw(false);
                                }
                                mostrarSnack("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Evento eliminado exitosamente.");
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
        var semana_id = $(this).data("id");
        $.confirm({
            columnClass: 'col-md-6',
            title: '¿Desea reactivar la semana titulada ' + titulo + '?',
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
                            url: "{{ url('admin/semana/reactivar')}}" + '/' + semana_id,
                            success: function (data) {
                                var oTable = $('#semanas').dataTable();
                                if (table.data().count() == 1) {
                                    $('#semanas').DataTable().ajax.reload();
                                } else {
                                    oTable.fnDraw(false);
                                }
                                mostrarSnack("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Evento activado exitosamente.");
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

    function reiniciar() {
        $('.mensajeError').text("");
        $('#contenido').summernote("reset");
        $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
        $('#nuevoLogo').addClass('d-none');
        $('#ligaConvo').html('Convocatoria');
    }

    $('.custom-file-input').on('change', function () {
        let fileName = $(this).val().split('\\').pop();
        if (!fileName.trim()) {
            $(this).next('.custom-file-label').removeClass("selected").html('Ningún archivo seleccionado');
        } else {
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        }
    });

</script>



@endsection

@section('estilos')


<link rel="stylesheet" href="/plugins/datatables/DataTables-1.10.18/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="/plugins/datatables/Responsive-2.2.2/css/responsive.dataTables.min.css">
<!--
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
-->
<link rel="stylesheet" href="/css/datatable/colores.css">
<link rel="stylesheet" href="/css/imagenes/imagenes.css">
<link rel="stylesheet" href="/css/modales/modalresponsivo.css">

<link rel="stylesheet" type="text/css" href="/plugins/daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="/plugins/summernote/summernote-bs4.css">
<link rel="stylesheet" href="/css/modales/snackbar.css">

<style>
    .custom-file-input~.custom-file-label::after {
        content: "Elegir";
    }
</style>
@endsection