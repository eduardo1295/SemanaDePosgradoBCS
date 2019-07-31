@extends('admin.plantilla')
@section('contenido')


<div class="container-fluid" id="#contenedor">
    <div class="row">
        <div class="col-12 mx-auto">
            <h1>
                Programas de estudio
            </h1>
        </div>

        <div id="mensaje-acciones" class="col-12 alert alert-success alert-dismissible" role="alert"
            style="display:none">
            <strong> </strong>
        </div>
    </div>
    <div class="row mb-2">
        <legend class="col-form-label col-12 col-md-3 col-lg-2 pt-0   d-flex d-md-block justify-content-center justify-content-md-start">Mostrar Programas</legend>
        <div class="col-12 col-md-4 col-lg-4 d-flex d-md-block justify-content-center justify-content-md-start">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio1" checked name="verPrograma" value="activos">
                <label class="form-check-label" for="inlineRadio1">Activas</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio2" name="verPrograma" value="eliminados">
                <label class="form-check-label" for="inlineRadio2">Eliminadas</label>
            </div>
        </div>
        <div class="col-12 col-md-5 col-lg-6 d-flex d-md-block justify-content-center justify-content-md-start">
            <div class="d-flex justify-content-end">
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="crear-programa"><span><i
                            class="fas fa-plus"></i></span> Nuevo Programa</a>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="display" cellspacing="0" style="width:100%" id="programasDT">
                <thead>
                    <tr>
                        <th>id</th>
                        <th class="all">Nombre</th>
                        <th>Clave Programa</th>
                        <th>Nivel</th>
                        <th>Periodo</th>
                        <th>Institución</th>
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
    <!--<div id="snackbar"></div>-->
</div>


@endsection
@section('extra')
@include('admin.programa.modal')
@include('admin.modalimagenes')
@endsection
@section('scripts')


<script src="/js/imagenes/modalimagen.js"></script>

<script>
var rutaBasePrograma = "{{route('programa.index')}}";
var rutalistPrograma = '{{ route("programa.listPrograma")}}';
var SITEURL = "{{URL::to('/')}}";

var rutaReactivar = "{{ url('programa/reactivar')}}";
</script>
<script src="/js/admin/panelControl/programaEstudio.js"></script>
@endsection

@section('estilos')


<link href="{{ asset('/css/modales/modalimagen.css')}}" rel="stylesheet">


@endsection