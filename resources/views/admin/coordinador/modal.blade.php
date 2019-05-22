<div class="modal fullscreen-modal fade" id="coordinador-crud-modal" aria-hidden="true" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="coordinadorCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form id="coordinadorForm" name="coordinadorForm" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="coordinador_id" id="coordinador_id">
                    <div class="form-group">
                        <label for="institucionSelect">Institución</label>
                        <select class="form-control" id="institucionSelect" name="id_institucion">
                            <option selected value="">Seleccione una institución</option>
                            @foreach ($instituciones as $institucion)
                            <option value={{$institucion->id}}>{{$institucion->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email" class="control-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email del usuario"
                            value="" maxlength="500" required="">
                        <span class="mensajeError" id="email_error"></span>

                    </div>

                    <div class="form-group col-md-6">
                        <label for="password" class="control-label">Contraseña</label>
                        <input type="text" class="form-control" id="password" name="password"
                            placeholder="Contraseña para la cuenta" value="" maxlength="500" required="">
                        <span class="mensajeError" id="password_error"></span>

                    </div>
                </div>

                <div class="form-row">
                        <div class="form-group col-md-3">
                        <label for="grado" class="control-label">Grado</label>
                        <input type="text" class="form-control" id="grado" name="grado"
                            placeholder="Grado del coordinador" value="" maxlength="500" required="">
                        <span class="mensajeError" id="grado_error"></span>

                    </div>

                <div class="form-group col-md-9">
                        <label for="nombre" class="control-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                            placeholder="Nombre del usuario" value="" maxlength="500" required="">
                        <span class="mensajeError" id="nombre_error"></span>

                    </div>
                </div>
                    <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="primer_apellido" class="control-label">Primer apellido</label>
                        <input type="text" class="form-control" id="primer_apellido" name="primer_apellido"
                            placeholder="Primer apellido del usuario" value="" maxlength="500" required="">
                        <span class="mensajeError" id="primer_apellido_error"></span>

                    </div>

                    <div class="form-group col-md-6">
                        <label for="segundo_apellido" class="control-label">Segundo apellido</label>
                        <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido"
                            placeholder="Segundo apellido del usuario" value="" maxlength="500" required="">
                        <span class="mensajeError" id="segundo_apellido_error"></span>

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