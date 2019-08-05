@extends('admin.plantilla')
@section('estilos')
<link rel="stylesheet" href="{{ asset('/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css')}} ">
<link rel="stylesheet" href="{{ asset('/css/modales/snackbar.css')}} ">
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
        <div class="col-12 d-flex d-md-block justify-content-center justify-content-md-start">
            <h1>Diseño colores</h1>
        </div>
    </div>
    <form id="colorForm" name="colorForm" class="form-horizontal" enctype="multipart/form-data">
        <div class="row">
            <div class="col-12 mt-3">
                <strong><label for="">Encabezado de información, noticias, sede e intituticiones participantes</label></strong>
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
                <strong><label for="">Contenido de información, noticias, sede e intituticiones participantes</label></strong>
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
<!--<div id="snackbar"></div>-->
@endsection
@section('scripts')

<script src="{{ asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>
<script src="{{ asset('js/admin/panelControl/colores.js') }}"></script>
<script>
var rutaBase = "{{route('vistaLogin.cambiarColores')}}"
</script>

@endsection