@extends('admin.plantilla')
@section('contenido')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mx-auto">
            <h1>Diseño constancia de participación</h1>
        </div>
    </div>
{{-- 
    <div class="d-xl-none">
        <div class="row">
            <div class="col-12" style="text-align:center;color:red">
                <h2>Es necesario un dispositivo con pantalla más grande para editar el diseño de la constancia</h2>
            </div>
        </div>
    </div>
 --}}
    <div>
        <div class="row">
            <div class="col-12 mx-auto">
                <form id="constanciaForm" name="constanciaForm" class="form-horizontal" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="logo" class="col-2 col-form-label" style="text-align:end">Imagen de Fondo</label>
                        <div class="custom-file col-8">
                            <input type="file" name="fondo" class="custom-file-input" id="fondo" lang="es"
                                onchange="readURL(this,'vistaPrevia');">
                            <label for="fondo" class="custom-file-label">Seleccionar Archivo</label>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-primary btnGuardarDiseno">Guardar</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div id="gjs" class="mx-auto">
                </div>
            </div>
        </div>

    </div>
    @endsection
    @section('scripts')
    <script>
        var imagenes = @json($imagenes);
        var coordinadores = @json($coordinadores);
        var constancia = @json($constancia);
        var rutaImagenes = "{{ route('constancia.guardarImagenes')}}";
    </script>
    
    <script src="{{ asset('/plugins/grapesjs/js/vistaprevia.js') }}"></script>
    <script src="{{ asset('/plugins/grapesjs/js/grapesjs.js') }}"></script>
    <script src="{{ asset('/plugins/grapesjs/js/gjs-blocks-basic.js') }}"></script>
    {{--<script src="{{ asset('/plugins/grapesjs/js/grapesjs/grapesjs-touch.min.js') }}"></script>--}}
    <script src="{{ asset('/plugins/grapesjs/js/gjs-conf2.js') }}"></script>
    
    <script>
      
      var id;
$(window).resize(function() {
    clearTimeout(id);
        id = setTimeout(doneResizing, 500);
});

function doneResizing(){
    if(screen.width === window.innerWidth){
            var resPantalla = document.body.scrollWidth-$(window).width()-260*2-40;
            const element = document.querySelector("#menuAd");

            document.getElementById('contenedor').setAttribute("style","width: calc(100% + "+resPantalla+"px);z-index:0;background:#ececec;");
    }else{
    var tPantalla = $(window).width();
            var x = document.body.scrollWidth-tPantalla;
            document.getElementById('contenedor').setAttribute("style","width: calc(100% + "+x+"px);z-index:0;background:#ececec;");
    }
}

        var ruta = "{{ route('constancia.store')}}";
        var componenetes = "";
        $(document).ready(function () {
            var tPantalla = $(window).width();
            var x = document.body.scrollWidth-tPantalla;
            document.getElementById('contenedor').setAttribute("style","width: calc(100% + "+x+"px);z-index:0;background:#ececec;");
            if (constancia[0].url_imagen_fondo != "") {
                var unique = $.now();
                $(".gjs-frame").contents().find("#wrapper").css('background-image', 'url("' + constancia[0]
                    .url_imagen_fondo + '/?' + unique + '")');
                $(".gjs-frame").contents().find("#wrapper").css('background-size', '100% 100%');
                $(".gjs-frame").contents().find("#wrapper").css('background-repeat', 'no-repeat');
            }
        });

        $('.btnprueba').click(function () {
            const domComponents = JSON.stringify(editor.getComponents());
            var sinquotes = JSON.stringify(domComponents);
            var HtmlE = editor.getHtml();
            var CssE = editor.getCss();
            var componente = editor.getComponents('gjs-components');
            const head = editor.Canvas.getDocument().body;
            const all = getAllComponents(editor.DomComponents.getWrapper());
            const x = JSON.stringify(componente);
            var imagen = $(".gjs-frame").contents().find("#wrapper").css('background-image');
            imagen = imagen.replace('url(', '').replace(')', '').replace(/\"/gi, "");
            
        })

        $('.btnGuardarDiseno').click(function () {
            $('.mensajeError').text("");
            $(".btnGuardarDiseno").prop("disabled", true);
            $("#btn-close").prop("disabled", true);
            var actionType = $('#btn-save').val();
            $('.btnGuardarDiseno').html('Guardando...');
            var datos = new FormData($("#constanciaForm")[0]);
            const domComponents = JSON.stringify(editor.getComponents());
            var HtmlE = editor.getHtml();
            var CssE = editor.getCss();
            datos.append('cComponentes', domComponents);
            datos.append('cHTML', HtmlE);
            datos.append('cCSS', CssE);
            
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: ruta,
                type: "POST",
                data: datos,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    $(".loader").show();
                },
                success: function (data) {                    
                    var unique = $.now();
                    $(".gjs-frame").contents().find("#wrapper").css('background-image', 'url("' +
                        data.url_imagen_fondo + '/?' + unique + '")');
                    $(".gjs-frame").contents().find("#wrapper").css('background-size', '100% 100%');
                    $(".gjs-frame").contents().find("#wrapper").css('background-repeat',
                        'no-repeat');
                    $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
                    mostrarSnack("Cambios guardados exitosamente");
                },
                error: function (data) {
                    if (data.status == 422) {
                        var errores = data.responseJSON['errors'];
                        $.each(errores, function (key, value) {
                            $('#' + key + "_error").text(value);
                        });
                    }
                    mostrarSnackError("Error al guardar los cambios");
                },
                complete: function (data) {
                    $(".btnGuardarDiseno").prop("disabled", false);
                    $(".btnGuardarDiseno").prop("disabled", false);
                    $('.btnGuardarDiseno').html('Guardar');
                    $(".loader").hide();

                }

            });


        })


        const getAllComponents = (model, result = []) => {
            result.push(model);
            model.components().each(mod => getAllComponents(mod, result))
            return result;
        }

    </script>
    <script>
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
    
    <link rel="stylesheet" href="{{ asset('/plugins/grapesjs/css/grapes.min.css') }}">
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
        }

        .gjs-badge {
            display: none !important
        }

        .gjs-clm-tags,
        .gjs-devices-c,
        .gjs-pn-devices-c {
            display: none !important
        }

        .gjs-pn-views {
            border-bottom: 2px solid rgba(0, 0, 0, 0.2);
            right: -198px;
            width: 190px;
            z-index: 4
        }

        .gjs-pn-views-container {
            height: 600px;
            padding: 42px 0 0;
            right: -198px;
            width: 190px;
            overflow: auto;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }


        .custom-file-input~.custom-file-label::after {
            content: "Elegir";
        }

    </style>


    @endsection
