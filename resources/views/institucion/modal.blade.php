<div class="modal fullscreen-modal fade" id="institucion-crud-modal" aria-hidden="true" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="institucionCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form id="institucionForm" name="institucionForm" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="institucion_id" id="institucion_id">

                    <div class="form-group">
                        <label for="nombre" class="control-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                            placeholder="Nombre de la institución" value="" maxlength="500" required="">
                        <span class="mensajeError" id="nombre_error"></span>

                    </div>



                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label class="control-label">Dirección Web</label>

                            <input type="text" class="form-control" id="direccion_web" name="direccion_web"
                                placeholder="Ingrese la URL de la institución" value="" required="">
                            <span class="mensajeError" id="direccion_web_error"></span>

                        </div>

                        <div class="form-group col-md-4">
                            <label class="control-label">Télefono</label>

                            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Télefono"
                                value="" required="">
                            <span class="mensajeError" id="telefono_error"></span>

                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label class="control-label">Ciudad</label>

                            <input type="text" class="form-control" id="ciudad" name="ciudad"
                                placeholder="Ciudad de la institución" value="" required="">
                            <span class="mensajeError" id="ciudad_error"></span>

                        </div>

                        <div class="form-group col-md-5">
                            <label class="control-label">Calle</label>

                            <input type="text" class="form-control" id="calle" name="calle"
                                placeholder="Calle de la institución" value="" required="">
                            <span class="mensajeError" id="calle_error"></span>

                        </div>

                        <div class="form-group col-md-2">
                            <label class=" control-label">Número</label>

                            <input type="text" class="form-control" id="numero" name="numero" placeholder="0000"
                                value="" required="">
                            <span class="mensajeError" id="numero_error"></span>

                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-9">
                            <label class="control-label">Colonia</label>

                            <input type="text" class="form-control" id="colonia" name="colonia" placeholder="Colonia"
                                value="" required="">
                            <span class="mensajeError" id="colonia_error"></span>

                        </div>

                        <div class="form-group col-md-3">
                            <label class="control-label">CP</label>

                            <input type="text" class="form-control" id="cp" name="cp" placeholder="00000" value=""
                                required="">
                            <span class="mensajeError" id="cp_error"></span>

                        </div>
                    </div>
                    <div class="form-row">
                        

                        <div class="form-group col-md-6">
                            <p id="imagenlogo"> Logo:</p>
                            <div class="custom-file">
                                <input type="file" name="logo" class="custom-file-input" id="logo" lang="es">
                                <label for="logo" class="custom-file-label">Seleccionar Archivo</label>
                            </div>

                            <span class="mensajeError" id="imgnoticia_error"></span>
                            <label for="imglogo" id="logoactual" class="control-label"></label>

                            <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                <img src="" alt="" id="imglogo" class="img-fluid mx-auto">
                            </div>
                        </div>

                        <div class="form-group col-md-6" id="col-logo">
                            <label for="googleMap" class="control-label">Ubicación</label>

                            <div id="googleMap" style="height: 300px;"></div>
                            <input type='hidden' name='latitud' id='lat'>
                            <input type='hidden' name='longitud' id='lng'>
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