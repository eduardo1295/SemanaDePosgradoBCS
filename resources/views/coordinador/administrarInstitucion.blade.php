{{-- SECCION BLADE--}}
@extends('Plantilla.principal')

@section('links')
<link rel="stylesheet" href="/css/Maqueta2.css">
<link href="/css/modales/snackbar.css" rel="stylesheet">
<link rel="stylesheet" href="/plugins/datatables/DataTables-1.10.18/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="/plugins/datatables/Responsive-2.2.2/css/responsive.dataTables.min.css">

<link href="/css/imagenes/cargando.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link rel="stylesheet" href="/css/datatable/colores.css">
<link href="/css/modales/modalresponsivo.css" rel="stylesheet">

<style>
    .tab-content{
        border-bottom: 1px solid #dee2e6;
        border-right: 1px solid #dee2e6;
        border-left: 1px solid #dee2e6;
    }
    .dropdown-menu{
        transform: translate3d(-184px, 27px, 0px) !important;
    }
</style>
@endsection

@section('contenido')

<section id="administrar" class="mb-5">
        <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1 id="Titulo" class="display-   font-weight-bold rounded p-auto pt-3">Subir trabajo</h1> <br>
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
                    <a class="nav-link" href="#references" role="tab" data-toggle="tab">Alumnos participantes</a>
                  </li>
              </ul>
              
              <!-- Tab panes -->
              <div class="tab-content" style="padding-bottom: 50px;">
                <div role="tabpanel" class="container tab-pane fade show active pt-3" id="profile">@include('coordinador.institucion')</div>
                <div role="tabpanel" class="container tab-pane fade pt-3" id="programas_estudio">@include('coordinador.programasInstitucion')</div>
                <div role="tabpanel" class="container tab-pane fade pt-3" id="direc_tesis">@include('coordinador.directores')</div>
                <div role="tabpanel" class="container tab-pane fade pt-3" id="references">Alumnos</div>
              </div>
        </div>
    </div>
                
            </div>
            <div id="snackbar"></div>
            <div id="loader" class="loader"></div>
</section>


{{-- END SECCION BLADE--}}


@endsection

@section('scripts')
<script>
    $('.custom-file-input').on('change', function () {
            let fileName = $(this).val().split('\\').pop();
            if (!fileName.trim()) {
                $(this).next('.custom-file-label').removeClass("selected").html('Ningún archivo seleccionado');
            } else {
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            }
        })
</script>
<script src="/js/admin/mostrarPassword.js"></script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&amp;sensor=false"></script>
<script src="/js/menumaker.js"></script>
<script src="/plugins/datatables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables/Responsive-2.2.2/js/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="/js/owl.carousel.min.js"> </script>
<script src="/js/snack/snack.js"></script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    $('.nav-link').on('click', function () {
            $('.nav-link').removeClass("active");
            $('.dropdown-item').removeClass("active");
        })

        $('.dropdown-item').on('click', function () {
            $('.nav-link').removeClass("active");
            $('.dropdown-item').removeClass("active");
        })

        
</script>

<script src="/js/director/script.js"></script>




<script src="/js/imagenes/vistaprevia.js"></script>
<script src="/js/coordinador/administrarInstitucion.js"></script>

<script src="/js/coordinador/programas.js"></script>
<script src="/plugins/responsive-tabs/jquery.responsivetabs.js"></script>

<script>
var checkCoord = 'activos';
var checkPro = 'activos';
var table;
var tablePrograma;
var imagenRuta = "{{url('img/logo')}}";
var rutaBaseInstitucion = "{{ route('institucion.index')}}";
var rutaEditarInstitucion = "{{ route('institucion.index')}}/{{ auth()->user()->id_institucion }}/editar";
var rutaBaseDirector = "{{ route('director.index')}}";
var rutaBasePrograma = "{{ route('programa.index')}}";
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
@endsection