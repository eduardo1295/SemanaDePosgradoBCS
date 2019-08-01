@extends('admin.plantilla')
@section('contenido')


<div class="container-fluid" id="#contenedor">
    <div class="row">
        <div class="col-12 mx-auto">
            <h1>
                Alumnos participantes
            </h1>
        </div>

        <div id="mensaje-acciones" class="col-12 alert alert-success alert-dismissible" role="alert"
            style="display:none">
            <strong> </strong>
        </div>
    </div>
    <div class="row mb-2">
        <legend class="col-form-label col-12 col-md-3 col-lg-2 pt-0   d-flex d-md-block justify-content-center justify-content-md-start">Mostrar Alumnos</legend>
        <div class="col-12 col-md-4 col-lg-4 d-flex d-md-block justify-content-center justify-content-md-start">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="alumnoR1" checked name="verAlumno" value="activos">
                <label class="form-check-label" for="alumnoR1">Activos</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="alumnoR2" name="verAlumno" value="eliminados">
                <label class="form-check-label" for="alumnoR2">Eliminados</label>
            </div>
        </div>
        <div class="col-12 col-md-5 col-lg-6 d-flex d-md-block justify-content-center justify-content-md-start">
                <div class="d-flex justify-content-end">
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="crear-alumno"><span><i
                            class="fas fa-plus"></i></span> Agregar alumno</a>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="display" cellspacing="0" style="width:100%" id="alumnosDT">
                <thead>
                    <tr>
                        <th>id</th>
                        <th class="all">No. Control</th>
                        <th class="min-tablet-l">Institución</th>
                        <th class="none">Programa de estudios</th>
                        <th class="min-tablet-l">Nombre</th>
                        <th class="min-tablet-l">Primer apellido</th>
                        <th class="min-tablet-l">Segundo apellido</th>
                        <th class="min-tablet-l">Email</th>
                        <th class="min-tablet-l">Última Actualización</th>
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
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    
</div>


@endsection
@section('extra')
@include('admin.alumnos.modal')
@endsection
@section('scripts')
<script src="{{ asset('/js/admin/mostrarPassword.js') }}"></script>

<script>
var rutaBaseAlumno = "{{route('alumno.index')}}";
var rutalistAlumno = '{{ route("alumno.listAlumnos")}}';
var rutaListPrograma = "{{url('alumno/programasLista')}}";
var SITEURL = "{{URL::to('/')}}";
var rutaReactivar = "{{ url('alumno/reactivar')}}";
</script>
<script src="{{ asset('/js/admin/panelControl/alumno.js') }}"></script>
@endsection