@extends('admin.plantilla')
@section('contenido')


<div class="container-fluid" id="#contenedor">
    <div class="row">
        <div class="col-12 mx-auto">
            <h1>
                Instituciones registradas
            </h1>
        </div>
        
        <div id="mensaje-acciones" class="col-12 alert alert-success alert-dismissible" role="alert"
            style="display:none">
            <strong> </strong>
        </div>
    </div>
    <div class="row mb-2">
        <legend class="col-form-label col-12 col-md-2 col-lg-2 pt-0">Mostras instituciones</legend>
        <div class="col-12 col-md-4 col-lg-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio1" checked name="verInsti" value="activos">
                <label class="form-check-label" for="inlineRadio1">Activas</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio2" name="verInsti" value="eliminados">
                <label class="form-check-label" for="inlineRadio2">Eliminadas</label>
              </div>
        </div>
        <div class="col-12 col-md-6 col-lg-6">
            <div class="d-flex justify-content-end">
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="crear-institucion"><span><i
                            class="fas fa-plus"></i></span> Nueva Institución</a>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="display" cellspacing="0" style="width:100%" id="instituciones">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nombre</th>
                        <th>Direccion Web</th>
                        <th>Telefono</th>
                        <th id="lad">Última actualización</th>
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


@endsection
@section('extra')
@include('institucion.modal')    
@endsection
@section('scripts')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&amp;sensor=false"></script>

<script>
    function initialize() {
    var myLatlng = new google.maps.LatLng(24.5908,-111.0903);
  var mapProp = {
    center:myLatlng,
    zoom:12,
    mapTypeId:google.maps.MapTypeId.ROADMAP
      
  };
  var map=new google.maps.Map(document.getElementById("googleMap"), mapProp);
    var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      draggable:true  
  });
    document.getElementById('lat').value= 24.5908
    document.getElementById('lng').value=  -111.0903
    // marker drag event
    google.maps.event.addListener(marker,'drag',function(event) {
        document.getElementById('lat').value = event.latLng.lat();
        document.getElementById('lng').value = event.latLng.lng();
    });

    //marker drag event end
    google.maps.event.addListener(marker,'dragend',function(event) {
        document.getElementById('lat').value = event.latLng.lat();
        document.getElementById('lng').value = event.latLng.lng();
    });
}

