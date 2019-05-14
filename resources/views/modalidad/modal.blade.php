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
                    <div class="form-group">
                        <label for="resumen" class="control-label">Resumen</label>
                        <input type="text" class="form-control" id="resumen" name="resumen"
                            placeholder="Resumen de la modalidad" value="" maxlength="500" required="">
                        <span class="mensajeError" id="resumen_error"></span>

                    </div>
                    
                    <div class="row">
                        <div class="form-group col-6">
                            <strong><label for="id_institucion" class="control-label">Nivel</label></strong>
                            <select class="form-control" id="id_institucion" name="id_institucion">
                                <option selected value="">Seleccione el grado</option>
                                <option value="Maestria">Maestria</option>
                                <option value="Maestria">Doctorado</option>

                            </select>
                            <small><span class="text-danger mensajeError" id="id_institucion_error"></span></small>
                        </div>
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
                        

                        <div class="form-group col-6 pl-3">
                            <strong><label for="id_institucion" class="control-label">Grado</label></strong> <br>
                            <input id="ex25" type="text" class="ml-5" />    
                        </div>

                        
                        
                            
                    </div>
                    
                    
                        
                    


                    <div class="form-row mt-2">
                        <div class="form-group col-12">
                            <strong>Contenido:</strong>
                            <textarea class="summernote"  id="contenido" name="contenido"></textarea>
                          </div>
                          <span class="mensajeError" id="contenido_error"></span>
                    </div>

                    <div class="form-row mt-1">
                           
                                <div class="col-12">

                                        <div class="d-flex justify-content-end">
                                                <button class="btn btn-success preview-btn">Vista previa</button>
                                            </div>
                            
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



