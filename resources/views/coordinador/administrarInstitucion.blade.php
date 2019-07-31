{{-- SECCION BLADE--}}
@extends('Plantilla.principal')

@section('links')
<link rel="stylesheet" href="{{ asset('/css/Maqueta2.css')}}">
<link href="{{ asset('/css/modales/snackbar.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('/plugins/datatables/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
<link rel="stylesheet" href="{{ asset('/plugins/datatables/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">

<link href="{{ asset('/css/imagenes/cargando.css')}} " rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link rel="stylesheet" href="{{ asset('/css/datatable/colores.css')}} ">
<link href="{{ asset('/css/modales/modalresponsivo.css')}} " rel="stylesheet">

<style>
    .tab-content{
        border-bottom: 1px solid #dee2e6;
        border-right: 1px solid #dee2e6;
        border-left: 1px solid #dee2e6;
    }
    .dropdown-menu{
        -webkit-filter: blur(0.000001px);
    }
    .tooltip{
        pointer-events: none;
    }
</style>
@endsection

@section('contenido')

<section id="administrar" class="mb-5">
        <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1 id="Titulo" class="display-5 font-weight-bold rounded p-auto pt-3">Administrar Institución</h1> <br>
                    </div>
                </div>
                <div class="row">
        <div class="col-12">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" onclick='cargarInstitucion();' href="#profile" role="tab" data-toggle="tab">Institución</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#programas_estudio" role="tab" data-toggle="tab" onclick="cargarDataTableProgramas()">Programas de estudio</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" href="#direc_tesis" role="tab" data-toggle="tab" onclick="cargarDataTableDirectores()">Directores de tesis</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="#references" role="tab" data-toggle="tab" onclick="cargarDataTableAlumnos()">Alumnos participantes</a>
                  </li>
                  <!--
                  <li class="nav-item">
                    <a class="nav-link" href="#sesion" role="tab" data-toggle="tab" onclick="cargarDataTableSesiones()">Sesiones</a>
                  </li>
                  -->
                  @if(auth()->user()->hasRoles(['subadmin']))
                    <li class="nav-item">
                      <a class="nav-link" href="#locacion" role="tab" data-toggle="tab" onclick="cargarDataTableLocaciones()">Locaciones</a>
                    </li>
                  @endif
              </ul>
              
              <!-- Tab panes -->
              <div class="tab-content" style="padding-bottom: 50px;">
                <div role="tabpanel" class="container tab-pane fade show active pt-3" id="profile">@include('coordinador.institucion')</div>
                <div role="tabpanel" class="container tab-pane fade pt-3" id="programas_estudio">@include('coordinador.programasInstitucion')</div>
                <div role="tabpanel" class="container tab-pane fade pt-3" id="direc_tesis">@include('coordinador.directores')</div>
                <div role="tabpanel" class="container tab-pane fade pt-3" id="references">@include('coordinador.alumnos')</div>
                <!--<div role="tabpanel" class="container tab-pane fade pt-3" id="sesion">@include('coordinador.sesion')</div>-->
                <div role="tabpanel" class="container tab-pane fade pt-3" id="locacion">@include('coordinador.locacion')</div>
              </div>
        </div>
    </div>
                
            </div>
            <div id="snackbar"></div>
            <div id="snackbarError" style="z-index:1051;"></div>
            <div id="loader" class="loader"></div>
</section>


{{-- END SECCION BLADE--}}


@endsection

@section('scripts')
<script src="{{ asset('js/admin/mostrarPassword.js') }}"></script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&amp;sensor=false"></script>
<script src="{{ asset('plugins/datatables/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/Responsive-2.2.2/js/dataTables.responsive.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{ asset('js/snack/snack.js') }}"></script>
<script>
    /*$(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
    */

    $('.nav-link').on('click', function () {
            $('.nav-link').removeClass("active");
            $('.dropdown-item').removeClass("active");
        })

        $('.dropdown-item').on('click', function () {
            $('.nav-link').removeClass("active");
            $('.dropdown-item').removeClass("active");
        })

        
</script>





<script src="{{ asset('js/imagenes/vistaprevia.js') }}"></script>
<script src="{{ asset('js/coordinador/administrarInstitucion.js') }}"></script>

<script src="{{ asset('js/coordinador/programas.js') }}"></script>
<script src="{{ asset('js/coordinador/alumnos.js') }}"></script>
<!--<script src="/js/coordinador/sesion.js"></script>-->
<script src="{{ asset('js/coordinador/locacion.js') }}"></script>
<script src="{{ asset('plugins/responsive-tabs/jquery.responsivetabs.js') }}"></script>

<script>
var URLData = {{ asset("/js/datatableJS/es.json") }}
var checkDir = 'activoscoor';
var checkPro = 'activoscoor';
var checkAlumno = 'activoscoor';
var checkSesion = 'activos';
var checkLoca = 'activoscoor';
var table;
var tablePrograma;
var tableAlumno;
/*var tableSesion;*/
var tableLocacion;
var imagenRuta = "{{url('img/logo')}}";
var rutaBaseInstitucion = "{{ route('institucion.index')}}";
var rutaEditarInstitucion = "{{ route('institucion.index')}}/{{ auth()->user()->id_institucion }}/editar";
var rutaBasePrograma = "{{ route('programa.index')}}";
var rutaBaseDirector = "{{ route('director.index')}}";
var rutaBaseAlumno = "{{ route('alumno.index')}}";
var rutaImportarAlumnos = "{{ route('alumno.importar')}}";
/*var rutaBaseSesion = "{{ route('sesion.index')}}";*/
var rutaBaseLocacion = "{{ route('locacion.index')}}";

$(document).ready(function () {
    cargarInstitucion();
});

        $(function() {
            $('.nav-tabs').responsiveTabs();
        });
    
</script>

@endsection

@section('extra')
    @include('admin.directores.modal')
    @include('admin.programa.modal')
    @include('admin.alumnos.modal')
    {{--@include('sesion.modal')--}}
    @include('locacion.modal')
@endsection