google.maps.event.addDomListener(window, 'load', initialize);

    var SITEURL = "{{URL::to('/')}}";
    var checkInsti='activos';
    $(document).ready(function () {

        
        $.extend($.fn.dataTableExt.oStdClasses, {
            "sFilterInput": "busqueda",
            "sLengthSelect": ""
        });

        $('#instituciones tfoot  th.text-input').each(function (i) {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="' + title + '" name="' + i + '" />');
        });
        
        var table = $('#instituciones').DataTable({
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
            "ajax": {"url":'{{ route("institucion.listInstituciones")}}',
            "data": function ( d ) {
                d.busqueda= checkInsti
            }},
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
                { data: 'id', name: 'id', 'visible': false },
                { data: 'nombre', searchable: true },
                { data: 'direccion_web', searchable: true },
                { data: 'telefono', searchable: true },
                { data: 'direccion', searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            columnDefs: [
                { responsivePriority: 1, targets: 1 },
                { responsivePriority: 2, targets: 5 },
                { width: 105, targets: 5 }
            ]
        });

        

        $("#close-sidebar").click(function () {
            //table.columns.adjust().responsive.recalc().draw('page');
            $('.mensajeError').text("");
            $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
        });

        $("#show-sidebar").click(function () {
            //table.draw(false);
            //$('#instituciones').DataTable().columns.adjust().responsive.recalc().draw('page');
            //table.columns.adjust().responsive.recalc().draw('page');
            $('#instituciones').DataTable().ajax.reload(null, false);
        });

        /*Accion al presionar el boton crear-institucion*/
        $('#crear-institucion').click(function () {

            $('#btn-save').val("crear-institucion");
            $('#institucion_id').val('');
            $('#institucionForm').trigger("reset");
            $('#institucionCrudModal').html("Agregar nueva institución");
            $('#institucion-crud-modal').modal({ backdrop: 'static', keyboard: false })
            $('#institucion-crud-modal').modal('show');
            $('#imglogo').prop('src',"");
            //$('#imglogo').width('0').height('0');
            $('#logoactual').html('');
            
            //$('#col-logo').html('');

            
            //obtener todos los renglones (no server side)
            /*
            myTable = $('#instituciones').DataTable();
            var form_data  = myTable.rows().data();
            var x ="";
            $.each( form_data, function( key, value ) {
                x+= key + ": " + value.nombre ;
            });
            alert(x);
            */
            /*
            var req = $('#instituciones').DataTable().ajax.params();
            
            // Reset request parameters to retrieve all records
            req.start = 0;
            req.length = -1;
            req.search.value = "";

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: '{{ route("institucion.listInstituciones")}}',
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    
                },

            });
            */
            //console.log($('#instituciones').DataTable().ajax.params());

        });

        /*Al presionar el boton editar*/
        $('body').on('click', '.editar', function () {
            var institucion_id = $(this).data('id');
            var ruta = "{{url('institucion')}}/" + institucion_id + "/editar";
            $.get(ruta, function (data) {
                //$('#name-error').hide();
                //$('#direccion_web-error').hide();
                $('#institucionCrudModal').html("Editar institución: "+data.nombre);
                $('#btn-save').val("editar");
                $('#institucion-crud-modal').modal('show');
                $('#institucion_id').val(data.id);
                $('#nombre').val(data.nombre);
                $('#direccion_web').val(data.direccion_web);
                $('#telefono').val(data.telefono);
                $('#ciudad').val(data.ciudad);
                $('#calle').val(data.calle);
                $('#numero').val(data.numero);
                $('#colonia').val(data.colonia);
                $('#cp').val(data.cp);
                //$('#imglogo').prop('src',"");
                
                $('#imglogo').prop('src',"{{url('img/logo')}}/" + data.url_logo);
                //if(data.url_logo!=null){
                //    $('#imglogo').prop('src',"{{url('img')}}/" + data.url_logo);
                    //$('#imglogo').width('260').height('160');
                //}
                $('#logoactual').html('Logo actual');
                
                
                //var image = new Image();
                //image.style = "width:304px;height:228px;";
                //image.src= "{{url('img')}}/" + data.url_logo;
                //$('#col-logo').html(image);
                
            })
        });

        //var info = table.page.info();
        /*Accion al presionar el boton eliminar*/
        $('body').on('click', '.eliminar', function () {
            var institucion_id = $(this).data("id");
            $.confirm({
                columnClass: 'col-md-6',
                title: '¿Desea eliminar la institución?',
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
                                url: "{{ url('institucion')}}" + '/' + institucion_id,
                                success: function (data) {
                                    
                                    if(table.data().count()==1){
                                        $('#instituciones').DataTable().ajax.reload();
                                    }else{
                                        var oTable = $('#instituciones').dataTable();
                                        oTable.fnDraw(false);
                                    }
                                    $("#mensaje-acciones").text("Institución eliminada exitosamente.");
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

        /*Accion al presionar el boton reactivar*/
        $('body').on('click', '.reactivar', function () {
            var institucion_id = $(this).data("id");
            $.confirm({
                columnClass: 'col-md-6',
                title: "¿Desea reactivar la institución?",
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
                                url: "{{ url('institucion/reactivar')}}" + '/' + institucion_id,
                                success: function (data) {              
                                    if(table.data().count()==1){
                                        $('#instituciones').DataTable().ajax.reload();
                                    }else{
                                        var oTable = $('#instituciones').dataTable();
                                        oTable.fnDraw(false);
                                    }
                                    $("#mensaje-acciones").text("Institución activada exitosamente.");
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


    $('#btn-close').click(function () {
        $('.mensajeError').text("");
    })

    $("input[name='verInsti']").change(function(e){
    checkInsti= $(this).val();
    /*
    if(checkInsti == 'activos'){
        $('#lad').html('Última actualización');
    }else if(checkInsti=='eliminados'){
        $('#lad').html('Fecha de borrado');
    }*/
    
    $('#instituciones').DataTable().ajax.reload();
    });
    
    /*Accion al presionar el boton save*/
    $("#btn-save").click(function () {
        $("#btn-save").prop("disabled", true);
        $("#btn-close").prop("disabled", true);
        var actionType = $('#btn-save').val();
        $('#btn-save').html('Guardando..');
        if (actionType == "editar") {
            var id = $('#institucion_id').val();
            var ruta = "{{url('institucion')}}/" + id + "";
            var datos = new FormData($("#institucionForm")[0]);
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
                    //console.log(data);
                    $('#institucionForm').trigger("reset");
                    $('#institucion-crud-modal').modal('hide');
                    $('#btn-save').html('Guardar');
                    //recargar serverside
                    var oTable = $('#instituciones').dataTable();
                    oTable.fnDraw(false);
                    //recargar sin serverside
                    //$('#instituciones').DataTable().ajax.reload(null, false);
                    $("#mensaje-acciones").text("Actualización exitosa.");
                    $("#mensaje-acciones").fadeIn();
                    $('#mensaje-acciones').delay(3000).fadeOut();
                    $('#mensaje-acciones').addClass('alert-success');
                    $('#mensaje-acciones').removeClass('alert-warning');
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                    $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
                    
                    
                },
                error: function (data) {
                    if (data.status == 422) {
                        var errores = data.responseJSON['errors'];
                        $.each( errores, function( key, value ) {
                            $('#'+key+"_error").text(value);
                        });
                    }
                    $('#btn-save').html('Guardar');
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                },

            });
        } else if (actionType == "crear-institucion") {
            $("#btn-save").prop("disabled", true);
            $("#btn-close").prop("disabled", true);
            
            
            
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: new FormData($("#institucionForm")[0]),
                url: "{{route('institucion.store')}}",
                type: "POST",
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $('#institucionForm').trigger("reset");
                    $('#institucion-crud-modal').modal('hide');
                    $('#btn-save').html('Guardar');
                    //recargar serverside
                    var oTable = $('#instituciones').dataTable();
                    oTable.fnDraw(false);
                    //recargar sin serverside
                    //$('#instituciones').DataTable().ajax.reload();
                    $("#mensaje-acciones").text("Institución registrada exitosamente.");
                    $("#mensaje-acciones").fadeIn();
                    $('#mensaje-acciones').delay(3000).fadeOut();
                    $('#mensaje-acciones').addClass('alert-success');
                    $('#mensaje-acciones').removeClass('alert-warning');
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                    $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    $('#btn-save').html('Guardar');
                    $("#btn-save").prop("disabled", false);
                    $("#btn-close").prop("disabled", false);
                },


            });
        }

    })

    $('.custom-file-input').on('change', function () {
        let fileName = $(this).val().split('\\').pop();
        if (!fileName.trim()) {
            $(this).next('.custom-file-label').removeClass("selected").html('Ningún archivo seleccionado');
        } else {
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        }
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
    .custom-file-input~.custom-file-label::after {
        content: "Elegir";
    }
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
    .fullscreen-modal .modal-dialog {
  
  margin-right: auto;
  margin-left: auto;
  max-width: 100%;
}
@media (min-width: 768px) {
  .fullscreen-modal .modal-dialog {
    max-width: 750px;
  }
}
@media (min-width: 992px) {
  .fullscreen-modal .modal-dialog {
    max-width: 90%;
  }
}
@media (min-width: 1200px) {
  .fullscreen-modal .modal-dialog {
    max-width: 70%;
  }
}
</style>

@endsection