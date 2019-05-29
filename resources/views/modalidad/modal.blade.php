<script>
var x = 1;
var y = 1;
var hola;
</script>
<div class="modal fullscreen-modal fade" id="modalidad-crud-modal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalidadCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form id="modalidadForm" name="modalidadForm" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="modalidad_id" id="modalidad_id">
                    <div class="form-group">
                        <label for="titulo" class="control-label">Titulo</label>
                        <input type="text" class="form-control" id="titulo" name="titulo"
                            placeholder="Titulo de la modalidad" value="" maxlength="500" required="">
                        <small><span class="mensajeError text-danger" id="nombres_error"></span></small>
                    </div>
                    <div class="row nr" id="nuevorenglon_1">
                        <div class="form-group col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                                    <strong><label for="posgrado" class="control-label">Posgrado</label></strong>
                                    <select class="form-control posgrado" id="posgrado" name="posgrado">
                                        <option selected value="">Seleccione posgrado</option>
                                        <option value="Maestría">Maestria</option>
                                        <option value="Doctorado">Doctorado</option>
        
                                    </select>
                                    <small><span class="text-danger mensajeError errorposgrado" id="posgrado.0_error"> asdas</span></small>
                        </div>
                        <div class="form-group col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                                    <strong><label for="periodo" class="control-label">Periodo</label></strong>
                                    <select class="form-control periodo" id="periodo"  name="periodo">
                                        <option selected value="">Seleccione periodo</option>
                                        <option value="Trimestre">Trimestre</option>
                                        <option value="Cuatrimestre">Cuatrimestre</option>
                                        <option value="Semestre">Semestre</option>
        
                                    </select>
                                    <small><span class="text-danger mensajeError errorperiodo" id="periodo.0_error"></span></small>
                        </div>
                        {{-- comment 
                        <div class="form-group col-6">
                                            <p><strong>Periodo</strong></p>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="trimestre">
                                                <label class="form-check-label" for="inlineCheckbox1">Trimestre</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="cuatrimestre">
                                                <label class="form-check-label" for="inlineCheckbox2">Cuatrimestre</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="semestre">
                                                    <label class="form-check-label" for="inlineCheckbox3">Semestre</label>
                                            </div>
                        </div>
                        --}}
                        <div class="form-group col-10 col-sm-10 col-md-10 col-lg-5 col-xl-5">	                        
                            <strong><label for="id_institucion" class="control-label">Grado</label></strong>  <br>	                            
                            <div id="slider" class="sliderrr ml-3 mr-3 mb-4" {{--style="margin-left: 20px; margin-right: 20px;" --}}></div>
                        </div>
                        <div class="form-group col-2 col-sm-2 col-md-2 col-lg-1 col-xl-1 d-flex align-items-center">	                        
                            <i class="fas fa-plus btn btn-primary " onclick="nuevooo()"></i>
                        </div>
                    </div>

                    <div class="form-row mt-2">
                        <div class="form-group col-12">
                            <strong>Descripción:</strong>
                            <textarea class="summernote"  id="contenido" name="contenido"></textarea>
                            <small><span class="text-danger mensajeError" id="contenido_error"></span></small>
                          </div>
                    </div>
                </form>
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
function filterPips(value, type) {
                if (type === 0) {
                    return value < 2000 ? -1 : 0;
                }
                return value % 1000 ? 2 : 1;
}
var nuevooo = function(){
    var auxid;
    $('.nr').each(function (i) {
        auxid = $(this)[0].id;
    });
    $('#'+auxid).after('<div class="row sliderQuitar nr" id="nuevorenglon_'+(x+1)+'">'+
                        '<div class="form-group col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3"> <strong>'+
                        '<label for="posgrado" class="control-label">Nivel</label></strong> <select class="form-control posgrado" id="posgrado'+x+
                        '" name="posgrado"><option selected value="">Seleccione el grado</option><option value="Maestría">Maestría</option><option value="Doctorado">Doctorado</option></select><small><span class="text-danger mensajeError errorposgrado" id="posgrado.'+(x)+'_error"></span></small></div>'+
                        '<div class="form-group col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3"><strong><label for="periodo" class="control-label">Nivel</label></strong><select class="form-control periodo" id="periodo" name="periodo"><option selected value="">Seleccione el grado</option><option value="Trimestre">Trimestre</option><option value="Cuatrimestre">Cuatrimestre</option><option value="Semestre">Semestre</option></select><small><span class="text-danger mensajeError errorperiodo" id="periodo.'+x+'_error"></span></small></div>'+
                        '<div class="form-group col-10 col-sm-10 col-md-10 col-lg-5 col-xl-5 pl-3 pb-3"><strong><label for="id_institucion" class="control-label">Grado</label></strong><br><div id="slider'+ x +'" class="sliderrr ml-3 mr-3 mb-4"></div></div><div class="form-group col-2 col-sm-2 col-md-2 col-lg-1 col-xl-1 d-flex align-items-center"><i class="fas fa-times btn btn-danger " onclick="quitar('+(x+1)+')"></i></div></div>');
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
    hola = $('#posgrado');

    $('.errorperiodo').each(function(i){
        $(this).attr('id','periodo.'+i+'_error')
    });
    $('.errorposgrado').each(function(i){
        $(this).attr('id','posgrado.'+i+'_error')
    });
}
var quitar = function(quita){
    console.log(quita);
    var quitando = $('#nuevorenglon_'+quita);
    $(quitando).remove();
    
    $('.errorperiodo').each(function(i){
        $(this).attr('id','periodo.'+i+'_error')
    });
    $('.errorposgrado').each(function(i){
        $(this).attr('id','posgrado.'+i+'_error')
    });
}

</script>