{{-- SECCION BLADE--}}
@extends('Plantilla.principal')

@section('contenido')
@section('links')
<link rel="stylesheet" href="/css/Maqueta2.css">
<link href="/css/modales/snackbar.css" rel="stylesheet">
<script src="/js/owl.carousel.min.js"> </script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>
@endsection
<section id="trabajo">
        <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1 id="Titulo" class="display-   font-weight-bold rounded p-auto pt-3">Subir trabajo</h1> <br>
                    </div>
                </div>
                <div class="row">
        <div class="col-12">
            <table class="display" cellspacing="0" style="width:100%" id="alumnosdt">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Numero Control</th>
                        <th>Nombre</th>
                        <th>Apello paterno</th>
                        <th>Apellido Materno</th>
                        <th>Email</th>
                        <th>Trabajos</th>
                        <th>Estado</th>
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

@section('menu')
@include('layoutsM2.navbar')
@endsection
@section('footer')
@include('layoutsM2.footer')
@endsection
{{-- END SECCION BLADE--}}

@section('scripts')
<script src="/js/menumaker.js"></script>
<script src="/plugins/datatables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables/Responsive-2.2.2/js/dataTables.responsive.min.js"></script>
<link rel="stylesheet" href="/plugins/datatables/DataTables-1.10.18/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="/plugins/datatables/Responsive-2.2.2/css/responsive.dataTables.min.css">

<script src="/js/director/script.js"></script>

<link href="/css/modales/snackbar.css" rel="stylesheet">
@endsection
@endsection