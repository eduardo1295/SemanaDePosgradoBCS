@extends('admin.plantilla')
@section('contenido')

<!--
<div class="container-fluid" id="#contenedor">
    
    
</div>
-->
<div class="container-fluid">

    <!-- <button class="btn btnprueba">presiona aqui</button>-->
    <div class="row">
        <div class="col-12 mx-auto">
            <h1>Diseño de constancia</h1>
        </div>
    </div>

    <div class="d-xl-none">
        <div class="row">
            <div class="col-12" style="text-align:center;color:red">
                <h2>Es necesario un dispositivo con pantalla más grande para editar el diseño de la constancia</h2>
            </div>
        </div>
    </div>

    <div class="d-none d-xl-block">
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
                        <div class="col-2 d-flex ">
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
    <!--
        <style>
          .panel {
            width: 90%;
            max-width: 700px;
            border-radius: 3px;
            padding: 30px 20px;
            margin: 150px auto 0px;
            background-color: #d983a6;
            box-shadow: 0px 3px 10px 0px rgba(0,0,0,0.25);
            color:rgba(255,255,255,0.75);
            font: caption;
            font-weight: 100;
          }
          .description {
            text-align: justify;
            font-size: 1rem;
            line-height: 1.5rem;
          }
          #wrapper{
            padding: 0px !important;
          }
          
        </style>
      -->
    @endsection
    @section('extra')
    <!--
    <div id="snackbar"></div>
    <div id="loader" class="loader"></div>
-->
    @endsection
    @section('scripts')
    <script>
        var imagenes = @json($imagenes);
        var coordinadores = @json($coordinadores);
        var constancia = @json($constancia);

        var rutaImagenes = "{{ route('constancia.guardarImagenes')}}";
        console.log(coordinadores);

    </script>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>-->
    <script src="{{ asset('/plugins/grapesjs/js/vistaprevia.js') }}"></script>
    <script src="{{ asset('/plugins/grapesjs/js/grapesjs.js') }}"></script>
    <script src="{{ asset('/plugins/grapesjs/js/gjs-blocks-basic.js') }}"></script>
    <!--<script src="{{ asset('/plugins/grapesjs/js/grapesjs/grapesjs-touch.min.js') }}"></script>-->
    <script src="{{ asset('/plugins/grapesjs/js/gjs-conf2.js') }}"></script>
    <script src="/js/snack/snack.js"></script>
    <script>
      $(window).resize(function() {
        $('.redimensionar').width($('body').width());
        
      });
        var ruta = "{{ route('constancia.store')}}";
        var componenetes = "";
        $(document).ready(function () {
          //$('.redimensionar').width($(window).width()-40)
            $('#tamano').attr('content', '');
            $('#menuAd').removeClass('toggled');
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
            //var wrapperChildren = domComponents.getComponents();
            console.log(domComponents);
            var sinquotes = JSON.stringify(domComponents);
            var HtmlE = editor.getHtml();
            var CssE = editor.getCss();
            var componente = editor.getComponents('gjs-components');
            //console.log(HtmlE);
            console.log(CssE);
            const head = editor.Canvas.getDocument().body;
            const all = getAllComponents(editor.DomComponents.getWrapper());
            console.log(all);
            const x = JSON.stringify(componente);
            //var cuerpo = $(".gjs-frame").contents().find("body")[0].scrollHeight
            //console.log(cuerpo);
            var imagen = $(".gjs-frame").contents().find("#wrapper").css('background-image');
            //console.log(imagen);
            imagen = imagen.replace('url(', '').replace(')', '').replace(/\"/gi, "");
            //      console.log(imagen);
        })

        $('.btnGuardarDiseno').click(function () {
            $('.mensajeError').text("");
            $(".btnGuardarDiseno").prop("disabled", true);
            $("#btn-close").prop("disabled", true);
            var actionType = $('#btn-save').val();
            $('.btnGuardarDiseno').html('Guardando...');

            //var wrapperChildren = domComponents.getComponents();

            var datos = new FormData($("#constanciaForm")[0]);
            const domComponents = JSON.stringify(editor.getComponents());
            var HtmlE = editor.getHtml();
            var CssE = editor.getCss();
            //var id = $('#semana_id').val();


            datos.append('cComponentes', domComponents);
            datos.append('cHTML', HtmlE);
            datos.append('cCSS', CssE);
            //datos.append('_method', 'PUT');
            console.log(Array.from(datos));
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
                    console.log(data);
                    //mostrarSnack("Actualización exitosa.");
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
                    /*var unique = $.now();
                    if (data.responseJSON['vigente'] == 1) {
                        $('#logoMenu').prop('src', '{{ URL::to("/") }}/img/semanaLogo/' + data
                            .responseJSON['url_logo'] + '/?' + unique);
                    }*/
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
    @endsection

    @section('estilos')
    <link href="/css/modales/snackbar.css" rel="stylesheet">
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


        .page-wrapper .page-content>div {
            padding-left: 10px !important;
        }

        .custom-file-input~.custom-file-label::after {
            content: "Elegir";
        }

    </style>


    @endsection
