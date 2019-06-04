<div class="modal fullscreen-modal fade" id="alumno-crud-modal" aria-hidden="true" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="alumnoCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form id="alumnoForm" name="alumnoForm" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="alumno_id" id="alumno_id">
                    <div class="form-row">
                            <div class="form-group col-lg-6">
                        <label for="institucionSelect">Institución</label>
                        <select class="form-control" id="institucionSelect" name="id_institucion">
                            <option selected value="">Seleccione una institución</option>
                            @foreach ($instituciones as $institucion)
                            <option value={{$institucion->id}}>{{$institucion->nombre}}</option>
                            @endforeach
                        </select>
                        <small><span class="mensajeError text-danger" id="id_institucion_error"></span></small>
                    </div>

                    <div class="form-group col-lg-6">
                            <label for="programaSelect">Programa de posgrado</label>
                            <select class="form-control" id="programaSelect" name="programaSelect">
                                
                                
                            </select>
                            <small><span class="mensajeError text-danger" id="programaSelect_error"></span></small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
                    <label for="institucionSelect">Director de tesis</label>
                    <select class="form-control" id="directorSelect" name="directorSelect">
                        
                        
                    </select>
                    <small><span class="mensajeError text-danger" id="directorSelect_error"></span></small>
                </div>

                </div>
                    <div class="form-row">
                            
                        <div class="form-group col-lg-6">
                            <label for="email" class="control-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email"
                                placeholder="Email del usuario" value="" maxlength="60" required="">
                            <small><span class="mensajeError text-danger" id="email_error"></span></small>

                        </div>

                        <div class="form-group col-lg-6">
                            <label for="password" class="control-label">Contraseña</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Contraseña para la cuenta" value="" maxlength="60" required=""
                                    aria-describedby="passwordHelpBlock">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary btn-show-pass" type="button"><span>
                                            <i class="fas fa-eye"></i>
                                        </span></button>
                                </div>
                            </div>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                Su contraseña debe tener mínimo 6 caracteres, debe contener al menos 1 letra mayúscula,
                                1 letra minúscula, 1 número y 1 carácter especial(#?!@$^&-).
                            </small>
                            <small><span class="mensajeError text-danger" id="password_error"></span></small>
                        </div>
                    </div>

                    <div class="form-row">
                            <div class="form-group col-lg-3">
                                    <label for="email" class="control-label">Número de control</label>
                                    <input type="text" class="form-control" id="num_control" name="num_control"
                                        placeholder="Número de control" value="" maxlength="60" required="">
                                    <small><span class="mensajeError text-danger" id="num_control_error"></span></small>
        
                                </div>

                        <div class="form-group col-lg-2">
                            <label for="semestre" class="control-label">Semestre</label>
                            <input type="text" class="form-control" id="semestre" name="semestre"
                                placeholder="Semestre del alumno" value="" maxlength="30" required="">
                            <small><span class="mensajeError text-danger" id="semestre_error"></span></small>

                        </div>

                        <div class="form-group col-lg-7">
                            <label for="nombre" class="control-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre"
                                placeholder="Nombre del alumno" value="" maxlength="40" required="">
                            <small><span class="mensajeError text-danger" id="nombre_error"></span></small>

                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label for="primer_apellido" class="control-label">Primer apellido</label>
                            <input type="text" class="form-control" id="primer_apellido" name="primer_apellido"
                                placeholder="Primer apellido" value="" maxlength="30" required="">
                            <small><span class="mensajeError text-danger" id="primer_apellido_error"></span></small>

                        </div>

                        <div class="form-group col-lg-6">
                            <label for="segundo_apellido" class="control-label">Segundo apellido</label>
                            <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido"
                                placeholder="Segundo apellido" value="" maxlength="30" required="">
                            <small><span class="mensajeError text-danger" id="segundo_apellido_error"></span></small>

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