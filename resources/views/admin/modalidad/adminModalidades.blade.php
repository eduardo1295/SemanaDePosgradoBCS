@extends('admin.plantilla')
@section('contenido')


<div class="container-fluid" id="#contenedor">

    <div class="row">
        <div class="col-12 mx-auto">
            <h1>
                Modalidades de participación
            </h1>
        </div>

        <div id="mensaje-acciones" class="col-12 alert alert-success alert-dismissible" role="alert"
            style="display:none">
            <strong> </strong>
        </div>
    </div>
    <div class="row mb-3">
        <legend class="col-form-label col-12 col-md-2 col-lg-2 pt-0">Mostrar modalidades</legend>
        <div class="col-12 col-md-4 col-lg-4">
            
        </div>
        <div class="col-12 col-md-6 col-lg-6">
            <div class="d-flex justify-content-center justify-content-sm-end">
                <a href="javascript:void(0)" class="btn btn-info ml-3 " id="crear-modalidad"><span><i
                            class="fas fa-plus"></i></span> Nueva Modalidad</a>

            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="display" cellspacing="0" style="width:100%" id="modalidad">
                <thead>
                    <tr>
                        <th>id_modalidad</th>
                        <th>Nombre</th>
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
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>

@endsection
@section('extra')
@include('modalidad.modal')
<!--
<div id="snackbar"></div>
<div id="snackbarError" style="z-index:1051;"></div>
-->
@endsection
@section('scripts')

<script src="{{ asset('plugins/summernote/summernote-bs4.js') }}"></script>
<script src="{{ asset('plugins/summernote/lang/summernote-es-ES.js') }}"></script>
<script src="{{ asset('plugins/summernote/plugin/cleaner/summernote-cleaner.js') }}"></script>
<script src="{{ asset('plugins/summernote/plugin/summernote-table-headers-master/summernote-table-headers.js') }}"></script>
<script src="{{ asset('plugins/summernote/plugin/list-styles-bs4/summernote-list-styles-bs4.js') }}"></script>
<script src="{{ asset('plugins/summernote/iniciarSummernote.js') }}"></script>
<!--Nuevo Rente-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.1/bootstrap-slider.js"></script>
<script src="{{ asset('plugins/nouislider/nouislider.js') }}"></script>
<script src="{{ asset('plugins/nouislider/wNumb.js') }}"></script>

<script>
var rutaBaseModalidad = "{{route('modalidad.index')}}";
var rutalistModalidad = '{{ route("modalidad.listModalidad")}}';
var SITEURL = "{{URL::to('/')}}";
var baseImagenes = "{{url('img/carrusel')}}";
var rutaReactivar = "{{ url('admin/modalidad/reactivar')}}";
</script>
<script src="{{ asset('js/admin/panelControl/modalidad.js') }}"></script>

@endsection

@section('estilos')

<link rel="stylesheet" href="{{ asset('/css/imagenes/imagenes.css')}} ">

<link href="{{ asset('/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">

<!--

    Nuevo Rente
-->
<link rel="stylesheet" href="{{ asset('/css/admin/styleRange.css')}} ">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.1/css/bootstrap-slider.css">
<link rel="stylesheet" href="{{ asset('/plugins/nouislider/nouislider.css')}} ">
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
<style>
    .noUi-connect {
        background: blue !important;
    }

    .noUi-value-sub {
        color: black !important;
        font-size: 10px;
    }
    .noUi-horizontal .noUi-tooltip {
        bottom: -36px !important;
    }
</style>
@endsection