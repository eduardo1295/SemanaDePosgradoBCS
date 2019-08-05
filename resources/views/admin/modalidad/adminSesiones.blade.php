@extends('admin.plantilla')
@section('contenido')
<div class="container-fluid" id="#contenedor">
    <div class="row">
        <div class="col-12 d-flex d-md-block justify-content-center justify-content-md-start">
            <h1>
                Sesiones
            </h1>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12 col-sm-12 col-lg-12 d-flex d-sm-block justify-content-center justify-content-sm-start">
            <div class="d-flex justify-content-end">
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="crear-sesion"><span><i
                            class="fas fa-plus"></i></span> Nueva sesion</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="display" cellspacing="0" style="width:100%" id="sesion">
                <thead>
                    <tr>
                        <th>id_sesion</th>
                        <th class="all">Tipo Sesión</th>
                        <th>Día</th>
                        <th>Hora inicio</th>
                        <th>Hora fin</th>
                        <th>Lugar</th>
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
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@endsection
@section('extra')
@include('sesion.Modal')
@endsection
@section('scripts')
<script src="{{ asset('js/sesion/sesion.js') }}"></script>
<script>
var rutaList= "{{route('sesion.listSesiones')}}"
var rutaBase = "{{route('sesion.index')}}"
</script>
@endsection