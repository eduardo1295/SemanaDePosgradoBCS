<div class="modal fullscreen-modal fade" id="carrusel-crud-modal" aria-hidden="true" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="carruselCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form id="carruselForm" name="carruselForm" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="carrusel_id" id="carrusel_id">

                    <div class="form-group">
                        <label for="link" class="control-label">Link</label>
                        <input type="text" class="form-control" id="link" name="link"
                            placeholder="Link para la imagen" value="" maxlength="500" required="">
                        <span class="mensajeError" id="link_error"></span>

                    </div>



                    
                    <div class="form-row">


                        <div class="form-group col-md-6">
                            <p id="imagenslider"> Imagen:</p>
                            <div class="custom-file">
                                <input type="file" name="imagen" class="custom-file-input" id="imagen" lang="es"  onchange="readURL(this,'vistaPrevia');mostrar('nuevoLogo');">
                                <label for="imagen" class="custom-file-label">Seleccionar Archivo</label>
                            </div>

                            <span class="mensajeError" id="imagen_error"></span>
                            <div class="row">

                            
                                <div id="logoAnterior" class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                    <label for="imgslide" id="imagenactual" class="control-label"></label>

                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <img src="" alt="" id="imgslide" class="img-fluid mx-auto">
                                    </div>
                                </div>
                                <div id="nuevoLogo" class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-none">
                                    <label for="imgni" id="textVP" class="control-label">Nueva imagen</label>

                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <img src="" alt="" id="vistaPrevia" class="img-fluid mx-auto">
                                    </div>
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