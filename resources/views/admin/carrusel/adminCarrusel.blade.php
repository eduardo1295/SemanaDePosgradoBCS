@extends('admin.plantilla')
@section('contenido')


<div class="container-fluid" id="#contenedor">
    <div class="row">
        <div class="col-12 mx-auto">
            <h1>
                Imágenes carrusel
            </h1>
        </div>

        <div id="mensaje-acciones" class="col-12 alert alert-success alert-dismissible" role="alert"
            style="display:none">
            <strong> </strong>
        </div>
    </div>
    <div class="row mb-2">
        <!--
        <legend class="d-none col-form-label col-12 col-md-2 col-lg-2 pt-0">Mostrar imagenes</legend>
        <div class="d-none col-12 col-md-4 col-lg-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio1" checked name="verInsti" value="activos">
                <label class="form-check-label" for="inlineRadio1">Activas</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio2" name="verInsti" value="eliminados">
                <label class="form-check-label" for="inlineRadio2">Eliminadas</label>
            </div>
        </div>
        -->
        <div class="col-12 col-md-12 col-lg-12 d-flex d-md-block justify-content-center justify-content-md-start">
            <div class="d-flex justify-content-end">
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="crear-carrusel"><span>
                    <i class="fas fa-plus"></i></span> Nueva imagen</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="display" cellspacing="0" style="width:100%" id="slidersC">
                <thead>
                    <tr>
                        <th>id</th>
                        <th class="all">Imagen</th>
                        <th>Link</th>
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
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <!--<div id="snackbar"></div>-->
</div>


@endsection
@section('extra')
@include('admin.carrusel.modal')
@include('admin.modalimagenes')
@endsection
@section('scripts')

<script src="{{ asset('js/imagenes/vistaprevia.js') }}"></script>
<script src="{{ asset('js/imagenes/modalimagen.js') }}"></script>

<script>
var rutaBaseCarrusel = "{{route('carrusel.index')}}";
var rutalistCarrusel = '{{ route("carrusel.listCarrusel")}}';
var SITEURL = "{{URL::to('/')}}";
var baseImagenes = "{{url('storage/img/carrusel')}}";
</script>
<script src="{{ asset('js/admin/panelControl/carrusel.js') }}"></script>

@endsection

@section('estilos')

<link href="{{ asset('/css/modales/modalimagen.css')}} " rel="stylesheet">

@endsection