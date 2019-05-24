@extends('admin.plantilla')
@section('contenido')


<div class="container-fluid" id="#contenedor">

    <div class="row">
        <div class="col-12 mx-auto">
            <h1>
                Modalidades
            </h1>
        </div>

        <div id="mensaje-acciones" class="col-12 alert alert-success alert-dismissible" role="alert"
            style="display:none">
            <strong> </strong>
        </div>
    </div>
    <div class="row mb-3">
        <legend class="col-form-label col-12 col-md-2 col-lg-2 pt-0">Mostras modalidad</legend>
        <div class="col-12 col-md-4 col-lg-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio1" checked name="verNoti" value="activos">
                <label class="form-check-label" for="inlineRadio1">Activas</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio2" name="verNoti" value="eliminados">
                <label class="form-check-label" for="inlineRadio2">Eliminadas</label>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-6">
            <div class="d-flex justify-content-end">
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="crear-modalidad"><span><i
                            class="fas fa-plus"></i></span> Nueva Modalidad</a>

            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="display" cellspacing="0" style="width:100%" id="modalidad">
                <thead>
                    <tr>
                        <th>id_modalidad</th>
                        <th>Titulo</th>
                        <th>Resumen</th>
                        <th>Última actualización</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th class="text-input">Titulo</th>
                        <th class="text-input">Resumen</th>
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
@include('modalidad.modal')
@endsection
@section('scripts')




<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>


<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.js"></script>


<script src="/js/summer/summernote-bs4.js"></script>
<script src="/js/summer/summernote-es-ES.js"></script>
<script src="/js/summer/summernote-text-findnreplace.js"></script>
<script src="/js/summer/summernote-list-styles-bs4.js"></script>
<script src="/js/summer/summernote-cleaner.js"></script>
<script src="/js/imagenes/vistaprevia.js"></script>
-->
<script src="/plugins/summernote/summernote-bs4.js"></script>
<script src="/plugins/summernote/lang/summernote-es-ES.js"></script>
<script src="/plugins/summernote/plugin/cleaner/summernote-cleaner.js"></script>
<script src="/plugins/summernote/plugin/summernote-table-headers-master/summernote-table-headers.js"></script>
<script src="/plugins/summernote/plugin/list-styles-bs4/summernote-list-styles-bs4.js"></script>
<script src="/plugins/summernote/iniciarSummernote.js"></script>
<!--Nuevo Rente-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.1/bootstrap-slider.js"></script>
<script src="/plugins/nouislider/nouislider.js"></script>
<script src="/plugins/nouislider/wNumb.js"></script>


