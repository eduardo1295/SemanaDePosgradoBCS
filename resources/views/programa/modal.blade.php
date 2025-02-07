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
                                <strong><label for="id_programa" class="control-label">Clave del programa</label></strong>
                                <input type="text" class="form-control" id="id_programa" name="id_programa" placeholder="Ingrese Clave del programa"
                                    value="" maxlength="100" required="">
                                <small><span class="text-danger mensajeError" id="id_programa_error"></span></small>
                        </div>
                        
                        <div class="form-group col-6">
                            <strong><label for="id_institucion" class="control-label">Institución</label></strong>
                            <select class="form-control" id="id_institucion" name="id_institucion">
                                <option selected value="">Seleccione una institución</option>
                                @foreach ($instituciones as $institucion)
                                <option value={{$institucion->id}}>{{$institucion->nombre}}</option>
                                @endforeach
                            </select>
                            <small><span class="text-danger mensajeError" id="id_institucion_error"></span></small>
                        </div>

                        <div class="form-group col-6">
                            <strong><label for="nombre" class="control-label">Nombre</label></strong>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese nombre"
                               value="" maxlength="100" required="">
                            <small> <span class="text-danger mensajeError" id="nombre_error"></span> </small>                            
                                
                        </div>
                        <div class="form-group col-6">
                            <strong><label for="nivel" class="control-label">Nivel</label></strong>
                            <select class="form-control" id="nivel" name="nivel">
                                <option selected value="">Seleccione nivel</option>
                                <option value="maestria">Maestría</option>
                                <option value="doctorado">Doctorado</option>
                            </select>
                            <small> <span class="text-danger mensajeError" id="nivel_error"></span> </small>
                        </div>
                        <div class="form-group col-6">
                                <strong> <label for="periodo" class="control-label">Periodo</label></strong>
                                <select class="form-control" id="periodo" name="periodo">
                                    <option selected value="">Seleccione periodo</option>
                                    <option value="trimestre">Trimestre</option>
                                    <option value="cuatrimestre">Cuatrimestre</option>
                                    <option value="semestre">Semestre</option>
                                </select>
                                <small> <span class="text-danger mensajeError" id="periodo_error"></span> </small>
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