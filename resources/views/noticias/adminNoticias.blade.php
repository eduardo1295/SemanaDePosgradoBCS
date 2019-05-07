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
-->

<script src="/js/summer/summernote-bs4.js"></script>
<script src="/js/summer/summernote-es-ES.js"></script>
<script src="/js/summer/summernote-text-findnreplace.js"></script>
<script src="/js/summer/summernote-list-styles-bs4.js"></script>
<script src="/js/summer/summernote-cleaner.js"></script>
<script src="/js/imagenes/vistaprevia.js"></script>

<script>



    var checkInsti = 'activos';
    var titulo = "";
    var table = "";
    $(document).ready(function () {
        
        $("#show-sidebar").click(function () {
            $('#noticias').DataTable().ajax.reload(null, false);
        });

        function registerSummernote(element, placeholder, max, callbackMax) {
            $(element).summernote({
                //toolbarContainer: '.my-toolbar',

                placeholder,
                lang: 'es-ES', // Change to your chosen language

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


                    ['para', ['ul', 'ol', 'listStyles', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'hr']],
                    ['view', ['fullscreen']], //, 'codeview'
                    ['custom', ['findnreplace']],
                ],
                popover: {
                    image: [
                        ['custom', ['imageTitle']],
                        ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
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
            registerSummernote('.summernote', 'Contenido de la noticia', 50, function (max) {
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
                { data: 'titulo', searchable: true },
                { data: 'resumen', searchable: true },
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
            //$('#imglogo').prop('src',"");
            if (data.url_imagen != "sin imagen") {
                $('#logoactual').html('Imagen actual de la noticia');
                $('#imglogo').prop('src', "{{url('img/noticias')}}/" + data.url_imagen);
            } else {
                $('#logoactual').html('');
            }
        })
    });


    /*Accion al presionar el boton crear-noticia*/
    $('#crear-noticia').click(function () {

        $('#btn-save').val("crear-noticia");
        $('#noticia_id').val('');
        $('#noticiaForm').trigger("reset");
        $('#noticiaCrudModal').html("Agregar nueva noticia");
        $('#noticia-crud-modal').modal({ backdrop: 'static', keyboard: false })
        $('#noticia-crud-modal').modal('show');
        $('#imglogo').prop('src', "");

        $('#logoactual').html('');
    });

    $('.modal-btn').click(function () {
        $('#btn-save').val("crear-noticia");
        $('#noticia_id').val('');
        $('#noticiaForm').trigger("reset");
        $('#noticiaCrudModal').html("Agregar nueva institución");
        $('#noticia-crud-modal').modal({ backdrop: 'static', keyboard: false })
        $('#noticia-crud-modal').modal('show');
        $('#imglogo').prop('src', "");
        //$('#imglogo').width('0').height('0');
        $('#logoactual').html('');
    });


    /*Accion al presionar el boton save*/
    $("#btn-save").click(function () {
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

    .fullscreen-modal .modal-dialog {

        margin-right: auto;
        margin-left: auto;
        max-width: 100%;
    }

    @media (min-width: 768px) {
        .fullscreen-modal .modal-dialog {
            max-width: 750px;
        }
    }

    @media (min-width: 992px) {
        .fullscreen-modal .modal-dialog {
            max-width: 90%;
        }
    }

    @media (min-width: 1200px) {
        .fullscreen-modal .modal-dialog {
            max-width: 70%;
        }
    }
</style>

<link href="/css/summer/summernote-list-styles-bs4.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.css" rel="stylesheet">
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
@endsection