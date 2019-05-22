<script>
var x = 1, libre = new Array();
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
                        <span class="mensajeError" id="titulo_error"></span>
                    </div>
                    <div class="row nr" id="nuevorenglon_1">
                        <div class="form-group col-3">
                                    <strong><label for="posgrado" class="control-label">Nivel</label></strong>
                                    <select class="form-control posgrado" id="posgrado" name="posgrado">
                                        <option selected value="">Seleccione el grado</option>
                                        <option value="maestria">Maestria</option>
                                        <option value="doctorado">Doctorado</option>
        
                                    </select>
                                    <small><span class="text-danger mensajeError" id="id_institucion_error"></span></small>
                        </div>
                        <div class="form-group col-3">
                                    <strong><label for="periodo" class="control-label">Nivel</label></strong>
                                    <select class="form-control periodo" id="periodo"  name="periodo">
                                        <option selected value="">Seleccione el grado</option>
                                        <option value="trimestre">Trimestre</option>
                                        <option value="cuatrimestre">Cuatrimestre</option>
                                        <option value="semestre">Semestre</option>
        
                                    </select>
                                    <small><span class="text-danger mensajeError" id="id_institucion_error"></span></small>
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
                        <div class="form-group col-5 pl-3 pb-3">	                        
                            <strong><label for="id_institucion" class="control-label">Grado</label></strong>  <br>	                            
                            <div id="slider" class="sliderrr"></div>
                        </div>
                        <div class="form-group col-1 d-flex align-items-center">	                        
                            <i class="fas fa-plus btn btn-primary " onclick="nuevooo()"></i>
                        </div>
                    </div>

                    <div class="form-row mt-2">
                        <div class="form-group col-12">
                            <strong>Contenido:</strong>
                            <textarea class="summernote"  id="contenido" name="contenido"></textarea>
                          </div>
                          <span class="mensajeError" id="contenido_error"></span>
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
    
    $( '#nuevorenglon_'+x).after('<div class="row sliderQuitar nr" id="nuevorenglon_'+(x+1)+'"><div class="form-group col-3"> <strong><label for="posgrado" class="control-label">Nivel</label></strong> <select class="form-control posgrado" id="posgrado" name="posgrado"><option selected value="">Seleccione el grado</option><option value="maestria">Maestria</option><option value="doctorado">Doctorado</option></select><small><span class="text-danger mensajeError" id="id_institucion_error"></span></small></div><div class="form-group col-3"><strong><label for="periodo" class="control-label">Nivel</label></strong><select class="form-control periodo" id="periodo" name="periodo"><option selected value="">Seleccione el grado</option><option value="trimestre">Trimestre</option><option value="cuatrimestre">Cuatrimestre</option><option value="semestre">Semestre</option></select><small><span class="text-danger mensajeError" id="id_institucion_error"></span></small></div><div class="form-group col-5 pl-3 pb-3"><strong><label for="id_institucion" class="control-label">Grado</label></strong><br><div id="slider'+ x +'" class="sliderrr"></div></div><div class="form-group col-1 d-flex align-items-center"><i class="fas fa-times btn btn-danger " onclick="quitar('+(x+1)+')"></i></div></div>');
    var slider = document.getElementById('slider'+x);
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
    hola = $('#posgrado');

}
var quitar = function(quita){
    console.log(quita);
    var quitando = $('#nuevorenglon_'+quita);
    libre.push(quitando[0].id.split('_')[1]);
    $(quitando).remove();
    console.log(quitando);
    x--;
    
}

</script>