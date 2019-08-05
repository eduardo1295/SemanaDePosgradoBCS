@extends('admin.plantilla')
@section('contenido')


<div class="container-fluid" id="#contenedor">
    <div class="row">
        <div class="col-12 d-flex d-md-block justify-content-center justify-content-md-start">
            <h1>
                Imágenes carrusel
            </h1>
        </div>
    </div>
    <div class="row mb-2">
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
                        <th class="not-mobile">Link</th>
                        <th>Última actualización</th>
                        <th class="all">Acciones</th>
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
</div>


@endsection
@section('extra')
@include('admin.carrusel.modal')
@include('admin.modalimagenes')
@endsection
@section('scripts')

<script src="{{ asset('js/imagenes/vistaprevia.js') }}"></script>

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