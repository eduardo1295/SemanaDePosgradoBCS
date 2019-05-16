@extends('admin.plantilla')
@section('contenido')


<div class="container-fluid" id="#contenedor">

    <div class="row">
        <div class="col-12 mx-auto">
            <h1>
                Noticias
            </h1>
        </div>

        <div id="mensaje-acciones" class="col-12 alert alert-success alert-dismissible" role="alert"
            style="display:none">
            <strong> </strong>
        </div>
    </div>
    <div class="row mb-3">
        <legend class="col-form-label col-12 col-md-2 col-lg-2 pt-0">Mostras noticias</legend>
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
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="crear-noticia"><span><i
                            class="fas fa-plus"></i></span> Nueva Noticia</a>

            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="display" cellspacing="0" style="width:100%" id="noticias">
                <thead>
                    <tr>
                        <th>id_noticia</th>
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
@include('noticias.modal')
<div id="snackbar"></div>
<div id="snackbarError" style="z-index:1051;"></div>
@endsection
@section('scripts')
<!--<script src="{{ asset('/vendors/ckeditor/ckeditor.js') }}"></script>
<script src="/vendors/ckeditor5/ckeditor.js"></script>-->


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
<script src="/plugins/summernote/plugin/findnreplace/summernote-text-findnreplace.js"></script>
-->
<script src="/js/imagenes/vistaprevia.js"></script>
<script src="/plugins/summernote/summernote-bs4.js"></script>
<script src="/plugins/summernote/lang/summernote-es-ES.js"></script>

