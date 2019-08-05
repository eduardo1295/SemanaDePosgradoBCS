@extends('admin.plantilla')
@section('contenido')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 d-flex d-md-block justify-content-center justify-content-md-start">
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
                    <label for="logo" class="col-12 pl-0" style="text-align:start">Imagen de fondo</label>
                    <div class="form-row">
                        <div class="form-group custom-file col-8">
                            <input type="file" name="fondo" class="custom-file-input" id="fondo" lang="es"
                            accept="image/x-png,image/gif,image/jpeg" onchange="readURL(this,'vistaPrevia');">
                            <label for="fondo" class="custom-file-label">Seleccionar Archivo</label>
                        </div>
                        <div class="form-group col-2">
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
        var ruta = "{{ route('constancia.store')}}";
    </script>
    <script src="{{ asset('js/admin/panelControl/constancia.js') }}"></script>
    <script src="{{ asset('/plugins/grapesjs/js/vistaprevia.js') }}"></script>
    <script src="{{ asset('/plugins/grapesjs/js/grapesjs.js') }}"></script>
    <script src="{{ asset('/plugins/grapesjs/js/gjs-blocks-basic.js') }}"></script>
    {{--<script src="{{ asset('/plugins/grapesjs/js/grapesjs/grapesjs-touch.min.js') }}"></script>--}}
    <script src="{{ asset('/plugins/grapesjs/js/gjs-conf2.js') }}"></script>
    
    <script>
      
     
        const getAllComponents = (model, result = []) => {
            result.push(model);
            model.components().each(mod => getAllComponents(mod, result))
            return result;
        }

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
