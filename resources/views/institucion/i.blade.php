@extends('admin.plantilla2')
@section('contenido')

<div class="container-fluid" id="content">
    <div class="row">
        <div class="menu-header col-12">
            <button type="button" id="sidebarCollapse" class="btn menu-btn">
                <img src="nav.png" alt="Menu">
            </button>
            <span class="menu-text">Page Title</span>

        </div>

    </div>
        <div class="row">
            <div class="col-12 mx-auto">
                <h1>
                    Instituciones registrados
                </h1>
            </div>
            <div class="col-12">
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="crear-institucion">Nueva Institución</a>
                <br><br>
            </div>
            <div id="mensaje-actualizar" class="col-12 alert alert-success alert-dismissible" role="alert"
                style="display:none">
                <strong> Actualización exitosa.</strong>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="display nowrap" cellspacing="0" style="width:100%" id="instituciones">
                    <thead>
                        <tr>
                            <th>id</th>
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
                            <th></th>
                            <th class="text-input">Direccion Web</th>
                            <th></th>
                            <th></th>
                            <th></th>

                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    
    </div>
@include('institucion.modal')
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>


<script>
    var SITEURL = "{{URL::to('/')}}";
    $(document).ready(function () {
        // Setup - add a text input to each footer cell
        $('#instituciones tfoot tr th.text-input').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="' + title + '" />');
        });

        var table = $('#instituciones').DataTable({
            autoWidth: false,
            responsive: true,
            initComplete: function () {
                this.api().columns(0).every(function () {
                    var column = this;
                    var select = $('<select><option value=""></option></select>')
                        .appendTo($(column.footer()).empty())
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });

                    column.data().unique().sort().each(function (d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                });
            },


            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "processing": true,
            "serverSide": true,
            "ajax": '{{ route("institucion.listInstituciones")}}',
            "columns": [
                { data: 'id', name: 'id', 'visible': false },
                { data: 'nombre' },
                { data: 'direccion_web' },
                { data: 'telefono' },
                { data: 'direccion' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],

            columnDefs: [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 4 },
                { responsivePriority: 3, targets: 1 },
                { width: 195, targets: 4 }

            ]

        });

        $('#instituciones tfoot .text-input').on('keyup', "input", function () {
            console.log(this.value, $(this).parent().index())
            table
                .column($(this).parent().index())
                .search(this.value)
                .draw();
        });


        $("#close-sidebar").click(function () {
            //table.columns.adjust().responsive.recalc().draw('page');
        });

        $("#show-sidebar").click(function () {
            table.columns.adjust().responsive.recalc().draw('page');
        });

        $('#crear-institucion').click(function () {
            $('#btn-save').val("crear-institucion");
            $('#institucion_id').val('');
            $('#institucionForm').trigger("reset");
            $('#institucionCrudModal').html("Agregar nueva institución");
            $('#institucion-crud-modal').modal('show');
        });

        /* When click edit user */
        $('body').on('click', '.edit-institucion', function () {
            var institucion_id = $(this).data('id');
            $.get(institucion_id + '/editar', function (data) {
                $('#name-error').hide();
                $('#direccion_web-error').hide();
                $('#institucionCrudModal').html("Editar institución");
                $('#btn-save').val("edit-institucion");
                $('#institucion-crud-modal').modal('show');
                $('#institucion_id').val(data.id);
                $('#nombre').val(data.nombre);
                $('#direccion_web').val(data.direccion_web);
            })
        });
        //delete user login
        $('body').on('click', '.delete-institucion', function () {
            var institucion_id = $(this).data("id");
            alert(institucion_id);
            confirm("Are You sure want to delete !");

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: "DELETE",
                url: "{{ url('institucion')}}" + '/' + institucion_id,
                success: function (data) {
                    alert('bien');
                    var oTable = $('#instituciones').dataTable();
                    oTable.fnDraw(false);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });
        
        
    });

    
        $('#btn-close').click(function(){
            $('.mensajeError').text("");
        })

       
        $("#btn-save").click(function(){
                var actionType = $('#btn-save').val();
                $('#btn-save').html('Guardando..');
                if (actionType == "edit-institucion") {
                    var id = $('#institucion_id').val();
                    var ruta = "{{url('institucion')}}/" + id + "";
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        data: $('#institucionForm').serialize(),
                        url: ruta,
                        type: "PUT",
                        dataType: 'json',
                        success: function (data) {
                            $('#institucionForm').trigger("reset");
                            $('#institucion-crud-modal').modal('hide');
                            $('#btn-save').html('Guardar');
                            var oTable = $('#instituciones').dataTable();
                            oTable.fnDraw(false);
                            $("#mensaje-actualizar").fadeIn();
                            $('#mensaje-actualizar').delay(3000).fadeOut();
                        },
                        error: function (data) {
                            if(data.status === 422){
                                var errors = $.parseJSON(data.responseText);
                                
                                var lisErrores = errors['errors'];
                                Object.keys(lisErrores).forEach(function(k){
                                    $("#" + k + "_error").text(lisErrores[k]);
                                });
                                /*
                                var keys = Object.keys(errors['errors']);
                                
                                $.each(lisErrores, function (key, val) {
                                    alert(key[val]);
                                    
                                    $("#" + key + "_error").text(val['nombre']);
                                });
                                console.log('Error:', data);*/
                            }
                            $('#btn-save').html('Guardar');
                        }
                    });
                } else if (actionType == "crear-institucion") {
                    var ruta = "{{route('institucion.store')}}";
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        data: $('#institucionForm').serialize(),
                        url: "{{route('institucion.store')}}",
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {
                            $('#institucionForm').trigger("reset");
                            $('#institucion-crud-modal').modal('hide');
                            $('#btn-save').html('Guardar');
                            var oTable = $('#instituciones').dataTable();
                            oTable.fnDraw(false);
                            $("#mensaje-actualizar").fadeIn();
                            $('#mensaje-actualizar').delay(3000).fadeOut();

                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            $('#btn-save').html('Guardar');
                        },
                        

                    });
                }
            
        })
    
</script>
@endsection

@section('estilos')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="../css/datatable/colores.css">


<style>
    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
</style>

@endsection