    var checkInsti = 'activos';
    var titulo = "";
    var table = "";
    $(document).ready(function () {
        
        $("#show-sidebar").click(function () {
            $('#modalidad').DataTable().ajax.reload(null, false);
        });


        $(function () {
            registerSummernote('.summernote', 'Contenido de la modalidad', 1500, function (max) {
                $('#maxContentPost').text(max)
            });
        });


        $.extend($.fn.dataTableExt.oStdClasses, {
            "sFilterInput": "busqueda",
            "sLengthSelect": ""
        });

        $('#modalidad tfoot  th.text-input').each(function (i) {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="' + title + '" name="' + i + '" />');
        });

        table = $('#modalidad').DataTable({
            "order":[[2,"desc"]],
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
                "url": rutalistModalidad,
                "data": function (d) {
                    d.busqueda = checkInsti
                }
            },
            "columns": [
                { data: 'id', name: 'id', 'visible': false },
                { data: 'nombre', searchable: true },
                
                { data: 'fecha_actualizacion', searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            columnDefs: [
                { responsivePriority: 1, targets: 1 },
                { responsivePriority: 2, targets: 3 },
                { width: 105, targets: 3 }
            ]
        });


        $("input[name='verNoti']").change(function (e) {
            checkInsti = $(this).val();
            $('#modalidad').DataTable().ajax.reload();
        });

        $('#modalidad tbody').on('click', '.eliminar, .reactivar', function (e) {
            var tr = $(this).closest("tr");
            var data = $("#modalidad").DataTable().row(tr).data();
            titulo = data.titulo;

        });

    function filterPips(value, type) {
                if (type === 0) {
                    return value < 2000 ? -1 : 0;
                }
                return value % 1000 ? 2 : 1;
            }
            var slider = document.getElementById('slider');
            noUiSlider.create(slider, {
                start: [1, 10], //num, [num], [num,num]
                format: wNumb({
                    decimals: 0
                }),
                pips: {
                    mode: 'steps',
                    density: 3,
                    filter: filterPips,
                    format: wNumb({
                        decimals: 0,

                    })
                },
                range: {
                    'min': [1],
                    'max': [10]
                },
                behaviour: 'drag',
                connect: true,
                animate: true,
                step: 1,
                orientation: 'horizontal',
                tooltips: [true, true],
    });
    $('#slider').change(function(){
        console.log('hola');
    });
});
    

    /*Al presionar el boton editar*/
    $('body').on('click', '.editar', function () {
        var modalidad_id = $(this).data('id');
        var ruta = rutaBaseModalidad + "/" + modalidad_id + "/editar";
        reiniciar();


        $.get(ruta, function (data) {
            $('#modalidadCrudModal').html("Editar modalidad: " + data.modalidad.nombre);
            $('#btn-save').val("editar");
            $('#modalidad-crud-modal').modal('show');
            $('#modalidad_id').val(data.modalidad.id_modalidad);
            $('#titulo').val(data.modalidad.nombre);

            //$('#contenido').val(data.modalidad.descripcion);
            crearRenglon((data.posgrado.length-1));
            $('.posgrado').each(function (i) {
                $(this).val(data.posgrado[i].grado);
            });
            $('.periodo').each(function (i) {
                $(this).val(data.posgrado[i].periodo);
            });
            $('.sliderrr').each(function (i) {
                this.noUiSlider.set([data.periodo[i].periodo_min,data.periodo[i].periodo_max]);
            });

            $('#contenido').summernote('code', data.modalidad.descripcion);
            
        })
    });


    /*Accion al presionar el boton crear-modalidad*/
    $('#crear-modalidad').click(function () {
        reiniciar();
        slider.noUiSlider.set([1,10]);
        $('#btn-save').val("crear-modalidad");
        $('#modalidad_id').val('');
        $('#modalidadForm').trigger("reset");
        $('#modalidadCrudModal').html("Agregar nueva modalidad");
        $('#modalidad-crud-modal').modal({ backdrop: 'static', keyboard: false })
        $('#modalidad-crud-modal').modal('show');
  
    });

    $('.modal-btn').click(function () {
        $('#btn-save').val("crear-modalidad");
        $('#modalidad_id').val('');
        $('#modalidadForm').trigger("reset");
        $('#modalidadCrudModal').html("Agregar nueva institución");
        $('#modalidad-crud-modal').modal({ backdrop: 'static', keyboard: false })
        $('#modalidad-crud-modal').modal('show');
      
    });


    /*Accion al presionar el boton save*/
    $("#btn-save").click(function () {
        $('.mensajeError').text("");
        $("#btn-save").prop("disabled", true);
        $("#btn-close").prop("disabled", true);
        var actionType = $('#btn-save').val();
        $('#btn-save').html('Guardando..');
        if (actionType == "editar") {
            var id = $('#modalidad_id').val();
            var ruta = rutaBaseModalidad+"/" + id + "";
            var sli = $('.sliderrr');
            var auxDatos = new Array() , auxPosgrado = new Array() , auxperiodo = new Array();
            for(w=0; w< sli.length; w++){
                //var ee = sli[w];
                auxDatos.push(sli[w].noUiSlider.get());
                auxPosgrado.push($('.posgrado')[w].value);
                auxperiodo.push($('.periodo')[w].value);
            }
            console.log(auxDatos);
            var content = $('#contenido').val();
            //var datos = new FormData($("#modalidadForm")[0]);
            //periodo.append('_method', 'PUT');
            //console.log(Array.from(datos));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: ruta,
                type: "PUT",
                data: {  nombres: $('#titulo').val(),
                         contenido: content,
                         slider: auxDatos,
                         posgrado: auxPosgrado,
                         periodo: auxperiodo
                },
                //data: datos,
                //dataType: 'JSON',
                //contentType: false,
                //cache: false,
                //processData: false,
                success: function (data) {
                    //console.log(data);
                    $('#modalidadForm').trigger("reset");
                    $('#modalidad-crud-modal').modal('hide');
                    $('#btn-save').html('Guardar');
                    //recargar serverside
                    var oTable = $('#modalidad').dataTable();
                    oTable.fnDraw(false);
                    //recargar sin serverside
                    //$('#instituciones').DataTable().ajax.reload(null, false);
                    mostrarSnack("Actualización exitosa.");
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    if (xhr.status == 422) {
                        var errores = xhr.responseJSON['errors'];
                        var key2;
                        $.each(errores, function (key, value) {
                            key2= key.replace('.','\\.');
                            $('#' + key2 + '_error').text(value);
                            console.log(($('#' + key + "_error")));
                        });
                    }
                    $('#btn-save').html('Guardar');
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                },

            });
        } else if (actionType == "crear-modalidad") {
            $("#btn-save").prop("disabled", true);
            $("#btn-close").prop("disabled", true);

            var sli = $('.sliderrr');
            var auxDatos = new Array() , auxPosgrado = new Array() , auxperiodo = new Array();
            for(w=0; w< sli.length; w++){
                //var ee = sli[w];
                auxDatos.push(sli[w].noUiSlider.get());
                auxPosgrado.push($('.posgrado')[w].value);
                auxperiodo.push($('.periodo')[w].value);
            }
            console.log(auxDatos);
            var content = $('#contenido').val();
            
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {  nombres: $('#titulo').val(),
                         contenido: content,
                         slider: auxDatos,
                         posgrado: auxPosgrado,
                         periodo: auxperiodo
                    },
                url: rutaBaseModalidad,
                type: "POST",
                //contentType: false,
                //cache: false,
                //processData: false,
                success: function (data) {
                    $('#modalidadForm').trigger("reset");
                    $('#modalidad-crud-modal').modal('hide');
                    $('#btn-save').html('Guardar');
                    //recargar serverside
                    var oTable = $('#modalidad').dataTable();
                    oTable.fnDraw(false);
                    //recargar sin serverside
                    //$('#instituciones').DataTable().ajax.reload();
                    mostrarSnack("Modalidad agregada exitosamente.");
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                },
                error: function (data) {
                    if (data.status == 422) {
                        var errores = data.responseJSON['errors'];
                        var key2;
                        $.each(errores, function (key, value) {
                            key2= key.replace('.','\\.');
                            $('#' + key2 + '_error').text(value);
                            console.log(($('#' + key + "_error")));
                        });
                    }
                    $('#btn-save').html('Guardar');
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                },


            });
        }
    });

    /*Accion al presionar el boton eliminar*/
    $('body').on('click', '.eliminar', function () {
        var modalidad_id = $(this).data("id");
        $.confirm({
            columnClass: 'col-md-6',
            title: '¿Desea eliminar la modalidad titulada ' + titulo + '?',
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
                            url: rutaBaseModalidad + '/' + modalidad_id,
                            success: function (data) {
                                var oTable = $('#modalidad').dataTable();
                                if (table.data().count() == 1) {
                                    $('#modalidad').DataTable().ajax.reload();
                                } else {

                                    oTable.fnDraw(false);
                                }
                                mostrarSnack("Modalidad eliminada exitosamente.");
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
        var modalidad_id = $(this).data("id");
        $.confirm({
            columnClass: 'col-md-6',
            title: '¿Desea reactivar la modalidad titulada ' + titulo + '?',
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
                            url: rutaReactivar + '/' + modalidad_id,
                            success: function (data) {
                                var oTable = $('#modalidad').dataTable();
                                if (table.data().count() == 1) {
                                    $('#modalidad').DataTable().ajax.reload();
                                } else {

                                    oTable.fnDraw(false);
                                }
                                
                                //$('#instituciones').DataTable().ajax.reload(null, false);
                                //$('#instituciones').DataTable().ajax.reload();
                                mostrarSnack("Modalidad activada exitosamente.");
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

    var x = 1;
    var y = 1;
    var crearRenglon = function(agregar){
        for (var index = 0; index < agregar; index++) {
            var auxid;
            $('.nr').each(function (i) {
                auxid = $(this)[0].id;
            });
            $('#'+auxid).after('<div class="row sliderQuitar nr" id="nuevorenglon_'+(x+1)+'"><div class="form-group col-3"> <strong><label for="posgrado" class="control-label">Posgrado</label></strong> <select class="form-control posgrado" id="posgrado" name="posgrado"><option selected value="">Seleccione posgrado</option><option value="Maestría">Maestría</option><option value="Doctorado">Doctorado</option></select><small><span class="text-danger mensajeError" id="id_institucion_error"></span></small></div><div class="form-group col-3"><strong><label for="periodo" class="control-label">Periodo</label></strong><select class="form-control periodo" id="periodo" name="periodo"><option selected value="">Seleccione periodo</option><option value="Trimestre">Trimestre</option><option value="Cuatrimestre">Cuatrimestre</option><option value="Semestre">Semestre</option></select><small><span class="text-danger mensajeError" id="id_institucion_error"></span></small></div><div class="form-group col-5 pl-3 pb-3"><strong><label for="id_institucion" class="control-label">Grado</label></strong><br><div id="slider'+ x +'" class="sliderrr"></div></div><div class="form-group col-1 d-flex align-items-center"><i class="fas fa-times btn btn-danger " onclick="quitar('+(x+1)+')"></i></div></div>');
            var slider ;
                slider = document.getElementById('slider'+x);
                    noUiSlider.create(slider, {
                        start: [1, 10], //num, [num], [num,num]
                        format: wNumb({
                            decimals: 0
                        }),
                        pips: {
                            mode: 'steps',
                            density: 3,
                            filter: filterPips,
                            format: wNumb({
                                decimals: 0,

                            })
                        },
                        range: {
                            'min': [1],
                            'max': [10]
                        },
                        behaviour: 'drag',
                        connect: true,
                        animate: true,
                        step: 1,
                        orientation: 'horizontal',
                        tooltips: [true, true],
            });
            x++;
            y++;
        }
        
    }
    function reiniciar() {
        $('.sliderQuitar').remove();
        $('#contenido').summernote("reset");
        $('.mensajeError').text("");
    }

