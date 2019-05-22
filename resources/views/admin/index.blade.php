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


<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>


<script src="/js/imagenes/vistaprevia.js"></script>
<script src="/plugins/summernote/summernote-bs4.js"></script>
<script src="/plugins/summernote/lang/summernote-es-ES.js"></script>

<script src="/plugins/summernote/plugin/cleaner/summernote-cleaner.js"></script>
<script src="/plugins/summernote/plugin/summernote-table-headers-master/summernote-table-headers.js"></script>
<script src="/plugins/summernote/plugin/list-styles-bs4/summernote-list-styles-bs4.js"></script>
<script src="/js/snack/snack.js"></script>


<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    $(function() {
      $('input[name="fecha"]').daterangepicker({
        opens: 'left',
        "locale": {
    "format": "YYYY-MM-DD",
    "separator": " - ",
    "applyLabel": "Aplicar",
    "cancelLabel": "Cancelar",
    "fromLabel": "De",
    "toLabel": "a",
    "customRangeLabel": "Custom",
    "daysOfWeek": [
        "do",
        "lu",
        "ma",
        "mi",
        "ju",
        "vi",
        "sá"
    ],
    "monthNames": [
        "énero",
        "febrero",
        "marzo",
        "abril",
        "mayo",
        "junio",
        "julio",
        "agusto",
        "septiembre",
        "octubre",
        "noviembre",
        "diciembre"
    ],
    "firstDay": 1
}
      });
    });
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

        function registerSummernote(element, placeholder, max, callbackMax) {
            $(element).summernote({
                callbacks: {
                    onInit: function () {
                        $(".note-editor").on('click', '.btn-fullscreen', function (e) {
                            $(".modal-dialog").toggleClass('modal100');
                        });
                    },
                    onImageUpload: function (files) {
                        if (!files.length) return;
                        var file = files[0];
                        // create FileReader
                        var reader = new FileReader();
                        reader.onloadend = function () {

                            var img = $("<img>").attr({ src: reader.result, width: "40%", style: "display:block;",class:"mx-auto img-fluid" }); // << Add here img attributes !

                            $("#contenido").summernote("insertNode", img[0]);
                        }

                        if (file) {
                            // convert fileObject to datauri
                            reader.readAsDataURL(file);
                        }
                    }

                },

                placeholder,
                lang: 'es-ES', 
                disableResizeEditor: true,
                dialogsInBody: true,
                dialogsFade: false,
                shortcuts: false,
                disableDragAndDrop: true,
                height: 200,                 
                minHeight: 200,
                maxHeight: 200,
                toolbar: [

                    ['color', ['color']],
                    ['style', ['style']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['picture'],

                    ['para', ['ul', 'ol', 'listStyles', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'hr']],
                    ['view', ['fullscreen']], //, 'codeview'
                ],
                popover: {
                    image: [
                        ['custom', ['imageTitle']],
                        ['imagesize', ['imageSize100', 'imageSize50']],
                        ['remove', ['removeMedia']]
                    ],
                    table: [
                        ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                        ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
                        ['custom', ['tableHeaders']]
                    ],
                },
                cleaner: {
                    action: 'both', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
                    newline: '<br>', // Summernote's default is to use '<p><br></p>'
                    notStyle: 'position:relative;top:0;left:0;right:0', // Position of Notification
                    icon: '<i class="note-icon">[Your Button]</i>',
                    keepHtml: false, // Remove all Html formats
                    keepOnlyTags: ['<p>', '<br>', '<ul>', '<li>', '<b>', '<strong>', '<i>', '<a>'], // If keepHtml is true, remove all tags except these
                    keepClasses: false, // Remove Classes
                    badTags: ['style', 'script', 'applet', 'embed', 'noframes', 'noscript', 'html'], // Remove full tags with contents
                    badAttributes: ['style', 'start'], // Remove attributes from remaining tags
                    limitChars: max, // 0/false|# 0/false disables option
                    limitDisplay: 'text', // text|html|both
                    limitStop: true // true/false
                },
                styleTags: ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
            });

        }




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
            "order": [[ 6, "desc" ]],
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
                { data: 'id', name: 'id', 'visible': false,searchable: false  },
                { data: 'nombre',  orderable: false, searchable: true },
                { data: 'instituciones[0].nombre',  orderable: false, searchable: true },
                { data: 'fecha_inicio',  orderable: false, searchable: false },
                { data: 'fecha_fin',  orderable: false, searchable: false },
                {
                    data: 'url_convocatoria',
                    name: 'url_convocatoria',
                    render: function (data, type, full, meta) {
                        if(data == "no_disponible")
                            return data.replace("_"," ");
                        else
                            return "<a target='_blank' href={{ URL::to('/') }}/pdf/convocatoria/" + data +">"+data+ "<a/>";
                    },
                    orderable: false, searchable: false
                },
                { data: 'fecha_actualizacion', searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            columnDefs: [
                { responsivePriority: 1, targets: 1 },
                { responsivePriority: 2, targets: 4 },
                { width: 105, targets: 4 }
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
            $('#fecha').val(data.fecha)
            $("#institucionSelect").val(data.instituciones[0].id);
            $('#contenido').summernote('code', data.contenido);
            $('#imglogo').prop('src', "{{url('img/semanaLogo')}}/" + data.url_logo);
            $('#logoactual').html('Logo actual');
            $('#logoAnterior').removeClass('d-none');
            if(data.url_convocatoria=='no_disponible')
                $('#ligaConvo').html('No se ha cargado convocatoria')
            else
                $('#ligaConvo').html('Convocatoria <a target="_blank" href={{ URL::to("/") }}/pdf/convocatoria/' + data.url_convocatoria +'>'+data.url_convocatoria+ '<a/>');
            
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
                    //console.log(data);
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
                                mostrarSnack("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> semana eliminada exitosamente.");
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
                                mostrarSnack("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> semana activada exitosamente.");
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

    $('.preview-btn').on('click', function (e) {

        e.preventDefault();
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: new FormData($("#semanaForm")[0]),
            url: "{{route('semana.vistaPrevia')}}",
            type: "POST",
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                win = window.open("", "_blank");
                win.document.write(data);
                win.document.close();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            },


        });
    });


    $('#btn-close').click(function () {

    });

    $('.preview-btn').on('click', function (e) {

        e.preventDefault();
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: new FormData($("#semanaForm")[0]),
            url: "{{route('semana.vistaPrevia')}}",
            type: "POST",
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                win = window.open("", "_blank");
                win.document.write(data);
                win.document.close();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            },


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
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">

<link rel="stylesheet" href="/css/datatable/colores.css">
<link rel="stylesheet" href="/css/imagenes/imagenes.css">
<link rel="stylesheet" href="/css/modales/modalresponsivo.css">
<link href="/plugins/summernote/summernote-bs4.css" rel="stylesheet">
<link href="/css/modales/snackbar.css" rel="stylesheet">

<style>
    .modal100 {
        max-width: 100% !important;
        margin: 0;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        height: 100vh !important;
        display: flex;
    }

    .modal {
        overflow-y: auto;
    }
    .custom-file-input~.custom-file-label::after {
        content: "Elegir";
    }
</style>
@endsection