<div class="modal fullscreen-modal fade" id="Conacy-crud-modal" aria-hidden="true" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="conacytCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form id="conacytForm" name="conacytForm" class="form-horizontal" enctype="multipart/form-data">
                <div class="form-group col-md-12">
                    <strong><label id="imagenlogo"> Logo:</label><label class="text-danger">*</label></strong>
                    <div class="custom-file">
                        <input type="file" name="logo" class="custom-file-input" id="logo" lang="es" accept="image/png, image/jpeg">
                        <label for="logo" class="custom-file-label">Seleccionar Archivo</label>
                    </div>
                </div>                    
                <div class="col-12 pt-2">
                    @if(file_exists( public_path(). '/img/logo/conacyt.png'))
                        <label for="">Imagen actual:</label> <br>
                        <img src="/img/logo/conacyt.png" alt="" width="125px" height="90px">
                    @endif
                </div>
                
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger cerrar-modal" id="btn-close" data-dismiss="modal"
                    value="cerrar">Cancelar
                </button>
                <button type="button" class="btn btn-primary" id="guardar-conacyt" value="create">Guardar
                </button>
            </div>
        </div>
    </div>
</div>