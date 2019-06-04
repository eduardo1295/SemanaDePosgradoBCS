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
        <legend class="col-form-label col-12 col-md-2 col-lg-2 pt-0">Mostrar alumnos</legend>
        <div class="col-12 col-md-4 col-lg-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio1" checked name="verAlumno" value="activos">
                <label class="form-check-label" for="inlineRadio1">Activos</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio2" name="verAlumno" value="eliminados">
                <label class="form-check-label" for="inlineRadio2">Eliminados</label>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-6">
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
                        <th>No. Control</th>
                        <th>Institución</th>
                        <th>Programa de estudios</th>
                        <th>Nombre</th>
                        <th>Primer apellido</th>
                        <th>Segundo apellido</th>
                        <th>Email</th>
                        
                        
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
@include('admin.alumnos.modal')
@endsection
@section('scripts')

<script src="/plugins/datatables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables/Responsive-2.2.2/js/dataTables.responsive.min.js"></script>
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

        $('#alumnosdt tfoot  th.text-input').each(function (i) {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="' + title + '" name="' + i + '" />');
        });

        var table = $('#alumnosdt').DataTable({
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
                { data: 'alumnos.num_control', searchable: false },
                { data: 'instituciones.nombre', searchable: true },
                { data: 'programas[0].nombre', searchable: false },
                { data: 'nombre', searchable: true },
                { data: 'primer_apellido', searchable: true },
                { data: 'segundo_apellido', searchable: true },
                { data: 'email', searchable: true },
                
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            columnDefs: [
                { responsivePriority: 1, targets: 2 },
                { responsivePriority: 2, targets: 7 },
                { width: 105, targets: 7 }
            ]
        });



        $("#close-sidebar").click(function () {
            $('.mensajeError').text("");
            
        });

        $("#show-sidebar").click(function () {
            $('#alumnosdt').DataTable().ajax.reload(null, false);
        });



        /*Al presionar el boton editar*/
        $('body').on('click', '.editar', function () {
            var alumno_id = $(this).data('id');
            var ruta = "{{url('alumno')}}/" + alumno_id + "/editar";
            $.get(ruta, function (data) {
                //ocultar errores
                $('#alumnoCrudModal').html("Editar alumno: " + data[0].nombre + ' ' + data[0].primer_apellido + ' ' + data[0].segundo_apellido);
                $('#btn-save').val("editar");
                $('#alumno-crud-modal').modal('show');
                console.log(data);
                $('#alumno_id').val(data[0].id);
                $('#institucion').val(data.institucion);
                $('#nombre').val(data[0].nombre);
                $('#primer_apellido').val(data[0].primer_apellido);
                $('#segundo_apellido').val(data[0].segundo_apellido);
                $('#email').val(data[0].email);
                $('#semestre').val(data[0].alumnos.semestre);
                $('#num_control').val(data[0].alumnos.num_control);
                $("#institucionSelect").val(data[0].instituciones.id);
                buscarProgramas();
                setTimeout(function(){ 
                    $("#programaSelect").val(data[0].alumnos.id_programa);
                    $("#directorSelect").val(data[0].alumnos.id_director);
                }, 3000);
            })
        });

        //var info = table.page.info();
        /*Accion al presionar el boton eliminar*/
        $('body').on('click', '.eliminar', function () {
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
                                    $("#snackbar").html("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> alumno eliminada exitosamente.");
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

        $('#btn-save').val("crear-alumno");
        $('#alumno_id').val('');
        $('#alumnoForm').trigger("reset");
        $('#alumnoCrudModal').html("Agregar nueva cuenta de alumno");
        $('#alumno-crud-modal').modal('show');
        reiniciarselect();

    });

    $('#btn-close').click(function () {
        $('.mensajeError').text("");
    })

    $("input[name='verAlumno']").change(function (e) {
        checkCoord = $(this).val();
        $('#alumnosdt').DataTable().ajax.reload();
    });

    /*Accion al presionar el boton save*/
    $("#btn-save").click(function () {
        $('.mensajeError').text("");
        $("#btn-save").prop("disabled", true);
        $("#btn-close").prop("disabled", true);
        var actionType = $('#btn-save').val();
        $('#btn-save').html('Guardando..');
        if (actionType == "editar") {
            var id = $('#alumno_id').val();
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
                    $('#btn-save').html('Guardar');
                    //recargar serverside
                    var oTable = $('#alumnosdt').dataTable();
                    oTable.fnDraw(false);
                    
                    $("#snackbar").html("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Actualización exitosa.");
                    $("#snackbar").addClass("show");
                    setTimeout(function () { $("#snackbar").removeClass("show"); }, 5000);

                    $("#btn-save").prop("disabled", false);
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
                    $('#btn-save').html('Guardar');
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                },

            });
        } else if (actionType == "crear-alumno") {
            $("#btn-save").prop("disabled", true);
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
                    $('#btn-save').html('Guardar');
                    //recargar serverside
                    var oTable = $('#alumnosdt').dataTable();
                    oTable.fnDraw(false);
                    $("#snackbar").html("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Coordinador registrado exitosamente.");
                    $("#snackbar").addClass("show");
                    setTimeout(function () { $("#snackbar").removeClass("show"); }, 5000);
                    $("#btn-save").prop("disabled", false);
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
                    $('#btn-save').html('Guardar');
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                },


            });
        }

    })
    
    $('#institucionSelect').change(function () {
        buscarProgramas();
    });

    function buscarProgramas(){
        selectIDIns = $('#institucionSelect').val();
        var ruta = "{{url('alumno/programasLista')}}/" + selectIDIns + "";
        
        $("#btn-save").prop("disabled", true);
        $("#btn-close").prop("disabled", true);
        $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: ruta,
                type: "GET",
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $('#programaSelect').html('');
                    $('#programaSelect').append('<option selected value="">Seleccione un programa de estudio</option>');
                    
                    $.each(data[0], function(key, val) {
                        $('#programaSelect').append('<option value="' + val.id + '">'+val.id_programa + ' - ' +val.nombre+'</option>');
                    })

                    $('#directorSelect').html('');
                    $('#directorSelect').append('<option selected value="">Seleccione un director de tesis</option>');
                    
                    $.each(data[1], function(key, val) {
                        $('#directorSelect').append('<option value="' + val.id + '">'+val.directortesis.grado + '. ' +val.nombre+ ' ' +val.primer_apellido+ ' ' +val.segundo_apellido+ '</option>');
                    })
                    $("#btn-save").prop("disabled", false);
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
                    $('#btn-save').html('Guardar');
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                },

            });
    }

    function reiniciarselect(){
        $('#programaSelect').html('');
        $('#programaSelect').append('<option selected value="">Seleccione una institución</option>');
        $('#directorSelect').html('');
        $('#directorSelect').append('<option selected value="">Seleccione una institución</option>');
    }
    var showPass = 0;
    $('.btn-show-pass').on('click', function(){
        if(showPass == 0) {
            $("#password").attr('type','text');
            $(this).find('i').removeClass('fa-eye');
            $(this).find('i').addClass('fa-eye-slash');
            showPass = 1;
        }
        else {
            $("#password").attr('type','password');
            $(this).find('i').addClass('fa-eye');
            $(this).find('i').removeClass('fa-eye-slash');
            showPass = 0;
        }
        
    });
</script>
@endsection

@section('estilos')
<link rel="stylesheet" href="/plugins/datatables/DataTables-1.10.18/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="/plugins/datatables/Responsive-2.2.2/css/responsive.dataTables.min.css">

<!--
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
-->

<link rel="stylesheet" href="/css/datatable/colores.css">
<link href="/css/modales/modalresponsivo.css" rel="stylesheet">
<link href="/css/modales/snackbar.css" rel="stylesheet">


@endsection