@extends('admin.plantilla')
@section('contenido')


<div class="container-fluid" id="#contenedor">
    <div class="row">
        <div class="col-12 mx-auto">
            <h1>
                Directores de tesis
            </h1>
        </div>

        <div id="mensaje-acciones" class="col-12 alert alert-success alert-dismissible" role="alert"
            style="display:none">
            <strong> </strong>
        </div>
    </div>
    <div class="row mb-2">
        <legend class="col-form-label col-12 col-md-3 col-lg-3 pt-0   d-flex d-md-block justify-content-center justify-content-md-start">Mostrar Directores de tesis</legend>
        <div class="col-12 col-md-4 col-lg-3 d-flex d-md-block justify-content-center justify-content-md-start">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio1" checked name="verCoor" value="activos">
                <label class="form-check-label" for="inlineRadio1">Activos</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio2" name="verCoor" value="eliminados">
                <label class="form-check-label" for="inlineRadio2">Eliminados</label>
            </div>
        </div>
        <div class="col-12 col-md-5 col-lg-6 d-flex d-md-block justify-content-center justify-content-md-start">
            <div class="d-flex justify-content-end">
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="crear-director"><span><i
                            class="fas fa-plus"></i></span> Agregar director</a>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="display" cellspacing="0" style="width:100%" id="directoresdt">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nombre</th>
                        <th>Primer apellido</th>
                        <th>Segundo apellido</th>
                        <th>Email</th>
                        <th>Institución</th>
                        <th>Última Actualización</th>
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
@include('admin.directores.modal')
@endsection
@section('scripts')
<script src="{{ asset('js/admin/mostrarPassword.js') }}"></script>

<script>
var rutaBaseDirector = "{{route('director.index')}}";
var rutalistDirector = '{{ route("director.listDirector")}}';
var SITEURL = "{{URL::to('/')}}";
var rutaReactivar = "{{ url('director/reactivar')}}";
</script>
<script src="{{ asset('js/admin/panelControl/directorTesis.js') }}"></script>
@endsection