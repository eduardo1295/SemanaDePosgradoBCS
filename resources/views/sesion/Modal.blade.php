<div class="modal fullscreen-modal fade" id="sesion-crud-modal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="sesionCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form id="sesionForm" name="sesionForm" class="form-horizontal" enctype="multipart/form-data">
                <input type="hidden" name="sesion_id" id="sesion_id">
                    <div class="row">
                        <div class="form-group col-6">
                          <strong><label for="modalidad">Modalidad</label><label class="text-danger">*</label></strong>
                            @isset($modalidades)
                                <select class="form-control modalidad" id="modalidad"  name="modalidad" onchange="cambio(1,0)">
                                    <option selected value="">Seleccione la modalidad de participación</option>
                                    @foreach($modalidades as $modalidad)
                                    <option value="{{$modalidad->id_modalidad}}">{{$modalidad->nombre}}</option>
                                    @endforeach
                                </select>
                                <small><span class="text-danger mensajeError" id="modalidad_error"></span></small>
                            @endisset
                        </div>
                        <div class="form-group col-6">
                          <strong><label for="dia">Día</label><label class="text-danger"> *</label></strong>
                          @isset($horarios)
                                <select class="form-control dia" id="dia"  name="dia">
                                    <option selected value="">Seleccione el día para la sesión</option>
                                    @foreach($horarios as $horario)
                                    @php
                                    $fecha = new Date($horario->DAY);
                                    $fecha = $fecha->format('l d').' de '.$fecha->format('F');
                                    $value = new Date($horario->DAY);
                                    $value = $value->format('Y-m-d');
                                    @endphp
                                    <option value="{{$value}}">{{$fecha}}</option>
                                    @endforeach
                                </select>
                                <small><span class="text-danger mensajeError" id="dia_error"></span></small>
                          @endisset
                        </div>
                        <div class="form-group col-6">
                          <strong><label for="hora_inicio">Hora inicio</label><label class="text-danger">*</label></strong>
                          <input type="time" name="hora_inicio" id="hora_inicio" class="form-control">
                          <small><span class="text-danger mensajeError" id="hora_inicio_error"></span></small>
                        </div>
                        <div class="form-group col-6">
                          <strong><label for="hora_fin">Hora fin</label><label class="text-danger"> *</label></strong>
                          <input type="time" name="hora_fin" id="hora_fin" class="form-control">
                          <small><span class="text-danger mensajeError" id="hora_fin_error"></span></small>
                        </div>
                        <div class="form-group col-12">
                          <strong><label for="lugar">Lugar</label><label class="text-danger"> *</label></strong>
                          @isset($locaciones)
                                <select class="form-control lugar" id="lugar"  name="lugar">
                                    <option selected value="">Seleccione locación</option>
                                    @foreach($locaciones as $locacion)
                                    @php
                                    <option value="{{$locacion->id_locacion}}">{{$locacion->nombre}}</option>
                                    @endforeach
                                </select>
                                <small><span class="text-danger mensajeError" id="lugar_error"></span></small>
                          @endisset
                        </div>
                        <div class="form-group col-4">
                          <strong><label for="cantidad">Cantidad Participantes</label> <label class="text-danger"> *</label></strong>
                          <input type="number" name="cantidad" id="cantidad" class="form-control" placeholder="Número de participantes por sesión" value="0" min="0" max="99" onKeyUp="validacion(this)">
                          <small><span class="text-danger mensajeError" id="cantidad_error"></span></small>
                        </div>
                    </div>
                <div id="mostrar_alumnos" class="ml-3 mr-3"></div>
                <small><span class="text-danger mensajeError pt-2" id="participantes_error"></span></small>
                </form>
                <strong class="text-danger">Campos requeridos *</strong>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger cerrar-modal" id="btn-close" data-dismiss="modal"
                    value="cerrar">Cancelar
                </button>
                <button type="button" class="btn btn-primary" id="btn-save" value="create">Guardar
                </button>
                
            </div>
            
        </div>
    </div>
</div>
<script>
var validacion = function(x){
    var cantidad = $('#cantidad').val();
    var participantes = $('input:checkbox:checked').length;
    if(x.value>99)
        {x.value='99';
    }else if(x.value< participantes)
    {x.value= participantes;}
}
var mano = function(zaca){
    var cantidad = $('#cantidad').val();
    var participantes = $('input:checkbox:checked').length;
    if(participantes > cantidad ){
        $(zaca).prop('checked', false);
        
    }else{
        if($(zaca).prop('checked')){
            $(zaca).prop('checked', true);
            $('#cantidad').prop('min',participantes);
        }
    }
    
    
    
};
var cambio =  function(opcion,opcion2){
    
    var moda = $('#modalidad').val();
    console.log(moda);
    $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: '{{URL::to("/")}}/sesion/alumnosSeleccionados/'+opcion+'/'+opcion2,
                type: "POST",
                data: {  modalidad: moda
                },
                success: function (data) {
                },
                error: function (xhr, ajaxOptions, thrownError) {
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
                complete: function (data) {
                    if(data.status == 200){
                        var registros = data.responseJSON;
                        if(registros.length > 0){
                            
                            var insertar = '<div class="row" style="max-height:100px; overflow-y: scroll">';
                            var x = 0;
                            var aaa = parseInt($("#sesion_id").val());
                            console.log(aaa);
                            $.each(registros, function (key, value) {
                                var aux = value;
                                insertar += '<div class="col-4 col-sm-4 col-md-3 col-lg-3 border float-left pt-3 pb-3 pl-2 pr-1">'; 
                                if(value.id_sesion == 0  || value.id_sesion != aaa )
                                    insertar += '<input type="checkbox" onclick="mano(this)" value="'+value.id_trabajo+'" name="trabajos[]"> ' ;
                                else
                                    insertar += '<input type="checkbox" checked onclick="mano(this)" value="'+value.id_trabajo+'" name="trabajos[]"> ' ;

                                    insertar += value.usuarios['nombre'] +' '+value.usuarios['primer_apellido'] +' '+ value.usuarios['segundo_apellido'] + '</div>';
                                x++
                            });
                            insertar += '</div>';
                            $('#mostrar_alumnos').html(insertar);
                        }else{
                            $('#mostrar_alumnos').html("<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>No hay alumnos registrados para esta modalidad</strong> <button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>&times;</span></button></div>");
                        }
                    }
                }

    });
}


</script>