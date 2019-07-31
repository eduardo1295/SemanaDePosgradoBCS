{{-- SECCION BLADE--}}
@extends('Plantilla.principal')

@section('links')
<link rel="stylesheet" href="{{ asset('/css/Maqueta2.css')}}">
<link href="{{ asset('/css/modales/snackbar.css')}} " rel="stylesheet">
@endsection

@section('contenido')
<section id="trabajo">
        <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1 id="Titulo" class="display-5   font-weight-bold rounded p-auto pt-3">Seguimiento de alumnos</h1> <br>
                    </div>
                </div>
                <div class="row">
        <div class="col-12">
            <table class="display" cellspacing="0" style="width:100%" id="alumnosdt">
                <thead>
                    <tr>
                        <th>id</th>
                        <th style="color:black !important">Numero Control</th>
                        <th>Nombre</th>
                        <th>Apello paterno</th>
                        <th>Apellido Materno</th>
                        <!--<th>Email</th>-->
                        <th>Trabajos</th>
                        <th>Estado</th>
                        <th>Revisado</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <!--<th></th>-->
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
        <div class="col-12 mt-3">
            @isset($mensaje)
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>¡Listo!</strong> Se le ha enviado un correo al estudiante.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endisset
        </div>
        
    </div>
                
            </div>
            <div id="snackbar"></div>
            
            
</section>
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
@endsection

@section('scripts')
    <script src="{{ asset('plugins/datatables/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/Responsive-2.2.2/js/dataTables.responsive.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('/plugins/datatables/DataTables-1.10.18/css/jquery.dataTables.min.css')}} ">
    <link rel="stylesheet" href="{{ asset('/plugins/datatables/Responsive-2.2.2/css/responsive.dataTables.min.css')}} ">
    <link rel="stylesheet" href="{{ asset('/css/datatable/colores.css')}} ">
    <script src="{{ asset('js/director/script.js') }}"></script>
    <script>
    rutaListAlumnos = "{{route('director.listAlumnos')}}";
    rutaBase = "{{route('trabajo.index')}}";
    </script>

    <link href="{{ asset('/css/modales/snackbar.css')}}" rel="stylesheet">
@endsection