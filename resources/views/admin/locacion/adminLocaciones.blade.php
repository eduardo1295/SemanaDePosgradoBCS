@extends('admin.plantilla')
@section('contenido')
<div class="container-fluid" id="#contenedor">
    <div class="row">
        <div class="col-12 mx-auto">
            <h1>
                Locaciones
            </h1>
        </div>
        <div id="mensaje-acciones" class="col-12 alert alert-success alert-dismissible" role="alert"
            style="display:none">
            <strong> </strong>
        </div>
    </div>
    <div class="row mb-3">
        
        <div class="col-12 col-md-6 col-lg-6 offset-6">
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
                        <th>nombre</th>
                        <th>Fecha actualización</th>
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
@include('locacion.modal')
<!--
<div id="snackbar"></div>
<div id="snackbarError" style="z-index:1051;"></div>
-->
@endsection
@section('scripts')

<script src="/js/locacion/locacion.js"></script> 
@endsection
@section('estilos')


<!--
    Nuevo Rente
-->
@endsection