<div class="modal fullscreen-modal fade" id="director-crud-modal" aria-hidden="true" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="directorCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form id="directorForm" name="directorForm" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="director_id" id="director_id">
                    @if (auth('admin')->user())
                        <div class="form-group">
                            <label for="institucionSelect">Institución</label>
                            <select class="form-control" id="institucionSelect_di" name="id_institucion_di">
                                <option selected value="">Seleccione una institución</option>
                                @foreach ($instituciones as $institucion)
                                <option value={{$institucion->id}}>{{$institucion->nombre}}</option>
                                @endforeach
                            </select>
                            <small><span class="mensajeError text-danger" id="id_institucion_di_error"></span></small>
                        </div>
                    @endif

                    
                    <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email" class="control-label">Email</label>
                        <input type="email" class="form-control" id="email_di" name="email_di" placeholder="Email del usuario"
                            value="" maxlength="60" required="">
                        <small><span class="mensajeError text-danger" id="email_di_error"></span></small>

                    </div>

                    <div class="form-group col-md-6">
                        <label for="password" class="control-label">Contraseña</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="password_di" name="password_di"
                                placeholder="Contraseña para la cuenta" value="" maxlength="60" required=""
                                aria-describedby="passwordHelpBlock">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary btn-show-pass" onclick="mostrarContra('password_di',this)" type="button"><span>
                                        <i class="fas fa-eye"></i>
                                    </span></button>
                            </div>
                        </div>
                        <small id="passwordHelpBlock" class="form-text text-muted">
                                Su contraseña debe tener mínimo 6 caracteres, debe contener al menos 1 mayúscula, 1 minúscula, 1 numérica y 1 carácter especial(#?!@$^&-).
                        </small>
                        <small><span class="mensajeError text-danger" id="password_di_error"></span></small>
                    </div>
                </div>

                <div class="form-row">
                        <div class="form-group col-md-3">
                        <label for="grado" class="control-label">Grado</label>
                        <input type="text" class="form-control" id="grado_di" name="grado_di"
                            placeholder="Grado del director" value="" maxlength="30" required="">
                        <small><span class="mensajeError text-danger" id="grado_di_error"></span></small>

                    </div>

                <div class="form-group col-md-9">
                        <label for="nombre" class="control-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre_di" name="nombre_di"
                            placeholder="Nombre del usuario" value="" maxlength="40" required="">
                        <small><span class="mensajeError text-danger" id="nombre_di_error"></span></small>

                    </div>
                </div>
                    <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="primer_apellido" class="control-label">Primer apellido</label>
                        <input type="text" class="form-control" id="primer_apellido_di" name="primer_apellido_di"
                            placeholder="Primer apellido del usuario" value="" maxlength="30" required="">
                        <small><span class="mensajeError text-danger" id="primer_apellido_di_error"></span></small>

                    </div>

                    <div class="form-group col-md-6">
                        <label for="segundo_apellido" class="control-label">Segundo apellido</label>
                        <input type="text" class="form-control" id="segundo_apellido_di" name="segundo_apellido_di"
                            placeholder="Segundo apellido del usuario" value="" maxlength="30" required="">
                        <small><span class="mensajeError text-danger" id="segundo_apellido_di_error"></span></small>

                    </div>
                </div>

                    


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger cerrar-modal" id="btn-close" data-dismiss="modal"
                    value="cerrar">Cancelar
                </button>
                <button type="button" class="btn btn-primary" id="btn-save-director" value="create">Guardar
                </button>
            </div>
        </div>
    </div>
</div>