<script>
    var checkInsti = 'activos';
    var titulo = "";
    var table = "";
    $(document).ready(function () {
        $("#show-sidebar").click(function () {
            $('#modalidad').DataTable().ajax.reload(null, false);
        });


        $(function () {
            registerSummernote('.summernote', 'Contenido de la modalidad', 1000, function (max) {
                $('#maxContentPost').text(max)
            });
        });


        $.extend($.fn.dataTableExt.oStdClasses, {
            "sFilterInput": "busqueda",
            "sLengthSelect": ""
        });

        $('#modalidad tfoot  th.text-input').each(function (i) {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="' + title + '" name="' + i + '" />');
        });

        table = $('#modalidad').DataTable({
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
                "url": '{{ route("modalidad.listModalidad")}}',
                "data": function (d) {
                    d.busqueda = checkInsti
                }
            },
            initComplete: function () {
                var api = this.api();
                api.columns(1).every(function () {
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
                { data: 'descripcion', searchable: true , 'visible': false },
                { data: 'fecha_actualizacion', searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            columnDefs: [
                { responsivePriority: 1, targets: 1 },
                { responsivePriority: 2, targets: 4 },
                { width: 105, targets: 4 }
            ]
        });


        $("input[name='verNoti']").change(function (e) {
            checkInsti = $(this).val();
            $('#modalidad').DataTable().ajax.reload();
        });

        $('#modalidad tbody').on('click', '.eliminar, .reactivar', function (e) {
            var tr = $(this).closest("tr");
            var data = $("#modalidad").DataTable().row(tr).data();
            titulo = data.titulo;

        });

    function filterPips(value, type) {
                if (type === 0) {
                    return value < 2000 ? -1 : 0;
                }
                return value % 1000 ? 2 : 1;
            }
            var slider = document.getElementById('slider');
            noUiSlider.create(slider, {
                start: [1, 10], //num, [num], [num,num]
                format: wNumb({
                    decimals: 0
                }),
                pips: {
                    mode: 'steps',
                    density: 3,
                    filter: filterPips,
                    format: wNumb({
                        decimals: 0,

                    })
                },
                range: {
                    'min': [1],
                    'max': [10]
                },
                behaviour: 'drag',
                connect: true,
                animate: true,
                step: 1,
                orientation: 'horizontal',
                tooltips: [true, true],
    });
    $('#slider').change(function(){
        console.log('hola');
    });
});
    
    $('.custom-file-input').on('change', function () {
        let fileName = $(this).val().split('\\').pop();
        if (!fileName.trim()) {
            $(this).next('.custom-file-label').removeClass("selected").html('Ningún archivo seleccionado');
        } else {
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        }
    });

    /*Al presionar el boton editar*/
    $('body').on('click', '.editar', function () {
        var modalidad_id = $(this).data('id');
        var ruta = "{{url('modalidad')}}/" + modalidad_id + "/editar";
        reiniciar();


        $.get(ruta, function (data) {
            $('#modalidadCrudModal').html("Editar modalidad: " + data.modalidad.nombre);
            $('#btn-save').val("editar");
            $('#modalidad-crud-modal').modal('show');
            $('#modalidad_id').val(data.modalidad.id_modalidad);
            $('#titulo').val(data.modalidad.nombre);

            //$('#contenido').val(data.modalidad.descripcion);
            crearRenglon((data.posgrado.length-1));
            $('.posgrado').each(function (i) {
                $(this).val(data.posgrado[i].grado);
            });
            $('.periodo').each(function (i) {
                $(this).val(data.posgrado[i].periodo);
            });
            $('.sliderrr').each(function (i) {
                this.noUiSlider.set([data.periodo[i].periodo_min,data.periodo[i].periodo_max]);
            });

            $('#contenido').summernote('code', data.modalidad.descripcion);
            //$('#imglogo').prop('src',"");
            if (data.url_imagen != "sin imagen") {
                $('#logoactual').html('Imagen actual de la modalidad');
                $('#imglogo').prop('src', "{{url('img/modalidad')}}/" + data.url_imagen);
            } else {
                $('#logoactual').html('');
            }
        })
    });


    /*Accion al presionar el boton crear-modalidad*/
    $('#crear-modalidad').click(function () {
        reiniciar();
        slider.noUiSlider.set([1,10]);
        $('#btn-save').val("crear-modalidad");
        $('#modalidad_id').val('');
        $('#modalidadForm').trigger("reset");
        $('#modalidadCrudModal').html("Agregar nueva modalidad");
        $('#modalidad-crud-modal').modal({ backdrop: 'static', keyboard: false })
        $('#modalidad-crud-modal').modal('show');
        $('#imglogo').prop('src', "");

        $('#logoactual').html('');
    });

    $('.modal-btn').click(function () {
        $('#btn-save').val("crear-modalidad");
        $('#modalidad_id').val('');
        $('#modalidadForm').trigger("reset");
        $('#modalidadCrudModal').html("Agregar nueva institución");
        $('#modalidad-crud-modal').modal({ backdrop: 'static', keyboard: false })
        $('#modalidad-crud-modal').modal('show');
        $('#imglogo').prop('src', "");
        //$('#imglogo').width('0').height('0');
        $('#logoactual').html('');
    });


    /*Accion al presionar el boton save*/
    $("#btn-save").click(function () {
        $('.mensajeError').text("");
        $("#btn-save").prop("disabled", true);
        $("#btn-close").prop("disabled", true);
        var actionType = $('#btn-save').val();
        $('#btn-save').html('Guardando..');
        if (actionType == "editar") {
            var id = $('#modalidad_id').val();
            var ruta = "{{url('modalidad')}}/" + id + "";
            var sli = $('.sliderrr');
            var auxDatos = new Array() , auxPosgrado = new Array() , auxperiodo = new Array();
            for(w=0; w< sli.length; w++){
                //var ee = sli[w];
                auxDatos.push(sli[w].noUiSlider.get());
                auxPosgrado.push($('.posgrado')[w].value);
                auxperiodo.push($('.periodo')[w].value);
            }
            console.log(auxDatos);
            var content = $('#contenido').val();
            //var datos = new FormData($("#modalidadForm")[0]);
            //periodo.append('_method', 'PUT');
            //console.log(Array.from(datos));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: ruta,
                type: "PUT",
                data: {  nombres: $('#titulo').val(),
                         contenido: content,
                         slider: auxDatos,
                         posgrado: auxPosgrado,
                         periodo: auxperiodo
                },
                //data: datos,
                //dataType: 'JSON',
                //contentType: false,
                //cache: false,
                //processData: false,
                success: function (data) {
                    //console.log(data);
                    $('#modalidadForm').trigger("reset");
                    $('#modalidad-crud-modal').modal('hide');
                    $('#btn-save').html('Guardar');
                    //recargar serverside
                    var oTable = $('#modalidad').dataTable();
                    oTable.fnDraw(false);
                    //recargar sin serverside
                    //$('#instituciones').DataTable().ajax.reload(null, false);
                    $("#mensaje-acciones").text("Actualización exitosa.");
                    $("#mensaje-acciones").fadeIn();
                    $('#mensaje-acciones').delay(3000).fadeOut();
                    $('#mensaje-acciones').addClass('alert-success');
                    $('#mensaje-acciones').removeClass('alert-warning');
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                    $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    if (xhr.status == 422) {
                        var errores = xhr.responseJSON['errors'];
                        var key2;
                        $.each(errores, function (key, value) {
                            key2= key.replace('.','\\.');
                            $('#' + key2 + '_error').text(value);
                            console.log(($('#' + key + "_error")));
                        });
                    }
                    $('#btn-save').html('Guardar');
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                },

            });
        } else if (actionType == "crear-modalidad") {
            $("#btn-save").prop("disabled", true);
            $("#btn-close").prop("disabled", true);

            var sli = $('.sliderrr');
            var auxDatos = new Array() , auxPosgrado = new Array() , auxperiodo = new Array();
            for(w=0; w< sli.length; w++){
                //var ee = sli[w];
                auxDatos.push(sli[w].noUiSlider.get());
                auxPosgrado.push($('.posgrado')[w].value);
                auxperiodo.push($('.periodo')[w].value);
            }
            console.log(auxDatos);
            var content = $('#contenido').val();
            
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {  nombres: $('#titulo').val(),
                         contenido: content,
                         slider: auxDatos,
                         posgrado: auxPosgrado,
                         periodo: auxperiodo
                    },
                url: "{{route('modalidad.store')}}",
                type: "POST",
                //contentType: false,
                //cache: false,
                //processData: false,
                success: function (data) {
                    $('#modalidadForm').trigger("reset");
                    $('#modalidad-crud-modal').modal('hide');
                    $('#btn-save').html('Guardar');
                    //recargar serverside
                    var oTable = $('#modalidad').dataTable();
                    oTable.fnDraw(false);
                    //recargar sin serverside
                    //$('#instituciones').DataTable().ajax.reload();
                    $("#mensaje-acciones").text("Not5icia registrada exitosamente.");
                    $("#mensaje-acciones").fadeIn();
                    $('#mensaje-acciones').delay(3000).fadeOut();
                    $('#mensaje-acciones').addClass('alert-success');
                    $('#mensaje-acciones').removeClass('alert-warning');
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                    $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
                },
                error: function (data) {
                    if (data.status == 422) {
                        var errores = data.responseJSON['errors'];
                        var key2;
                        $.each(errores, function (key, value) {
                            key2= key.replace('.','\\.');
                            $('#' + key2 + '_error').text(value);
                            console.log(($('#' + key + "_error")));
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
        var modalidad_id = $(this).data("id");
        $.confirm({
            columnClass: 'col-md-6',
            title: '¿Desea eliminar la modalidad titulada ' + titulo + '?',
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
                            url: "{{ url('modalidad')}}" + '/' + modalidad_id,
                            success: function (data) {
                                var oTable = $('#modalidad').dataTable();
                                if (table.data().count() == 1) {
                                    $('#modalidad').DataTable().ajax.reload();
                                } else {

                                    oTable.fnDraw(false);
                                }
                                $("#mensaje-acciones").text("Noticia eliminada exitosamente.");
                                $("#mensaje-acciones").fadeIn();
                                $('#mensaje-acciones').delay(3000).fadeOut();
                                $('#mensaje-acciones').addClass('alert-warning');
                                $('#mensaje-acciones').removeClass('alert-success');
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
        var modalidad_id = $(this).data("id");
        $.confirm({
            columnClass: 'col-md-6',
            title: '¿Desea reactivar la modalidad titulada ' + titulo + '?',
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
                            url: "{{ url('admin/modalidad/reactivar')}}" + '/' + modalidad_id,
                            success: function (data) {
                                var oTable = $('#modalidad').dataTable();
                                if (table.data().count() == 1) {
                                    $('#modalidad').DataTable().ajax.reload();
                                } else {

                                    oTable.fnDraw(false);
                                }
                                $("#mensaje-acciones").text("Noticia activada exitosamente.");
                                $("#mensaje-acciones").fadeIn();
                                $('#mensaje-acciones').delay(3000).fadeOut();
                                $('#mensaje-acciones').addClass('alert-warning');
                                $('#mensaje-acciones').removeClass('alert-success');
                                //$('#instituciones').DataTable().ajax.reload(null, false);
                                //$('#instituciones').DataTable().ajax.reload();
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

    $('.preview-btn').on('click', function(e) {
            e.preventDefault();
            var h = screen.availHeight - 150;
            var w = screen.availWidth - 200;
            var left = (screen.availWidth/2)-(w/2);
            var top = (screen.availHeight/2)-(h/2)-50;
            var configuracion_ventana = "location=no,resizable=yes,scrollbars=yes,status=no,width=" + w + ",height=" + h+ ",top=" + top+ ",left=" + left;
            var newWin = document.open('', 'Vista previa', configuracion_ventana);
            
            //var newWin = window.open('', "fullscreen", 'top=0,left=0,width='+(screen.availWidth)+',height ='+(screen.availHeight)+',fullscreen=yes,toolbar=0 ,location=0,directories=0,status=0,menubar=0,resiz able=0,scrolling=0,scrollbars=0');
            
            newWin.document.write('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">');
            newWin.document.write('<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"><\/script>');
            newWin.document.write('<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"><\/script>');
            newWin.document.write('<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"><\/script>');
            newWin.document.write('<h1 class="display-1 w-75 mx-auto"> '+$("#titulo").val()+'<\/h1>');
            newWin.document.write('<div class="w-75 mx-auto" style="word-wrap: break-word;">' + $('.summernote').summernote('code') + '<\/div>');
            newWin.document.write('<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"><img src="'+vistaPrevia.src+'" alt="" id="vistaPrevia" class="img-fluid mx-auto"></div>');
            newWin.document.close();
            
        });


    $('#btn-close').click(function () {
        $('.mensajeError').text("");
        $('#contenido').summernote("reset");
        $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
        
    });
    var x = 1;
    var y = 1;
    var crearRenglon = function(agregar){
        for (var index = 0; index < agregar; index++) {
            var auxid;
            $('.nr').each(function (i) {
                auxid = $(this)[0].id;
            });
            $('#'+auxid).after('<div class="row sliderQuitar nr" id="nuevorenglon_'+(x+1)+'"><div class="form-group col-3"> <strong><label for="posgrado" class="control-label">Nivel</label></strong> <select class="form-control posgrado" id="posgrado" name="posgrado"><option selected value="">Seleccione el grado</option><option value="maestria">Maestria</option><option value="doctorado">Doctorado</option></select><small><span class="text-danger mensajeError" id="id_institucion_error"></span></small></div><div class="form-group col-3"><strong><label for="periodo" class="control-label">Nivel</label></strong><select class="form-control periodo" id="periodo" name="periodo"><option selected value="">Seleccione el grado</option><option value="trimestre">Trimestre</option><option value="cuatrimestre">Cuatrimestre</option><option value="semestre">Semestre</option></select><small><span class="text-danger mensajeError" id="id_institucion_error"></span></small></div><div class="form-group col-5 pl-3 pb-3"><strong><label for="id_institucion" class="control-label">Grado</label></strong><br><div id="slider'+ x +'" class="sliderrr"></div></div><div class="form-group col-1 d-flex align-items-center"><i class="fas fa-times btn btn-danger " onclick="quitar('+(x+1)+')"></i></div></div>');
            var slider ;
                slider = document.getElementById('slider'+x);
                    noUiSlider.create(slider, {
                        start: [1, 10], //num, [num], [num,num]
                        format: wNumb({
                            decimals: 0
                        }),
                        pips: {
                            mode: 'steps',
                            density: 3,
                            filter: filterPips,
                            format: wNumb({
                                decimals: 0,

                            })
                        },
                        range: {
                            'min': [1],
                            'max': [10]
                        },
                        behaviour: 'drag',
                        connect: true,
                        animate: true,
                        step: 1,
                        orientation: 'horizontal',
                        tooltips: [true, true],
            });
            x++;
            y++;
        }
        
    }
    function reiniciar() {
        $('.sliderQuitar').remove();
        $('#contenido').summernote("reset");
        $('.mensajeError').text("");
    }

</script>



@endsection

@section('estilos')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="/css/datatable/colores.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
<style>
    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }

    .busqueda {
        border: 1px solid #ced4da;
        padding: .375rem .75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: .25rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;

    }

    .busqueda:focus {
        color: #495057;
        background-color: #fff;
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
    }

</style>
<link rel="stylesheet" href="/css/imagenes/imagenes.css">
<link rel="stylesheet" href="/css/modales/modalresponsivo.css">
<link href="/plugins/summernote/summernote-bs4.css" rel="stylesheet">
<!--
<link href="/css/summer/summernote-list-styles-bs4.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.css" rel="stylesheet">

    Nuevo Rente
-->
<link rel="stylesheet" href="/css/admin/styleRange.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.1/css/bootstrap-slider.css">
<link rel="stylesheet" href="/plugins/nouislider/nouislider.css">
<style>
    html {
        overflow-y: scroll;
    }

    .custom-file-input~.custom-file-label::after {
        content: "Elegir";
    }

    .ck-editor__editable {
        min-height: 290px;
        max-height: 290px;
    }

    .cke_show_borders {
        overflow-y: scroll; // vertical scrollbar
    }
</style>
<style>
    .noUi-connect {
        background: blue !important;
    }

    .noUi-value-sub {
        color: black !important;
        font-size: 10px;
    }
    .noUi-horizontal .noUi-tooltip {
        bottom: -36px !important;
    }
</style>
@endsection