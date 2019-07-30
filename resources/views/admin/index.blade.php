@extends('admin.plantilla')
@section('contenido')


<div class="container-fluid" id="#contenedor">
    <div class="row">
        <div class="col-12 mx-auto">
            <h1>
                Eventos Semana de Posgrado
            </h1>
        </div>

        <div id="mensaje-acciones" class="col-12 alert alert-success alert-dismissible" role="alert"
            style="display:none">
            <strong> </strong>
        </div>
    </div>
    <div class="row mb-2">

        <div class="col-12 col-md-12 col-lg-12 d-flex d-md-block justify-content-center justify-content-md-start">
            <div class="d-flex justify-content-end">
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="crear-semana"><span><i
                            class="fas fa-plus"></i></span> Nuevo evento</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="display" cellspacing="0" style="width:100%" id="semanas">
                <thead>
                    <tr>
                        <th>id_semana</th>
                        <th>Nombre</th>
                        <th>Sede</th>
                        <th>Fecha inicio</th>
                        <th>Fecha fin</th>
                        <th>Convocatoria</th>
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
@include('admin.semana.modal')
<!--
<div id="snackbar"></div>
<div id="snackbarError" style="z-index:1051;"></div>
-->
@endsection
@section('scripts')

<script src="{{ asset('js/imagenes/vistaprevia.js') }}"></script>


<script src="{{ asset('plugins/summernote/summernote-bs4.js') }}"></script>
<script src="{{ asset('plugins/summernote/lang/summernote-es-ES.js') }}"></script>
<script src="{{ asset('plugins/summernote/plugin/cleaner/summernote-cleaner.js') }}"></script>
<script src="{{ asset('plugins/summernote/plugin/summernote-table-headers-master/summernote-table-headers.js') }}"></script>
<script src="{{ asset('plugins/summernote/plugin/list-styles-bs4/summernote-list-styles-bs4.js') }}"></script>
<script src="{{ asset('plugins/summernote/iniciarSummernote.js') }}"></script>


<script src="{{ asset('plugins/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/iniciardaterangepicker.js') }}"></script>

<script>
var rutaBaseSemana = "{{route('semana.index')}}";
var rutalistSemanas = "{{route('semana.listSemanas')}}";
var SITEURL = "{{URL::to('/')}}";
var logoURL = "{{url('img/semanaLogo')}}";
var rutaReactivar = "{{ url('admin/semana/reactivar')}}";
</script>
<script src="{{ asset('js/admin/panelControl/semana.js') }}"></script>



@endsection

@section('estilos')




<link rel="stylesheet" type="text/css" href="/plugins/daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="/plugins/summernote/summernote-bs4.css">



@endsection
