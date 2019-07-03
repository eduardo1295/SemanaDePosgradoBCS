<div class="modal fullscreen-modal fade" id="alumno-crud-modal" aria-hidden="true" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="alumnoCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form id="alumnoForm" name="alumnoForm" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="alumno_id_al" id="alumno_id_al">
                    
                            @if (auth('admin')->user())
                            <div class="form-group">
                        <strong><label for="institucionSelect_al">Institución</label><label class="text-danger"> *</label></strong>
                        <select class="form-control" id="institucionSelect_al" name="id_institucion_al">
                            <option selected value="">Seleccione una institución</option>
                            @foreach ($instituciones as $institucion)
                            <option value={{$institucion->id}}>{{$institucion->nombre}}</option>
                            @endforeach
                        </select>
                        <small><span class="mensajeError text-danger" id="id_institucion_al_error"></span></small>
                    </div>
                    @endif
                    <div class="form-row">
                    <div class="form-group col-lg-8">
                            <strong><label for="programaSelect_al">Programa de posgrado</label><label class="text-danger"> *</label></strong>
                            <select class="form-control" id="programaSelect_al" name="programaSelect_al">
                                
                                
                            </select>
                            <small><span class="mensajeError text-danger" id="programaSelect_al_error"></span></small>
                        </div>

                        <div class="form-group col-lg-4">
                    <strong><label for="institucionSelect_al">Director de tesis</label><label class="text-danger"> *</label></strong>
                    <select class="form-control" id="directorSelect_al" name="directorSelect_al">
                        
                        
                    </select>
                    <small><span class="mensajeError text-danger" id="directorSelect_al_error"></span></small>
                </div>

                </div>
                    <div class="form-row">
                            
                        <div class="form-group col-lg-6">
                            <strong><label for="email_al" class="control-label">Email</label><label class="text-danger"> *</label></strong>
                            <input type="text" class="form-control" id="email_al" name="email_al"
                                placeholder="Email del usuario" value="" maxlength="60" required="">
                            <small><span class="mensajeError text-danger" id="email_al_error"></span></small>

                        </div>

                        <div class="form-group col-lg-6">
                            <strong><label for="password_al" class="control-label">Contraseña</label><label class="text-danger"> *</label></strong>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" id="password_al" name="password_al"
                                    placeholder="Contraseña para la cuenta" value="" maxlength="60" required=""
                                    aria-describedby="passwordHelpBlock">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary btn-show-pass" onclick="mostrarContra('password_al',this)" type="button"><span>
                                            <i class="fas fa-eye"></i>
                                        </span></button>
                                </div>
                            </div>
                            
                            <small><span class="mensajeError text-danger" id="password_al_error"></span></small>
                        </div>
                    </div>

                    <div class="form-row">
                            <div class="form-group col-lg-3">
                                    <strong><label for="num_control_al" class="control-label">Número de control</label><label class="text-danger"> *</label></strong>
                                    <input type="text" class="form-control" id="num_control_al" name="num_control_al"
                                        placeholder="Número de control" value="" maxlength="60" required="">
                                    <small><span class="mensajeError text-danger" id="num_control_al_error"></span></small>
        
                                </div>

                        <div class="form-group col-lg-2">
                            <strong><label for="semestre_al" class="control-label">Semestre</label><label class="text-danger"> *</label></strong>
                            <input type="number" value="1" min="1" max="10" step="1" class="form-control" id="semestre_al" name="semestre_al"
                                required>
                            <small><span class="mensajeError text-danger" id="semestre_al_error"></span></small>

                        </div>

                        <div class="form-group col-lg-7">
                            <strong><label for="nombre_al" class="control-label">Nombre</label><label class="text-danger"> *</label></strong>
                            <input type="text" class="form-control" id="nombre_al" name="nombre_al"
                                placeholder="Nombre del alumno" value="" maxlength="40" required="">
                            <small><span class="mensajeError text-danger" id="nombre_al_error"></span></small>

                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <strong><label for="primer_apellido_al" class="control-label">Primer apellido</label><label class="text-danger"> *</label></strong>
                            <input type="text" class="form-control" id="primer_apellido_al" name="primer_apellido_al"
                                placeholder="Primer apellido" value="" maxlength="30" required="">
                            <small><span class="mensajeError text-danger" id="primer_apellido_al_error"></span></small>

                        </div>

                        <div class="form-group col-lg-6">
                            <strong><label for="segundo_apellido_al" class="control-label">Segundo apellido</label><label class="text-danger"> *</label></strong> 
                            <input type="text" class="form-control" id="segundo_apellido_al" name="segundo_apellido_al"
                                placeholder="Segundo apellido" value="" maxlength="30" required="">
                            <small><span class="mensajeError text-danger" id="segundo_apellido_al_error"></span></small>

                        </div>
                    </div>
                </form>
                <strong class="text-danger">Campos requeridos *</strong>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger cerrar-modal" id="btn-close" data-dismiss="modal"
                    value="cerrar">Cancelar
                </button>
                <button type="button" class="btn btn-primary" id="btn-save-alumno" value="create">Guardar
                </button>
            </div>
        </div>
    </div>
</div>