@extends('admin.plantilla')
@section('contenido')


<div class="container-fluid" id="#contenedor">
    <div class="row">
        <div class="col-12 mx-auto">
            <h1>
                Alumnos participantes
            </h1>
        </div>

        <div id="mensaje-acciones" class="col-12 alert alert-success alert-dismissible" role="alert"
            style="display:none">
            <strong> </strong>
        </div>
    </div>
    <div class="row mb-2">
        <legend class="col-form-label col-12 col-md-3 col-lg-2 pt-0   d-flex d-md-block justify-content-center justify-content-md-start">Mostras Alumnos</legend>
        <div class="col-12 col-md-4 col-lg-4 d-flex d-md-block justify-content-center justify-content-md-start">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="alumnoR1" checked name="verAlumno" value="activos">
                <label class="form-check-label" for="alumnoR1">Activos</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="alumnoR2" name="verAlumno" value="eliminados">
                <label class="form-check-label" for="alumnoR2">Eliminados</label>
            </div>
        </div>
        <div class="col-12 col-md-5 col-lg-6 d-flex d-md-block justify-content-center justify-content-md-start">
                <div class="d-flex justify-content-end">
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="crear-alumno"><span><i
                            class="fas fa-plus"></i></span> Agregar alumno</a>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="display" cellspacing="0" style="width:100%" id="alumnosdt">
                <thead>
                    <tr>
                        <th>id</th>
                        <th class="all">No. Control</th>
                        <th class="all">Institución</th>
                        <th>Programa de estudios</th>
                        <th>Nombre</th>
                        <th>Primer apellido</th>
                        <th class="none">Segundo apellido</th>
                        <th>Email</th>
                        <th>Última Actualización</th>
                        <th class="all">Acciones</th>
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
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    
</div>


@endsection
@section('extra')
<div id="snackbar"></div>
    <div id="loader" class="loader"></div>
