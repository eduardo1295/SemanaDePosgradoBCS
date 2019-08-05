@extends('admin.plantilla')
@section('contenido')


<div class="container-fluid" id="#contenedor">
    <div class="row">
        <div class="col-12 d-flex d-md-block justify-content-center justify-content-md-start">
            <h1>
                Coordinadores
            </h1>
        </div>
    </div>
    <div class="row mb-2">
        <!--
        <legend class="col-form-label col-12 col-md-3 col-lg-2 pt-0   d-flex d-md-block justify-content-center justify-content-md-start">Mostrar coordinadores</legend>
        <div class="col-12 col-md-4 col-lg-4 d-flex d-md-block justify-content-center justify-content-md-start">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio1" checked name="verCoor" value="activos">
                <label class="form-check-label" for="inlineRadio1">Activos</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio2" name="verCoor" value="eliminados">
                <label class="form-check-label" for="inlineRadio2">Eliminados</label>
            </div>
        </div>
    -->
        <div class="col-12 col-md-12 col-lg-12 d-flex d-sm-block justify-content-center justify-content-sm-start">
            <div class="d-flex justify-content-end">
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="crear-coordinador"><span><i
                            class="fas fa-plus"></i></span> Agregar coordinador</a>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="display" cellspacing="0" style="width:100%" id="coordinadoresdt">
                <thead>
                    <tr>
                        <th>id</th>
                        <th class="all">Nombre</th>
                        <th>Primer apellido</th>
                        <th>Segundo apellido</th>
                        <th>Puesto</th>
                        <th>Email</th>
                        <th>Institución</th>
                        <th>Última Actualización</th>
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

@include('admin.coordinador.modal')
@endsection
@section('scripts')
<script src="{{ asset('js/admin/mostrarPassword.js') }}"></script>


<script>
var rutaBaseCoordinador = "{{route('coordinador.index')}}";
var rutalistCoordinador = '{{ route("coordinador.listCoordinador")}}';
var SITEURL = "{{URL::to('/')}}";
var rutaReactivar = "{{ url('admin/coordinador/reactivar')}}";
</script>
<script src="{{ asset('js/admin/panelControl/coordinador.js') }}"></script>
@endsection