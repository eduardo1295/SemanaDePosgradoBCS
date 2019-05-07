<div class="modal fullscreen-modal fade" id="programa-crud-modal" aria-hidden="true" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="programaCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form id="programaForm" name="programaForm" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="programa_id" id="programa_id">


                    <div class="form-row">
                        <div class="form-group col-6">
                                <strong><label for="id_programa" class="control-label">Código</label></strong>
                                <input type="text" class="form-control" id="id_programa" name="id_programa" placeholder="Ingrese codigo"
                                    value="" maxlength="100" required="">
                                <span class="mensajeError" id="id_programa_error"></span>
                        </div>
                        
                        <div class="form-group col-6">
                            <strong><label for="id_institucion" class="control-label">Código</label></strong>
                            <select name="id_institucion" id="id_institucion" class="custom-select">
                                <option selected>Seleccione una institucion</option>
                                <option value="1">UABCS</option>
                                <option value="2">TEC</option>
                                <option value="3">CICIMAR</option>
                                <option value="4">CIBNOR</option>
                            </select>
                            <span class="mensajeError" id="id_programa_error"></span>
                        </div>

                        <div class="form-group col-6">
                            <strong><label for="nombre" class="control-label">Nombre</label></strong>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese nombre"
                                value="" maxlength="100" required="">
                            <span class="mensajeError" id="nivel_error"></span>
                        </div>
                        <div class="form-group col-6">
                            <strong><label for="nivel" class="control-label">nivel</label></strong>
                            <input type="text" class="form-control" id="nivel" name="nivel" placeholder="Ingrese nivel"
                                value="" maxlength="30" required="">
                            <span class="mensajeError" id="nivel_error"></span>
                        </div>
                        <div class="form-group col-6">
                                <strong> <label for="periodo" class="control-label">periodo</label></strong>
                                <input type="text" class="form-control" id="periodo" name="periodo" placeholder="Ingrese periodo"
                                    value="" maxlength="30" required="">
                                <span class="mensajeError" id="periodo_error"></span>
                        </div>
                        {{-- comment 
                        <div class="form-group col-6">
                            <select class="custom-select">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        --}}
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