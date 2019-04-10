@extends('admin.plantilla')
@section('contenido')

<main class="page-content pt-2">
    <div class="container-fluid p-5">
        <div class="row">
            <div class="col-12 mx-auto">
                <h1>
                    Instituciones registrados
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-striped table-bordered nowrap" style="width:100%" id="instituciones">
                   <thead>
                       <tr>
                           <th>Nombre</th>
                           <th>Direccion Web</th>
                           <th>Telefono</th>
                           <th>Dirección</th>
                           <th>Acciones</th>
                       </tr>
                   </thead>
                   <tfoot>
                    <tr>
                        <th></th>
                        <th class="text-input">Direccion Web</th>
                        <th></th>
                        <th></th>
                        <th ></th>
                        
                    </tr>
                </tfoot>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    




    <script>
        $(document).ready( function () {
                        // Setup - add a text input to each footer cell
                        $('#instituciones tfoot tr th.text-input').each( function () {
                            var title = $(this).text();
        $(this).html( '<input type="text" placeholder="'+title+'" />' );
			            } );
                        
                var table = $('#instituciones').DataTable({

                    initComplete: function () {
            this.api().columns(0).every( function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        },


                    "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                    },
                    "processing": true,
                    "serverSide": true,
                    "ajax": '{{ route("institucion.listInstituciones")}}',
                    "columns": [
                        {data: 'nombre'},
                        {data: 'direccion_web'},
                        {data: 'telefono'},
                        {data: 'direccion'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ],
                    responsive: {
                        details: {
                            display: $.fn.dataTable.Responsive.display.modal( {
                                header: function ( row ) {
                                    var data = row.data();
                                    return 'Details for '+data.nombre;
                                }
                            } )
                        }
                    },
                    columnDefs: [
                        { responsivePriority: 1, targets: 0 },
                        { responsivePriority: 2, targets: 4 },
                        { responsivePriority: 3, targets: 1 },
                        { width: 190, targets: 4 }
                        
                    ]
                    
            }   );

            $( '#instituciones tfoot .text-input'  ).on( 'keyup', "input",function () {
       console.log(this.value, $(this).parent().index())
        table
            .column( $(this).parent().index() )
            .search( this.value )
            .draw();
    } );

   
        } );
    </script>
@endsection

@section('estilos')
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
    <style>
    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }</style>
    
@endsection