<div class="modal fullscreen-modal fade" id="noticia-crud-modal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="noticiaCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form id="noticiaForm" name="noticiaForm" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="noticia_id" id="noticia_id">
                    
                    <div class="form-group">
                        <label for="titulo" class="control-label">Titulo</label>
                        <input type="text" class="form-control" id="titulo" name="titulo"
                            placeholder="Titulo de la noticia" value="" maxlength="500" required="">
                        <span class="mensajeError" id="titulo_error"></span>

                    </div>
                    <div class="form-group">
                        <label for="resumen" class="control-label">Resumen</label>
                        <input type="text" class="form-control" id="resumen" name="resumen"
                            placeholder="Resumen de la noticia" value="" maxlength="500" required="">
                        <span class="mensajeError" id="resumen_error"></span>

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

                    <div class="form-row mt-2">
                        <div class="form-group col-md-6">
                            <p id="imagennoticia1"> Imagen para la noticia:</p> 
                            <div class="custom-file">
                                <input type="file" name="imgnoticia" class="custom-file-input" id="imgnoticia" lang="es"
                                onchange="readURL(this,'vistaPrevia');mostrar('nuevaImagen');">
                                <label for="logo" class="custom-file-label">Seleccionar Archivo</label>
                                
                            </div>
                            
                            <span class="mensajeError" id="imgnoticia_error"></span>
                            
                        </div>
                        <div class="form-group col-md-6">
                            <div id="nuevaImagen" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none">
                                <label for="imgni" id="textVP" class="control-label">Nueva imagen</label>

                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <img src="" alt="" id="vistaPrevia" class="img-fluid mx-auto">
                                </div>
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