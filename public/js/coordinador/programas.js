function cargarProgramas(ruta){
    //var ruta = "{{url('institucion')}}/" + "{{ auth()->user()->id_institucion }}" + "/editar";
    console.log(ruta);
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: ruta,
        type: "GET",
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function(){
            $(".loader").show();
        },
        success: function (data) {
            $('#programaCrudModal').html("Editar Programa");
                $('#btn-save-pro').val("editar");
                $('#programa-crud-modal').modal('show');
                
                
                $('#id_institucion_pro').val(data.id_institucion);
                $('#id_programa_pro').val(data.id_programa);
                $('#nombre_pro').val(data.nombre);
                $('#nivel_pro').val(data.nivel);
                $('#nivel_pro').val(data.nivel);
                $('#periodo_pro').val(data.periodo);
                $('#programa_id_pro').val(data.id);
        },
        error: function (data) {
            
        },
        complete: function (data) {
            $(".loader").hide();
        }

    });

}


function cargarDataTableProgramas(){
    if(!tablePrograma){
        tablePrograma = $('#programasDT').DataTable({
            "order":[[5,"desc"]],
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
                "url": rutaBasePrograma + '/' + 'listPrograma',
                "data": function (d) {
                    d.busqueda = checkPro
                }
            },
            "columns": [
                { data: 'id', name: 'id', 'visible': false },
                { data: 'nombre', searchable: true },
                { data: 'id_programa', searchable: true },
                { data: 'nivel', searchable: true },
                { data: 'periodo', searchable: true },
                { data: 'fecha_actualizacion', searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            columnDefs: [
                { responsivePriority: 1, targets: 1 },
                { responsivePriority: 2, targets:6 },
                { width: 105, targets: 6 }
            ]
        });
        console.log(tablePrograma);
    }else{
        $('#programasDT').DataTable().ajax.reload();
    }
    
}

$("input[name='verPro']").change(function (e) {
    checkPro = $(this).val();
    $('#programasDT').DataTable().ajax.reload();
});


/*Al presionar el boton editar*/
$('body').on('click', '.editarPrograma', function () {
    $('.mensajeError').text("")
            var programa_id = $(this).data('id');
            var ruta = rutaBasePrograma + '/' + programa_id + "/editar";
            $.get(ruta, function (data) {
                //ocultar errores
                $('#programaCrudModal').html("Editar Programa");
                $('#btn-save-pro').val("editar");
                $('#programa-crud-modal').modal('show');
                $('#id_programa_pro').val(data.id_programa);
                $('#nombre_pro').val(data.nombre);
                $('#nivel_pro').val(data.nivel);
                $('#nivel_pro').val(data.nivel);
                $('#periodo_pro').val(data.periodo);
                $('#programa_id_pro').val(data.id);
                

            })
});

/*Accion al presionar el boton eliminar*/
$('body').on('click', '.eliminarPrograma', function () {
    var programa_id = $(this).data("id");
    $.confirm({
        columnClass: 'col-md-6',
                title: '¿Desea eliminar el programa de estudios?',
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
                                url: rutaBasePrograma + '/' + programa_id,
                                success: function (data) {

                                    if (tablePrograma.data().count() == 1) {
                                        $('#programasDT').DataTable().ajax.reload();
                                    } else {
                                        var oTable = $('#programasDT').dataTable();
                                        oTable.fnDraw(false);
                                    }
                                    $("#snackbar").html("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Programa borrado exitosamente.");
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
        $('body').on('click', '.reactivarPrograma', function () {
            var programa_id = $(this).data("id");
            $.confirm({
                columnClass: 'col-md-6',
                title: "¿Desea reactivar el programa de estudios?",
                content: 'This dialog will automatically trigger \'cancel\' in 8 seconds if you don\'t respond.',
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
                                url: rutaBasePrograma + '/' + 'reactivar/' + programa_id,
                                success: function (data) {
                                    if (tablePrograma.data().count() == 1) {
                                        $('#programasDT').DataTable().ajax.reload();
                                    } else {
                                        var oTable = $('#programasDT').dataTable();
                                        oTable.fnDraw(false);
                                    }
                                    $("#snackbar").html("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Porgrama activado exitosamente.");
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

    
 /*Accion al presionar el boton save*/
 $("#btn-save-pro").click(function () {
    $('.mensajeError').text("");
    $("#btn-save-pro").prop("disabled", true);
    $("#btn-close").prop("disabled", true);
    var actionType = $('#btn-save-pro').val();
    $('#btn-save-pro').html('Guardando..');
    if (actionType == "editar") {
        var id = $('#programa_id_pro').val();
        var ruta = rutaBasePrograma + '/' + id;
        var datos = new FormData($("#programaForm")[0]);
        datos.append('_method', 'PUT');
        console.log(Array.from(datos));
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: ruta,
            type: "POST",
            data: datos,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $('#programaForm').trigger("reset");
                $('#programa-crud-modal').modal('hide');
                $('#btn-save-pro').html('Guardar');
                //recargar serverside
                var oTable = $('#programasDT').dataTable();
                oTable.fnDraw(false);
                $("#snackbar").html("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Actualización exitosa.");
                $("#snackbar").addClass("show");
                setTimeout(function () { $("#snackbar").removeClass("show"); }, 5000);

                
                $("#btn-save-pro").prop("disabled", false);
                $("#btn-close").prop("disabled", false);
                
                console.log(data);
            },
            error: function (data) {
                if (data.status == 422) {
                    var errores = data.responseJSON['errors'];
                    $.each(errores, function (key, value) {
                        $('#' + key + "_error").text(value);
                    });
                }
                $('#btn-save-pro').html('Guardar');
                $("#btn-save-pro").prop("disabled", false);
                $("#btn-close").prop("disabled", false);
            },

        });
    } else if (actionType == "crear-programa") {
        $("#btn-save-pro").prop("disabled", true);
        $("#btn-close").prop("disabled", true);



        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: new FormData($("#programaForm")[0]),
            url: rutaBasePrograma,
            type: "POST",
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $('#programaForm').trigger("reset");
                $('#programa-crud-modal').modal('hide');
                $('#btn-save-pro').html('Guardar');
                //recargar serverside
                var oTable = $('#programasDT').dataTable();
                oTable.fnDraw(false);
                $("#snackbar").html("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> Pograma registrado exitosamente.");
                $("#snackbar").addClass("show");
                setTimeout(function () { $("#snackbar").removeClass("show"); }, 5000);
                $("#btn-save-pro").prop("disabled", false);
                $("#btn-close").prop("disabled", false);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                if (xhr.status == 422) {
                    var errores = xhr.responseJSON['errors'];
                    $.each(errores, function (key, value) {
                        $('#' + key + "_error").text(value);
                    });
                }
                $('#btn-save-pro').html('Guardar');
                $("#btn-save-pro").prop("disabled", false);
                $("#btn-close").prop("disabled", false);
                
            },


        });
    }

})

    /*Accion al presionar el boton crear-programa*/
    $('#crear-programa').click(function () {
        
        $('.mensajeError').text("")
        $('#btn-save-pro').val("crear-programa");
        $('#programa_id').val('');
        $('#programaForm').trigger("reset");
        $('#programaCrudModal').html("Agregar nuevo programa");
        $('#programa-crud-modal').modal({ backdrop: 'static', keyboard: false })
        $('#programa-crud-modal').modal('show');

    });