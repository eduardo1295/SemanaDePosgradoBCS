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
        <legend class="col-form-label col-12 col-md-2 col-lg-2 pt-0">Mostras locaciones</legend>
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
<div id="snackbar"></div>
<div id="snackbarError" style="z-index:1051;"></div>
@endsection
@section('scripts')
<script src="/plugins/datatables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables/Responsive-2.2.2/js/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="/js/snack/snack.js"></script>

<script src="/js/locacion/locacion.js"></script> 
@endsection
@section('estilos')
<link href="/css/imagenes/cargando.css" rel="stylesheet">
<link rel="stylesheet" href="/plugins/datatables/DataTables-1.10.18/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="/plugins/datatables/Responsive-2.2.2/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link href="/css/modales/snackbar.css" rel="stylesheet">
<link rel="stylesheet" href="/css/datatable/colores.css">
<link href="/css/modales/modalresponsivo.css" rel="stylesheet">
<link href="/css/modales/snackbar.css" rel="stylesheet">
<script src="/js/snack/snack.js"></script>

<!--
    Nuevo Rente
-->
@endsection