@extends('admin.plantilla')
@section('contenido')


<div class="container-fluid" id="#contenedor">
    <div class="row">
        <div class="col-12 mx-auto">
            <h1>
                Directores de tesis
            </h1>
        </div>

        <div id="mensaje-acciones" class="col-12 alert alert-success alert-dismissible" role="alert"
            style="display:none">
            <strong> </strong>
        </div>
    </div>
    <div class="row mb-2">
        <legend class="col-form-label col-12 col-md-3 col-lg-3 pt-0   d-flex d-md-block justify-content-center justify-content-md-start">Mostras Directores de tesis</legend>
        <div class="col-12 col-md-4 col-lg-3 d-flex d-md-block justify-content-center justify-content-md-start">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio1" checked name="verCoor" value="activos">
                <label class="form-check-label" for="inlineRadio1">Activos</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio2" name="verCoor" value="eliminados">
                <label class="form-check-label" for="inlineRadio2">Eliminados</label>
            </div>
        </div>
        <div class="col-12 col-md-5 col-lg-6 d-flex d-md-block justify-content-center justify-content-md-start">
            <div class="d-flex justify-content-end">
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="crear-director"><span><i
                            class="fas fa-plus"></i></span> Agregar director</a>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="display" cellspacing="0" style="width:100%" id="directoresdt">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nombre</th>
                        <th>Primer apellido</th>
                        <th>Segundo apellido</th>
                        <th>Grado</th>
                        <th>Email</th>
                        <th>Institución</th>
                        <th>Última Actualización</th>
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
@include('admin.directores.modal')
@endsection
@section('scripts')
<script src="/js/admin/mostrarPassword.js"></script>
<script src="/plugins/datatables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables/Responsive-2.2.2/js/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<!--
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
-->

<script>

    var SITEURL = "{{URL::to('/')}}";
    var checkCoord = 'activos';
    var selectIDIns= "";
    $(document).ready(function () {
        
        $.extend($.fn.dataTableExt.oStdClasses, {
            "sFilterInput": "busqueda",
            "sLengthSelect": ""
        });

        var table = $('#directoresdt').DataTable({
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
                "url": '{{ route("director.listDirector")}}',
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
                { data: 'grado', searchable: false },
                { data: 'email', searchable: true },
                { data: 'institucion_nombre', searchable: true },
                { data: 'fecha_usuario', searchable: false },
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
            $('#directoresdt').DataTable().ajax.reload(null, false);
        });



        /*Al presionar el boton editar*/
        $('body').on('click', '.editarDirector', function () {
            reiniciar();
            var director_id = $(this).data('id');
            var ruta = "{{url('director')}}/" + director_id + "/editar";
            $.get(ruta, function (data) {
                //ocultar errores
                $('#password_di').attr("placeholder", "Nueva contraseña");
                $('#directorCrudModal').html("Editar director:" + data.nombre);
                $('#btn-save-director').val("editar");
                $('#director-crud-modal').modal('show');
                $('#director_id').val(data.id);
                $('#institucion_di').val(data.institucion);
                $('#nombre_di').val(data.nombre);
                $('#primer_apellido_di').val(data.primer_apellido);
                $('#segundo_apellido_di').val(data.segundo_apellido);
                $('#email_di').val(data.email);
                $('#grado_di').val(data.directortesis.grado);
                $("#institucionSelect_di").val(data.instituciones.id);
                

            })
        });

        //var info = table.page.info();
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
                                url: "{{ url('director')}}" + '/' + director_id,
                                success: function (data) {

                                    if (table.data().count() == 1) {
                                        $('#directoresdt').DataTable().ajax.reload();
                                    } else {
                                        var oTable = $('#directoresdt').dataTable();
                                        oTable.fnDraw(false);
                                    }
                                    $("#snackbar").html("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Cuenta eliminada exitosamente.");
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
                                url: "{{ url('director/reactivar')}}" + '/' + director_id,
                                success: function (data) {
                                    if (table.data().count() == 1) {
                                        $('#directoresdt').DataTable().ajax.reload();
                                    } else {
                                        var oTable = $('#directoresdt').dataTable();
                                        oTable.fnDraw(false);
                                    }
                                    $("#snackbar").html("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Cuenta activada exitosamente.");
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

    /*Accion al presionar el boton crear-director*/
    $('#crear-director').click(function () {
        reiniciar();
        $('#btn-save-director').val("crear-director");
        $('#director_id').val('');
        $('#password_di').attr("placeholder", "Contraseña para el usuario");
        $('#directorForm').trigger("reset");
        $('#directorCrudModal').html("Agregar nueva cuenta de director");
        $('#director-crud-modal').modal({ backdrop: 'static', keyboard: false })
        $('#director-crud-modal').modal('show');

    });

    $("input[name='verCoor']").change(function (e) {
        checkCoord = $(this).val();
        $('#directoresdt').DataTable().ajax.reload();
    });

    /*Accion al presionar el boton save*/
    $("#btn-save-director").click(function () {
        reiniciar();
        $("#btn-save-director").prop("disabled", true);
        $("#btn-close").prop("disabled", true);
        var actionType = $('#btn-save-director').val();
        $('#btn-save-director').html('Guardando..');
        if (actionType == "editar") {
            var id = $('#director_id').val();
            var ruta = "{{url('director')}}/" + id + "";
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
                    
                    $("#snackbar").html("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Actualización exitosa.");
                    $("#snackbar").addClass("show");
                    setTimeout(function () { $("#snackbar").removeClass("show"); }, 5000);

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
                url: "{{route('director.store')}}",
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
                    $("#snackbar").html("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> director registrado exitosamente.");
                    $("#snackbar").addClass("show");
                    setTimeout(function () { $("#snackbar").removeClass("show"); }, 5000);
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
    
    $('#institucionSelect').change(function () {
        selectIDIns = $(this).find("option:selected").val();
    });

    function reiniciar() {
        $('.mensajeError').text("");
        $('#password_di').val("");
    }
</script>
@endsection

@section('estilos')
<link rel="stylesheet" href="/plugins/datatables/DataTables-1.10.18/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="/plugins/datatables/Responsive-2.2.2/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

<!--
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
-->

<link rel="stylesheet" href="/css/datatable/colores.css">
<link href="/css/modales/modalresponsivo.css" rel="stylesheet">
<link href="/css/modales/snackbar.css" rel="stylesheet">


@endsection