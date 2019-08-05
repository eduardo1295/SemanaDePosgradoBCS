@extends('admin.plantilla')
@section('contenido')
<div class="container-fluid" id="#contenedor">
    <div class="row">
        <div class="col-12 d-flex d-md-block justify-content-center justify-content-md-start">
            <h1>
                Locaciones
            </h1>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12 col-md-12 col-lg-12 d-flex d-md-block justify-content-center justify-content-md-start">
            <div class="d-flex justify-content-end">
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="crear-locacion"><span><i
                            class="fas fa-plus"></i></span> Nueva locacion</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="display" cellspacing="0" style="width:100%" id="locacion">
                <thead>
                    <tr>
                        <th>id</th>
                        <th class="all">Nombre</th>
                        <th>Fecha actualización</th>
                        <th class="all">Acciones</th>
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
@include('locacion.modal')
@endsection
@section('scripts')
<script>
var rutaBaseLocacion = "{{route('locacion.index')}}";
var rutalistLocacion = "{{route('locacion.listLocacion')}}";

var rutaReactivar = "{{ url('admin/semana/reactivar')}}";
</script>
<script src="{{ asset('js/locacion/locacion.js') }}"></script> 
@endsection