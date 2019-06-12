var SITEURL = "{{URL::to('/')}}";
var checkCoord = 'activos';
var selectIDIns= "";
$(document).ready(function () {
    
    $.extend($.fn.dataTableExt.oStdClasses, {
        "sFilterInput": "busqueda",
        "sLengthSelect": ""
    });

    $('#alumnosdt tfoot  th.text-input').each(function (i) {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" name="' + i + '" />');
    });

    var table = $('#alumnosdt').DataTable({
        pageLength: 5,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']],
        responsive: true,
        autoWidth: false,
        "language": {
            "url": "/js/datatableJS/es.json"
        },
        "processing": true,
        "serverSide": true,
        "search": true,
        "ajax": {
            "url": '/director/listAlumnos',
            "data": function (d) {
                d.busqueda = checkCoord
            }
        },
        initComplete: function () {
            var api = this.api();
            api.columns(2).every(function () {
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
            { data: 'id', name: 'id', 'visible': false,searchable: false },
            {data: 'alumnos.num_control', name: 'alumnos.num_control', searchable: false},
            { data: 'nombre', searchable: true },
            { data: 'primer_apellido', searchable: true },
            { data: 'segundo_apellido', searchable: true },
            //{ data: 'email', searchable: true },
            {
                data: 'trabajos.url',
                name: 'trabajos.url',
                
                render: function (data, type, full, meta) {
                    
                    if (data == null)
                        return 'Sin entrega';
                    else
                        //return "<a style='cursor:pointer' target='_blank' href=/documentos/trabajos/"+data + "> Ver Trabajo <a/>";
                        return "<a style='cursor:pointer' class='btn btn-outline-info btn-sm'  href=/trabajo/"+full.id+"> Ver Trabajo <a/>";
                },
                orderable: false, searchable: false
            },
            {
                data: 'trabajos.autorizado',
                name: 'trabajos.autorizado',
                render: function (data, type, full, meta) {
                    if (data == 0)
                        return '<label class="btn btn-danger btn-sm w-100">No aprobado</label>';
                    else if( data == 1 )
                        return '<label class="btn btn-success btn-sm w-100">Aprobado</label>';
                    else
                        return '<label class="btn btn-warning btn-sm w-100">Sin entregar</label>';
                },
                searchable: true 
            },
            {
                data: 'trabajos.revisado',
                name: 'trabajos.revisado',
                render: function (data, type, full, meta) {
                    if (data == 0)
                        return '<label class="btn btn-danger btn-sm w-100">No Revisado</label>';
                    else if( data == 1 )
                        return '<label class="btn btn-success btn-sm w-100">Revisado</label>';
                    else
                        return '<label class="btn btn-warning btn-sm w-100">Sin entregar</label>';
                },
                searchable: true
            },
        ],
        columnDefs: [
            { responsivePriority: 1, targets: 2 },
            { className: "font-weight-bold text-info", targets: 1 },
            { responsivePriority: 2, targets: 7 },
            { width: 105, targets: 5 }
        ]
    });



    $("#close-sidebar").click(function () {
        $('.mensajeError').text("");
        
    });

    $("#show-sidebar").click(function () {
        $('#alumnosdt').DataTable().ajax.reload(null, false);
    });



    /*Al presionar el boton editar*/
    $('body').on('click', '.editar', function () {
        var alumno_id = $(this).data('id');
        var ruta = "{{url('alumno')}}/" + alumno_id + "/editar";
        $.get(ruta, function (data) {
            //ocultar errores
            $('#alumnoCrudModal').html("Editar alumno: " + data[0].nombre + ' ' + data[0].primer_apellido + ' ' + data[0].segundo_apellido);
            $('#btn-save').val("editar");
            $('#alumno-crud-modal').modal('show');
            console.log(data);
            $('#alumno_id').val(data[0].id);
            $('#institucion').val(data.institucion);
            $('#nombre').val(data[0].nombre);
            $('#primer_apellido').val(data[0].primer_apellido);
            $('#segundo_apellido').val(data[0].segundo_apellido);
            $('#email').val(data[0].email);
            $('#semestre').val(data[0].alumnos.semestre);
            $('#num_control').val(data[0].alumnos.num_control);
            $("#institucionSelect").val(data[0].instituciones.id);
            buscarProgramas();
            setTimeout(function(){ 
                $("#programaSelect").val(data[0].alumnos.id_programa);
                $("#directorSelect").val(data[0].alumnos.id_director);
            }, 3000);
        })
    });

    //var info = table.page.info();
    /*Accion al presionar el boton eliminar*/
    $('body').on('click', '.eliminar', function () {
        var alumno_id = $(this).data("id");
        $.confirm({
            columnClass: 'col-md-6',
            title: '¿Desea eliminar el alumno?',
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
                            url: "{{ url('alumno')}}" + '/' + alumno_id,
                            success: function (data) {

                                if (table.data().count() == 1) {
                                    $('#alumnosdt').DataTable().ajax.reload();
                                } else {
                                    var oTable = $('#alumnosdt').dataTable();
                                    oTable.fnDraw(false);
                                }
                                $("#snackbar").html("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> alumno eliminada exitosamente.");
                                $("#snackbar").addClass("show");
                                setTimeout(function () { $("#snackbar").removeClass("show"); }, 5000);
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
        var alumno_id = $(this).data("id");
        $.confirm({
            columnClass: 'col-md-6',
            title: "¿Desea reactivar el alumno?",
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
                            url: "{{ url('admin/alumno/reactivar')}}" + '/' + alumno_id,
                            success: function (data) {
                                if (table.data().count() == 1) {
                                    $('#alumnosdt').DataTable().ajax.reload();
                                } else {
                                    var oTable = $('#alumnosdt').dataTable();
                                    oTable.fnDraw(false);
                                }
                                $("#snackbar").html("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Cuenta activada exitosamente.");
                                $("#snackbar").addClass("show");
                                setTimeout(function () { $("#snackbar").removeClass("show"); }, 5000);
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