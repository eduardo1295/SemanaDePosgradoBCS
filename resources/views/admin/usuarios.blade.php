@extends('admin.plantilla')
@section('contenido')

<main class="page-content pt-2">
    <div class="container-fluid p-5">
        <div class="row">
            <div class="col-12 mx-auto">
                <h1>
                    Usuarios registrados
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%" id="users">
                    
                    <thead>
                       <tr>
                           <th>Email</th>
                           <th>Nombre</th>
                           <th>Primer apellido</th>
                           <th>Segundo apellido</th>
                           <th style="width: 190px;">Acciones</th>
                       </tr>
                   </thead>
                   
                </table>
                
            </div>
        </div>
        
        <hr>
    </div>
</main>   
@endsection

@section('scripts')
    <script src= "https://code.jquery.com/jquery-3.3.1.js">    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    
    
    




    <script>
        $(document).ready( function () {
                $('#users').DataTable({
                    "sDom": '<"row"<"col-12 col-sm-6 col-lg-6"l><"col-12 col-sm-6 col-lg-6"f>>rt<"row"<"col-12 col-lg-6"i><"col-12 col-lg-6"p>><"clear">',
                    "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                    },
                    "processing": true,
                    "serverSide": true,
                    "ajax": '{{ route('admin.listUsuarios') }}',
                    "columns": [
                        {data: 'email'},
                        {data: 'nombre'},
                        {data: 'primer_apellido'},
                        {data: 'segundo_apellido'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ],
                    responsive: true,
                    columnDefs: [
                        { responsivePriority: 1, targets: 0 },
                        { responsivePriority: 2, targets: 4 },
                        { responsivePriority: 3, targets: 1 },
                        { width: 195, targets: 4 },

                        
                    ]
            }   );
        } );
    </script>
@endsection

@section('estilos')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../css/datatable/colores.css">
    
@endsection