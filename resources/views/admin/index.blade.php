@extends('admin.plantilla')
@section('contenido')
<div class="container-fluid" id="#contenedor">
    <h1>Configuración general</h1>
    <form id="semanaForm" name="semanaForm" class="form-horizontal" enctype="multipart/form-data">
        <input type="hidden" name="semana_id" id="semana_id">

        <div class="form-group">
            <label for="nombre" class="control-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre"
                value="" maxlength="100" required="">
            <span class="mensajeError" id="nombre_error"></span>

        </div>

        <div class="form-group">
            <label for="fecha" class="control-label">Periodo del evento</label>
            <input type="text"id="fecha" name="datetimes" class="form-control">
            <span class="mensajeError" id="fecha_inicio_error"></span>
            <span class="mensajeError" id="fecha_fin_error"></span>
        </div>

        <div class="form-row mt-2">
                <div class="form-group col-12">
                    <strong>Información genereal:</strong>
                    <textarea class="summernote"  style=" word-wrap: break-word;"  id="infoge" name="infoge"></textarea>
                  </div>
                  <span class="mensajeError" id="infoge_error"></span>
        </div>


        <div class="form-row">


            <div class="form-group col-md-6">
                <p id="logos"> Logo del evento:</p>
                <div class="custom-file">
                    <input type="file" name="imagensemana" class="custom-file-input" id="imagensemana" lang="es"
                        onchange="readURL(this,'vistaPrevia');mostrar('nuevaImagen');">
                    <label for="imagen" class="custom-file-label">Seleccionar Archivo</label>
                </div>

                <span class="mensajeError" id="imagensemana_error"></span>
                <div class="row">
                    <div id="imagenAnterior" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <label for="imgslide" id="imagenactualT" class="control-label"></label>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <img src="" alt="" id="imgslide" class="img-fluid mx-auto">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-6">
                <div id="nuevaImagen" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none">
                    <label for="imgni" id="textVP" class="control-label">Nueva logo</label>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <img src="" alt="" id="vistaPrevia" class="img-fluid mx-auto">
                    </div>
                </div>
            </div>

        </div>

    </form>
</div>
@endsection
@section('scripts')

    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    

    
    <script src="/js/summer/summernote-bs4.js"></script>
<script src="/js/summer/summernote-es-ES.js"></script>
<script src="/js/summer/summernote-text-findnreplace.js"></script>
<script src="/js/summer/summernote-list-styles-bs4.js"></script>
<script src="/js/summer/summernote-cleaner.js"></script>

    
    <script src="/js/imagenes/vistaprevia.js"></script>

    <script>

        

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
            registerSummernote('.summernote', 'Contenido de la noticia', 500, function (max) {
                $('#maxContentPost').text(max)
            });
        });

        $('.note-statusbar').hide();

    
    </script>

    <script>
        $(function() {
          $('input[name="datetimes"]').daterangepicker({
            timePicker: true,
            startDate: moment().startOf('hour'),
            endDate: moment().startOf('hour').add(32, 'hour'),
            "locale": {
        "format": "MM/DD/YYYY",
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
        $('.custom-file-input').on('change', function () {
        let fileName = $(this).val().split('\\').pop();
        if (!fileName.trim()) {
            $(this).next('.custom-file-label').removeClass("selected").html('Ningún archivo seleccionado');
        } else {
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        }
    })
    </script>
    
       
@endsection
@section('estilos')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link href="/css/summer/summernote-list-styles-bs4.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.css" rel="stylesheet">

<style>
        .custom-file-input~.custom-file-label::after {
            content: "Elegir";
        }
    </style>
@endsection