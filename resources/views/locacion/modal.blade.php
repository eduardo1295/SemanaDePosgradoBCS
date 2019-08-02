<div class="modal fullscreen-modal fade" id="locacion-crud-modal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="locacionCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form id="locacionForm" name="locacionForm" class="form-horizontal" enctype="multipart/form-data">
                <input type="hidden" name="id_locacion" id="id_locacion" class="id_locacion">
                <div class="form-group">
                  <strong><label for="nombre">Nombre</label><label class="text-danger"> *</label></strong>
                  <input type="text" maxlength="60" name="nombre" id="nombre" class="form-control" placeholder="Nombre de la Locacion" aria-describedby="helpId">
                  <small><span class="text-danger mensajeError" id="nombre_error"></span></small>
                </div>
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