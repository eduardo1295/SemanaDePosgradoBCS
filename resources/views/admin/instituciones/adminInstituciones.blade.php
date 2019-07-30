@extends('admin.plantilla')
@section('contenido')


<div class="container-fluid" id="#contenedor">
    <div class="row">
        <div class="col-12 mx-auto">
            <h1>
                Instituciones participantes
            </h1>
        </div>
    </div>
    <div class="row mb-2">
        <legend
            class="col-form-label col-12 col-md-3 col-lg-2 pt-0   d-flex d-md-block justify-content-center justify-content-md-start">
            Mostrar Instituciones</legend>
        <div class="col-12 col-md-4 col-lg-4 d-flex d-md-block justify-content-center justify-content-md-start">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio1" checked name="verInsti" value="activos">
                <label class="form-check-label" for="inlineRadio1">Activas</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio2" name="verInsti" value="eliminados">
                <label class="form-check-label" for="inlineRadio2">Eliminadas</label>
            </div>
        </div>
        <div class="col-12 col-md-5 col-lg-6 d-flex d-md-block justify-content-center justify-content-md-start">
            <div class="d-flex justify-content-end">
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="crear-institucion"><span><i
                            class="fas fa-plus"></i></span> Nueva Institución</a>
            </div>
            <div class="d-flex justify-content-end pt-3">
                <a href="javascript:void(0)" class="btn btn-secondary ml-3" id="Logo-conacyt"><span><i
                            class="fas fa-plus"></i></span> Logo CONACYT</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="display" cellspacing="0" style="width:100%" id="instituciones">
                <thead>
                    <tr>
                        <th>id</th>
                        <th class="all">Nombre</th>
                        <th>Direccion Web</th>
                        <th>Telefono</th>
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
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>


@endsection
@section('extra')
@include('admin.instituciones.modal')
@include('admin.instituciones.modalConacyt')
<!--<div id="snackbar"></div>-->
@endsection
@section('scripts')

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&amp;sensor=false"></script>
<script src="{{ asset('js/imagenes/vistaprevia.js') }}"></script>


<script>
var rutaBaseIntitucion = "{{route('institucion.index')}}";
var rutalistIntitucion = '{{ route("institucion.listInstituciones")}}';
var rutaLogo = "{{url('img/logo')}}";
var rutaReactivar = "{{ url('admin/institucion/reactivar')}}";
</script>
<script src="{{ asset('js/admin/panelControl/instituciones.js') }}"></script>
@endsection

@section('estilos')


@endsection