@include('admin.alumnos.modal')
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
    var checkAlumno = 'activos';
    var selectIDIns= "";
    
    $(document).ready(function () {
        
        $("body").tooltip({
            selector: '[data-toggle="tooltip"]',
            container: 'body',
            trigger : 'hover'
        });
        


        $.extend($.fn.dataTableExt.oStdClasses, {
            "sFilterInput": "busqueda",
            "sLengthSelect": ""
        });

        $('#alumnosdt tfoot  th.text-input').each(function (i) {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="' + title + '" name="' + i + '" />');
        });

        var table = $('#alumnosdt').DataTable({
            "order": [[ 8, "desc" ]],
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
                "url": '{{ route("alumno.listAlumnos")}}',
                "data": function (d) {
                    d.busqueda = checkAlumno
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
                { data: 'num_control', searchable: false },
                { data: 'institucion_nombre', searchable: true },
                { data: 'programa_nombre', searchable: false },
                { data: 'nombre', searchable: true },
                { data: 'primer_apellido', searchable: true },
                { data: 'segundo_apellido', searchable: true },
                { data: 'email', searchable: true },
                { data: 'fecha_usuario', searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            columnDefs: [
                { responsivePriority: 1, targets: 1 },
                { responsivePriority: 2, targets: 9 },
                { width: 105, targets: 9 }
            ]
        });



        $("#close-sidebar").click(function () {
            $('.mensajeError').text("");
            
        });

        $("#show-sidebar").click(function () {
            //$('#alumnosdt').DataTable().ajax.reload(null, false);
        });



        /*Al presionar el boton editar*/
        $('body').on('click', '.editarAlumno', function () {
            var alumno_id = $(this).data('id');
            var ruta = "{{url('alumno')}}/" + alumno_id + "/editar";
            
            $.get(ruta, function (data) {
                //ocultar errores
                $('#alumnoCrudModal').html("Editar alumno: " + data[0].nombre + ' ' + data[0].primer_apellido + ' ' + data[0].segundo_apellido);
                $('#btn-save-alumno').val("editar");
                $('#alumno-crud-modal').modal('show');
                console.log(data);
                $('#alumno_id_al').val(data[0].id);
                $('#institucion_al').val(data.institucion);
                $('#nombre_al').val(data[0].nombre);
                $('#primer_apellido_al').val(data[0].primer_apellido);
                $('#segundo_apellido_al').val(data[0].segundo_apellido);
                $('#email_al').val(data[0].email);
                $('#semestre_al').val(data[0].alumnos.semestre);
                $('#num_control_al').val(data[0].alumnos.num_control);
                $("#institucionSelect_al").val(data[0].instituciones.id);
                
                buscarProgramas(data[0].alumnos.id_programa,data[0].alumnos.id_director,true);
                
                //setTimeout(function(){ 
                    //$("#programaSelect").val(data[0].alumnos.id_programa);
                    //$("#directorSelect").val(data[0].alumnos.id_director);
                //}, 3000);
            })
        });

        //var info = table.page.info();
        /*Accion al presionar el boton eliminar*/
        $('body').on('click', '.eliminarAlumno', function () {
            var alumno_id = $(this).data("id");
            $.confirm({
                columnClass: 'col-md-6',
                title: '¿Desea eliminar el alumno?',
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
                                url: "{{ url('alumno')}}" + '/' + alumno_id,
                                success: function (data) {

                                    if (table.data().count() == 1) {
                                        $('#alumnosdt').DataTable().ajax.reload();
                                    } else {
                                        var oTable = $('#alumnosdt').dataTable();
                                        oTable.fnDraw(false);
                                    }
                                    $("#snackbar").html("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Alumno borrado exitosamente.");
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
        $('body').on('click', '.reactivarAlumno', function () {
            var alumno_id = $(this).data("id");
            $.confirm({
                columnClass: 'col-md-6',
                title: "¿Desea reactivar el alumno?",
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
                                url: "{{ url('admin/alumno/reactivar')}}" + '/' + alumno_id,
                                success: function (data) {
                                    if (table.data().count() == 1) {
                                        $('#alumnosdt').DataTable().ajax.reload();
                                    } else {
                                        var oTable = $('#alumnosdt').dataTable();
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

    /*Accion al presionar el boton crear-alumno*/
    $('#crear-alumno').click(function () {
        
        $('#btn-save-alumno').val("crear-alumno");
        $('#alumno_id_al').val('');
        $('#alumnoForm').trigger("reset");
        $('#alumnoCrudModal').html("Agregar nueva cuenta de alumno");
        $('#alumno-crud-modal').modal('show');
        reiniciarselect();

    });

    $('#btn-close').click(function () {
        $('.mensajeError').text("");
    })

    $("input[name='verAlumno']").change(function (e) {
        checkAlumno = $(this).val();
        $('#alumnosdt').DataTable().ajax.reload();
    });

    /*Accion al presionar el boton save*/
    $("#btn-save-alumno").click(function () {
        $('.mensajeError').text("");
        $("#btn-save-alumno").prop("disabled", true);
        $("#btn-close").prop("disabled", true);
        var actionType = $('#btn-save-alumno').val();
        $('#btn-save-alumno').html('Guardando..');
        if (actionType == "editar") {
            var id = $('#alumno_id_al').val();
            var ruta = "{{url('alumno')}}/" + id + "";
            var datos = new FormData($("#alumnoForm")[0]);
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
                    $('#alumnoForm').trigger("reset");
                    $('#alumno-crud-modal').modal('hide');
                    $('#btn-save-alumno').html('Guardar');
                    //recargar serverside
                    var oTable = $('#alumnosdt').dataTable();
                    oTable.fnDraw(false);
                    
                    $("#snackbar").html("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Actualización exitosa.");
                    $("#snackbar").addClass("show");
                    setTimeout(function () { $("#snackbar").removeClass("show"); }, 5000);

                    $("#btn-save-alumno").prop("disabled", false);
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
                    $('#btn-save-alumno').html('Guardar');
                    $("#btn-save-alumno").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                },

            });
        } else if (actionType == "crear-alumno") {
            $("#btn-save-alumno").prop("disabled", true);
            $("#btn-close").prop("disabled", true);
            var datos = new FormData($("#alumnoForm")[0]);
            //datos.append('id_institucion', $('#institucionSelect').find("option:selected").val());
            console.log(Array.from(datos));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: datos,
                url: "{{route('alumno.store')}}",
                type: "POST",
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $('#alumnoForm').trigger("reset");
                    $('#alumno-crud-modal').modal('hide');
                    $('#btn-save-alumno').html('Guardar');
                    //recargar serverside
                    var oTable = $('#alumnosdt').dataTable();
                    oTable.fnDraw(false);
                    $("#snackbar").html("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Coordinador registrado exitosamente.");
                    $("#snackbar").addClass("show");
                    setTimeout(function () { $("#snackbar").removeClass("show"); }, 5000);
                    $("#btn-save-alumno").prop("disabled", false);
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
                    $('#btn-save-alumno').html('Guardar');
                    $("#btn-save-alumno").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                },


            });
        }

    })
    
    $('#institucionSelect_al').change(function () {
        buscarProgramas('n','n',false);
    });

    function buscarProgramas(bPrograma, bDirector,edicion){
        selectIDIns = $('#institucionSelect_al').val();
        var ruta = "{{url('alumno/programasLista')}}/" + selectIDIns + "";
        
        $("#btn-save-alumno").prop("disabled", true);
        $("#btn-close").prop("disabled", true);
        $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: ruta,
                type: "GET",
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){
                    $(".loader").show();
                },
                success: function (data) {
                    $('#programaSelect_al').html('');
                    $('#programaSelect_al').append('<option selected value="">Seleccione un programa de estudio</option>');
                    
                    $.each(data[0], function(key, val) {
                        $('#programaSelect_al').append('<option value="' + val.id + '">'+val.id_programa + ' - ' +val.nombre+'</option>');
                    })

                    $('#directorSelect_al').html('');
                    $('#directorSelect_al').append('<option selected value="">Seleccione un director de tesis</option>');
                    
                    $.each(data[1], function(key, val) {
                        $('#directorSelect_al').append('<option value="' + val.id + '">'+val.directortesis.grado + '. ' +val.nombre+ ' ' +val.primer_apellido+ ' ' +val.segundo_apellido+ '</option>');
                    })
                    $("#btn-save-alumno").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                },
                error: function (data) {
                    reiniciarselect();
                    if (data.status == 422) {
                        var errores = data.responseJSON['errors'];
                        $.each(errores, function (key, value) {
                            $('#' + key + "_error").text(value);
                        });
                    }
                    $('#btn-save-alumno').html('Guardar');
                    $("#btn-save-alumno").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                },
                complete: function (data) {
                    if(edicion){
                        $("#programaSelect_al").val(bPrograma);
                        $("#directorSelect_al").val(bDirector);
                    }
                    $(".loader").hide();
                }

            });
    }

    function reiniciarselect(){
        $('#programaSelect_al').html('');
        $('#programaSelect_al').append('<option selected value="">Seleccione una institución</option>');
        $('#directorSelect_al').html('');
        $('#directorSelect_al').append('<option selected value="">Seleccione una institución</option>');
    }
    
</script>
@endsection

@section('estilos')
<link href="/css/imagenes/cargando.css" rel="stylesheet">
<link rel="stylesheet" href="/plugins/datatables/DataTables-1.10.18/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="/plugins/datatables/Responsive-2.2.2/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<!--
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
-->

<link rel="stylesheet" href="/css/datatable/colores.css">
<link href="/css/modales/modalresponsivo.css" rel="stylesheet">
<link href="/css/modales/snackbar.css" rel="stylesheet">
<style>
    .tooltip{
        pointer-events: none;
    }
</style>

@endsection