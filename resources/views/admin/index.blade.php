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


<script src="/plugins/datatables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables/Responsive-2.2.2/js/dataTables.responsive.min.js"></script>
<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
-->

<script src="/js/imagenes/vistaprevia.js"></script>
<script src="/js/snack/snack.js"></script>

<script src="/plugins/summernote/summernote-bs4.js"></script>
<script src="/plugins/summernote/lang/summernote-es-ES.js"></script>
<script src="/plugins/summernote/plugin/cleaner/summernote-cleaner.js"></script>
<script src="/plugins/summernote/plugin/summernote-table-headers-master/summernote-table-headers.js"></script>
<script src="/plugins/summernote/plugin/list-styles-bs4/summernote-list-styles-bs4.js"></script>
<script src="/plugins/summernote/iniciarSummernote.js"></script>


<script src="/plugins/daterangepicker/moment.min.js"></script>
<script src="/plugins/daterangepicker/daterangepicker.js"></script>
<script src="/plugins/daterangepicker/iniciardaterangepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script>
var rutaBaseSemana = "{{route('semana.index')}}";
var rutalistSemanas = "{{route('semana.listSemanas')}}";
var SITEURL = "{{URL::to('/')}}";
var logoURL = "{{url('img/semanaLogo')}}";
var rutaReactivar = "{{ url('admin/semana/reactivar')}}";
</script>
<script src="/js/admin/panelControl/semana.js"></script>



@endsection

@section('estilos')


<link rel="stylesheet" href="/plugins/datatables/DataTables-1.10.18/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="/plugins/datatables/Responsive-2.2.2/css/responsive.dataTables.min.css">
<!--
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
-->
<link rel="stylesheet" href="/css/datatable/colores.css">
<link rel="stylesheet" href="/css/imagenes/imagenes.css">
<link rel="stylesheet" href="/css/modales/modalresponsivo.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link rel="stylesheet" type="text/css" href="/plugins/daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="/plugins/summernote/summernote-bs4.css">
<link rel="stylesheet" href="/css/modales/snackbar.css">

<style>
    .custom-file-input~.custom-file-label::after {
        content: "Elegir";
    }
    
</style>
@endsection