<script src="/plugins/summernote/plugin/cleaner/summernote-cleaner.js"></script>
<script src="/js/snack/snack.js"></script>
<script>



    var checkInsti = 'activos';
    var titulo = "";
    var table = "";
    $(document).ready(function () {
        $('.note-statusbar').hide();
        $("#show-sidebar").click(function () {
            $('#noticias').DataTable().ajax.reload(null, false);
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
                            // when loaded file, img's src set datauri

                            var img = $("<img>").attr({ src: reader.result, width: "50%", style: "margin:1px;float: left;", class: "img-responsive note-float-left" }); // << Add here img attributes !

                            $("#contenido").summernote("insertNode", img[0]);
                        }

                        if (file) {
                            // convert fileObject to datauri
                            reader.readAsDataURL(file);
                        }
                    }

                },
                //toolbarContainer: '.my-toolbar',

                placeholder,
                lang: 'es-ES', // Change to your chosen language
                disableResizeEditor: true,
                dialogsInBody: true,
                dialogsFade: false,
                shortcuts: false,
                disableDragAndDrop: true,
                height: 200,                 // set editor height
                minHeight: 200,             // set minimum height of editor
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
                        ['float', ['floatLeft', 'floatRight', 'floatNone']],
                        ['remove', ['removeMedia']]
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
            registerSummernote('.summernote', 'Contenido de la noticia', 500, function (max) {
                $('#maxContentPost').text(max)
            });
        });


        $.extend($.fn.dataTableExt.oStdClasses, {
            "sFilterInput": "busqueda",
            "sLengthSelect": ""
        });

        $('#noticias tfoot  th.text-input').each(function (i) {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="' + title + '" name="' + i + '" />');
        });

        table = $('#noticias').DataTable({
            "order": [[ 3, "desc" ]],
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
                "url": '{{ route("noticia.listNoticias")}}',
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
                { data: 'titulo',  orderable: false, searchable: true },
                { data: 'resumen',  orderable: false, searchable: true },
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
            $('#noticias').DataTable().ajax.reload();
        });

        $('#noticias tbody').on('click', '.eliminar, .reactivar', function (e) {
            var tr = $(this).closest("tr");
            var data = $("#noticias").DataTable().row(tr).data();
            titulo = data.titulo;

        });



    });



    /*Al presionar el boton editar*/
    $('body').on('click', '.editar', function () {
        reiniciar();
        var noticia_id = $(this).data('id');
        var ruta = "{{url('noticia')}}/" + noticia_id + "/editar";


        $.get(ruta, function (data) {
            $('#noticiaCrudModal').html("Editar noticia: " + data.titulo);
            $('#btn-save').val("editar");
            $('#noticia-crud-modal').modal('show');
            $('#noticia_id').val(data.id_noticia);
            $('#titulo').val(data.titulo);
            $('#resumen').val(data.resumen);

            $('#contenido').summernote('code', data.contenido);
        })
    });


    /*Accion al presionar el boton crear-noticia*/
    $('#crear-noticia').click(function () {
        reiniciar();
        $('#btn-save').val("crear-noticia");
        $('#noticia_id').val('');
        $('#noticiaForm').trigger("reset");
        $('#noticiaCrudModal').html("Agregar nueva noticia");
        $('#noticia-crud-modal').modal({ backdrop: 'static', keyboard: false })
        $('#noticia-crud-modal').modal('show');
    });

    $('.modal-btn').click(function () {
        $('#btn-save').val("crear-noticia");
        $('#noticia_id').val('');
        $('#noticiaForm').trigger("reset");
        $('#noticiaCrudModal').html("Agregar nueva institución");
        $('#noticia-crud-modal').modal({ backdrop: 'static', keyboard: false })
        $('#noticia-crud-modal').modal('show');
    });


    /*Accion al presionar el boton save*/
    $("#btn-save").click(function () {
        $('.mensajeError').text("");
        $("#btn-save").prop("disabled", true);
        $("#btn-close").prop("disabled", true);
        var actionType = $('#btn-save').val();
        $('#btn-save').html('Guardando..');
        if (actionType == "editar") {
            var id = $('#noticia_id').val();
            var ruta = "{{url('noticia')}}/" + id + "";
            var datos = new FormData($("#noticiaForm")[0]);
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
                    $('#noticiaForm').trigger("reset");
                    $('#noticia-crud-modal').modal('hide');
                    $('#btn-save').html('Guardar');
                    //recargar serverside
                    var oTable = $('#noticias').dataTable();
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
        } else if (actionType == "crear-noticia") {
            $("#btn-save").prop("disabled", true);
            $("#btn-close").prop("disabled", true);

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: new FormData($("#noticiaForm")[0]),
                url: "{{route('noticia.store')}}",
                type: "POST",
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $('#noticiaForm').trigger("reset");
                    $('#noticia-crud-modal').modal('hide');
                    $('#btn-save').html('Guardar');
                    //recargar serverside
                    var oTable = $('#noticias').dataTable();
                    oTable.fnDraw(false);
                    //recargar sin serverside
                    mostrarSnack("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Noticia guardada exitosamente.");;
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
        }

    });

    /*Accion al presionar el boton eliminar*/
    $('body').on('click', '.eliminar', function () {
        var noticia_id = $(this).data("id");
        $.confirm({
            columnClass: 'col-md-6',
            title: '¿Desea eliminar la noticia titulada ' + titulo + '?',
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
                            url: "{{ url('noticia')}}" + '/' + noticia_id,
                            success: function (data) {
                                var oTable = $('#noticias').dataTable();
                                if (table.data().count() == 1) {
                                    $('#noticias').DataTable().ajax.reload();
                                } else {

                                    oTable.fnDraw(false);
                                }
                                mostrarSnack("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Noticia eliminada exitosamente.");
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
        var noticia_id = $(this).data("id");
        $.confirm({
            columnClass: 'col-md-6',
            title: '¿Desea reactivar la noticia titulada ' + titulo + '?',
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
                            url: "{{ url('admin/noticia/reactivar')}}" + '/' + noticia_id,
                            success: function (data) {
                                var oTable = $('#noticias').dataTable();
                                if (table.data().count() == 1) {
                                    $('#noticias').DataTable().ajax.reload();
                                } else {

                                    oTable.fnDraw(false);
                                }
                                mostrarSnack("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Noticia activada exitosamente.");
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
            data: new FormData($("#noticiaForm")[0]),
            url: "{{route('noticia.vistaPrevia')}}",
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

    function reiniciar() {
        $('.mensajeError').text("");
        $('#contenido').summernote("reset");
        $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
    }

</script>



@endsection

@section('estilos')

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
</style>
@endsection