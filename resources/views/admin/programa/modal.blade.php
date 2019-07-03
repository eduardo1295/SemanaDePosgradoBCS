<div class="modal fullscreen-modal fade" id="programa-crud-modal" aria-hidden="true" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="programaCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form id="programaForm" name="programaForm" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="programa_id_pro" id="programa_id_pro">


                    <div class="form-row">
                        <div class="form-group col-12 col-sm-6">
                                <strong><label for="id_programa" class="control-label">Clave del programa</label><label class="text-danger">*</label></strong>
                                <input type="text" class="form-control" id="id_programa_pro" name="id_programa_pro" placeholder="Ingrese Clave del programa"
                                    value="" maxlength="100" required="">
                                <small><span class="text-danger mensajeError" id="id_programa_pro_error"></span></small>
                        </div>
                        @if (auth('admin')->user())
                            <div class="form-group col-12 col-sm-6">
                                <strong><label for="id_institucion" class="control-label">Institución</label><label class="text-danger">*</label></strong>
                                <select class="form-control" id="id_institucion_pro" name="id_institucion_pro">
                                    <option selected value="">Seleccione una institución</option>
                                    @foreach ($instituciones as $institucion)
                                    <option value={{$institucion->id}}>{{$institucion->nombre}}</option>
                                    @endforeach
                                </select>
                                <small><span class="text-danger mensajeError" id="id_institucion_pro_error"></span></small>
                            </div>
                        @endif

                        <div class="form-group col-12 col-sm-6">
                            <strong><label for="nombre" class="control-label">Nombre</label><label class="text-danger">*</label></strong>
                            <input type="text" class="form-control" id="nombre_pro" name="nombre_pro" placeholder="Ingrese el nombre del programa"
                               value="" maxlength="100" required="">
                            <small> <span class="text-danger mensajeError" id="nombre_pro_error"></span> </small>                            
                                
                        </div>
                        <div class="form-group col-12 col-sm-6">
                            <strong><label for="nivel" class="control-label">Nivel</label><label class="text-danger">*</label></strong>
                            <select class="form-control" id="nivel_pro" name="nivel_pro">
                                <option selected value="">Seleccione nivel</option>
                                <option value="Maestría">Maestría</option>
                                <option value="Doctorado">Doctorado</option>
                            </select>
                            <small> <span class="text-danger mensajeError" id="nivel_pro_error"></span> </small>
                        </div>
                        <div class="form-group col-12 col-sm-6">
                                <strong> <label for="periodo" class="control-label">Periodo</label><label class="text-danger">*</label></strong>
                                <select class="form-control" id="periodo_pro" name="periodo_pro">
                                    <option selected value="">Seleccione periodo</option>
                                    <option value="Trimestre">Trimestre</option>
                                    <option value="Cuatrimestre">Cuatrimestre</option>
                                    <option value="Semestre">Semestre</option>
                                </select>
                                <small> <span class="text-danger mensajeError" id="periodo_pro_error"></span> </small>
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
                <strong class="text-danger">Campos requeridos *</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger cerrar-modal" id="btn-close" data-dismiss="modal"
                    value="cerrar">Cancelar
                </button>
                <button type="button" class="btn btn-primary" id="btn-save-pro" value="create">Guardar
                </button>
            </div>
        </div>
    </div>
</div>