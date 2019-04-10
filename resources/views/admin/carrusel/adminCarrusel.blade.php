@extends('admin.plantilla')
@section('contenido')


<div class="container-fluid" id="#contenedor">
          
    <div class="row">
        <div class="col-12 mx-auto">
            <h1>
                Secciones carrusel
            </h1>
        </div>

        <div id="mensaje-acciones" class="col-12 alert alert-success alert-dismissible" role="alert"
            style="display:none">
            <strong> </strong>
        </div>
    </div>
    <div class="row  space-xx-small">
        <legend class="col-form-label col-12 col-md-2 col-lg-2 pt-0">Mostras secciones</legend>
        <div class="col-12 col-md-4 col-lg-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio1" checked name="verNoti" value="activos">
                <label class="form-check-label" for="inlineRadio1">Activas</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio2" name="verNoti" value="eliminados">
                <label class="form-check-label" for="inlineRadio2">Eliminadas</label>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-6">
            <div class="d-flex justify-content-end">
                <a href="{{route('carrusel.create')}}" class="btn btn-info ml-3" id="crear-carrusel"><span><i
                            class="fas fa-plus"></i></span> Nueva sección</a>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="display" cellspacing="0" style="width:100%" id="carruselE">
                <thead>
                    <tr>
                        <th>id_carrusel</th>
                        <th>Titulo</th>
                        <th>Conteido</th>
                        <th>Última actualización</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th class="text-input">Titulo</th>
                        <th class="text-input">Resumen</th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>


@endsection
@section('scripts')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script>

    var checkInsti = 'activos';
    var titulo = "";
    $(document).ready(function () {
        $.extend($.fn.dataTableExt.oStdClasses, {
            "sFilterInput": "busqueda",
            "sLengthSelect": ""
        });

        $('#carruselE tfoot  th.text-input').each(function (i) {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="' + title + '" name="' + i + '" />');
        });

        var table = $('#carruselE').DataTable({
            pageLength: 5,
            lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']],
            responsive: true,
            autoWidth: false,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "processing": true,
            "serverSide": true,
            "search": true,
            "ajax": {
                "url": '{{ route("carrusel.listCarrusel")}}',
                "data": function (d) {
                    d.busqueda = checkInsti
                }
            },
            initComplete: function () {
                var api = this.api();
                api.columns([1,2]).every(function () {
                    var that = this;
                    $('input', this.footer()).on('keyup change', function () {
                        if (that.search() !== this.value) {
                            that
                                .search(this.value)
                                .draw();
                        }
                    });
                })
            },
            "columns": [
                { data: 'id', name: 'id', 'visible': false },
                { data: 'titulo', searchable: true },
                { data: 'contenido', searchable: true },
                { data: 'fecha_actualizacion', searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            columnDefs: [
                { responsivePriority: 1, targets: 1 },
                { responsivePriority: 2, targets: 4 },
                { width: 105, targets: 4 }
            ]
        });

        $("#show-sidebar").click(function () {
            $('#carruselE').DataTable().ajax.reload(null, false);
        });

        /*Al presionar el boton editar*/
        $('body').on('click', '.editar', function () {
            var carrusel_id = $(this).data('id');
            var ruta = "{{url('carrusel')}}/" + carrusel_id+"/editar";
            //alert(ruta);
            window.location = ruta;
        });


        $('#carruselE tbody').on('click', '.eliminar, .reactivar', function (e) {
            var tr = $(this).closest("tr");
            var data = $("#carruselE").DataTable().row(tr).data();
            titulo = data.titulo;

        });

        /*Accion al presionar el boton eliminar*/
        $('body').on('click', '.eliminar', function () {
            var carrusel_id = $(this).data("id");
            $.confirm({
                columnClass: 'col-md-6',
                title: '¿Desea eliminar la carrusel titulada ' + titulo + '?',
                content: 'Este mensaje activará automáticamente \'cancelar\' en 8 segundos si no responde.',
                autoClose: 'cancelAction|8000',
                buttons: {

                    cancelAction: {
                        text: 'Cancelar',
                        btnClass: 'btn-red',
                        action: function () {
                        }
                    },
                    confirm: {
                        text: 'Aceptar',
                        icon: 'fas fa-warning',

                        btnClass: 'btn-blue',
                        action: function () {

                            $.ajax({
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                type: "DELETE",
                                url: "{{ url('carrusel')}}" + '/' + carrusel_id,
                                success: function (data) {

                                    if (table.data().count() == 1) {
                                        $('#carruselE').DataTable().ajax.reload();
                                    } else {
                                        var oTable = $('#carruselE').dataTable();
                                        oTable.fnDraw(false);
                                    }
                                    $("#mensaje-acciones").text("carrusel eliminada exitosamente.");
                                    $("#mensaje-acciones").fadeIn();
                                    $('#mensaje-acciones').delay(3000).fadeOut();
                                    $('#mensaje-acciones').addClass('alert-warning');
                                    $('#mensaje-acciones').removeClass('alert-success');
                                },
                                error: function (data) {
                                    console.log('Error:', data);
                                }
                            });


                        }
                    }
                }
            });
        });


        /*Accion al presionar el boton reactivar*/
        $('body').on('click', '.reactivar', function () {
            var carrusel_id = $(this).data("id");
            $.confirm({
                columnClass: 'col-md-6',
                title: '¿Desea reactivar la carrusel titulada ' + titulo + '?',
                content: 'Este mensaje activará automáticamente \'cancelar\' en 8 segundos si no responde.',
                autoClose: 'cancelAction|8000',
                buttons: {
                    cancelAction: {
                        text: 'Cancelar',
                        btnClass: 'btn-red',
                        action: function () {
                        }
                    },
                    confirm: {
                        text: 'Aceptar',
                        icon: 'fas fa-warning',
                        btnClass: 'btn-blue',
                        action: function () {
                            $.ajax({
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                type: "PUT",
                                url: "{{ url('carrusel/reactivar')}}" + '/' + carrusel_id,
                                success: function (data) {
                                    if (table.data().count() == 1) {
                                        $('#carruselE').DataTable().ajax.reload();
                                    } else {
                                        var oTable = $('#carruselE').dataTable();
                                        oTable.fnDraw(false);
                                    }
                                    $("#mensaje-acciones").text("carrusel activada exitosamente.");
                                    $("#mensaje-acciones").fadeIn();
                                    $('#mensaje-acciones').delay(3000).fadeOut();
                                    $('#mensaje-acciones').addClass('alert-warning');
                                    $('#mensaje-acciones').removeClass('alert-success');
                                    //$('#instituciones').DataTable().ajax.reload(null, false);
                                    //$('#instituciones').DataTable().ajax.reload();
                                },
                                error: function (data) {
                                    console.log('Error:', data);
                                }
                            });


                        }
                    }
                }
            });
        });

    });
    $("input[name='verNoti']").change(function (e) {
        checkInsti = $(this).val();
        $('#carruselE').DataTable().ajax.reload();
    });
</script>
@endsection

@section('estilos')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="/css/datatable/colores.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
<style>
    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }

    .busqueda {
        border: 1px solid #ced4da;
        padding: .375rem .75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: .25rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;

    }

    .busqueda:focus {
        color: #495057;
        background-color: #fff;
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
    }
</style>

@endsection