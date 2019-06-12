@extends('admin.plantilla')
@section('estilos')
<link rel="stylesheet" href="/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
<link href="/css/modales/snackbar.css" rel="stylesheet">
<style>
    .colorpicker.colorpicker-2x {
        width: 272px;
    }

    .colorpicker-2x .colorpicker-saturation {
        width: 200px;
        height: 200px;
    }

    .colorpicker-2x .colorpicker-hue,
    .colorpicker-2x .colorpicker-alpha {
        width: 30px;
        height: 200px;
    }

    .colorpicker-2x .colorpicker-alpha,
    .colorpicker-2x .colorpicker-preview {
        background-size: 20px 20px;
        background-position: 0 0, 10px 10px;
    }

    .colorpicker-2x .colorpicker-preview,
    .colorpicker-2x .colorpicker-preview div {
        height: 30px;
        font-size: 16px;
        line-height: 160%;
    }

    .colorpicker-saturation .colorpicker-guide {
        height: 10px;
        width: 10px;
        border-radius: 10px;
        margin: -5px 0 0 -5px;
    }
</style>
@endsection
@section('contenido')
<div class="container-fluid" id="#contenedor">
    <div class="row">
        <div class="col-12 mx-auto">
            <h1>Diseño Colores</h1>
        </div>
    </div>
    <form id="colorForm" name="colorForm" class="form-horizontal" enctype="multipart/form-data">
        <div class="row">
            <div class="col-12 mt-3">
                <strong><label for="">Encabezados de información, noticias, sede e intituticiones participantes</label></strong>
                <div class="row">
                    <div class="col-6">
                        <strong><label for="">Color de fondo</label></strong>
                        <div id="navbar" class="input-group colores">
                            @if(isset($vistas[2]->url_imagen))
                                <input type="text" class="form-control input-lg" id="encabezadoFondo" name="encabezadoFondo" value="{{$vistas[2]->url_imagen}}" />
                            @else
                                <input type="text" class="form-control input-lg" id="encabezadoFondo" name="encabezadoFondo" value="#dad6d6" />
                            @endif
                            <span class="input-group-append">
                                <span class="input-group-text colorpicker-input-addon"><i></i></span>
                            </span>
                        </div>
                    </div>
                    <div class="col-6">
                        <strong><label for="">Color del texto</label></strong>
                        <div id="texto" class="input-group colores">
                            @if(isset($vistas[3]->url_imagen))
                                <input type="text" class="form-control input-lg" id="encabezadoTexto" name="encabezadoTexto" value="{{$vistas[3]->url_imagen}}" />
                            @else
                            <input type="text" class="form-control input-lg" id="encabezadoTexto" name="encabezadoTexto" value="#000000" />
                            @endif
                            <span class="input-group-append">
                                <span class="input-group-text colorpicker-input-addon"><i></i></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3">
                <strong><label for="">Contenidos de información, noticias, sede e intituticiones participantes</label></strong>
                <div class="row">
                    <div class="col-6">
                        <strong><label for="">Color de fondo</label></strong>
                        <div id="navbar" class="input-group colores">
                            @if(isset($vistas[4]->url_imagen))
                            <input type="text" class="form-control input-lg" id="contenidoFondo" name="contenidoFondo" value="{{$vistas[4]->url_imagen}}" />
                            @else
                            <input type="text" class="form-control input-lg" id="contenidoFondo" name="contenidoFondo" value="#eeeeee" />
                            @endif
                            <span class="input-group-append">
                                <span class="input-group-text colorpicker-input-addon"><i></i></span>
                            </span>
                        </div>
                    </div>
                    <div class="col-6">
                        <strong><label for="">Color del texto</label></strong>
                        <div id="texto" class="input-group colores">
                            @if(isset($vistas[5]->url_imagen))
                            <input type="text" class="form-control input-lg" id="contenidoTexto" name="contenidoTexto" value="{{$vistas[5]->url_imagen}}" />
                            @else
                            <input type="text" class="form-control input-lg" id="contenidoTexto" name="contenidoTexto" value="#000000" />
                            @endif
                            <span class="input-group-append">
                                <span class="input-group-text colorpicker-input-addon"><i></i></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3 d-flex justify-content-end">
                <button class="btn btn-primary btn-guardar"  id="" type="button">Guardar</button>
            </div>
        </div>
    </form>
</div>
<div id="snackbar"></div>
@endsection
@section('scripts')
<script src="/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script>

    $(document).ready(function () {
        $('.custom-file-input').on('change', function () {
            let fileName = $(this).val().split('\\').pop();
            if (!fileName.trim()) {
                $(this).next('.custom-file-label').removeClass("selected").html('Ningún archivo seleccionado');
                readURL(this, 'vistaPrevia1')
            } else {
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            }
        });

        $('.btn-guardar').on('click', function () {
            var datos = new FormData($("#colorForm")[0]);
            console.log(Array.from(datos));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: datos,
                //url: "{{route('VistaLogin.store')}}",
                url: "/admin/cambiarColores",
                type: "POST",
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    var unique = $.now();
                    $("#snackbar").html("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Colores actualizados exitosamente.");
                    $("#snackbar").addClass("show");
                    setTimeout(function () { $("#snackbar").removeClass("show"); }, 5000);
                    $('#nuevaImagen').addClass('d-none');
                    $('#nuevaImagen2').addClass('d-none');
                    $('#vistaPrevia').prop('src', "");
                    $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);

                },


            });
        })
    });
    function readURL(input, idimg, contenedor) {

        if (input.files && input.files[0]) {
            $('#' + contenedor).removeClass('d-none');
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#' + idimg)
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);

        }
        else {
            $('#' + idimg)
                .attr('src', '');
            $('#' + contenedor).addClass('d-none');
        }
    }

    function mostrar(idMostrar) {
        //$('#' + idMostrar).removeClass('d-none');
    }
</script>
<script>
    $(function () {
        $('.colores').colorpicker({
            format: 'auto'
        });
        $('.colores').colorpicker({
            format: null
        });
    });
</script>
@endsection