<form id="institucionForm" name="institucionForm" class="form-horizontal" enctype="multipart/form-data">
    <div class="form-row">
        <div class="col-12" style="text-align:end">
            <div class="">
                <button type="button" class="btn btn-primary guardarInstitucion"
                    id="guardarInstitucion">Guardar</button>
            </div>
        </div>
    </div>
    <input type="hidden" name="institucion_id" id="institucion_id" value="{{ auth()->user()->id_institucion }}">
    <div class="form-row">
        <div class="form-group col-md-7">
           <strong> <label for="nombre" class="control-label">Nombre</label><label class="text-danger">*</label></strong>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de la institución"
                value="" maxlength="100" required>
            <small><span class="mensajeError text-danger" id="nombre_error"></span></small>

        </div>

        <div class="form-group col-md-5">
            <strong><label for="siglas" class="control-label">Siglas</label><label class="text-danger">*</label></strong>
            <input type="text" class="form-control" id="siglas" name="siglas" placeholder="Siglas de la institución"
                value="" maxlength=100" required>
            <small><span class="mensajeError text-danger" id="siglas_error"></span></small>

        </div>
    </div>



    <div class="form-row">
        <div class="form-group col-md-8">
            <strong><label for="direccion_web" class="control-label">Dirección Web</label><label class="text-danger">*</label></strong>

            <input type="text" class="form-control" id="direccion_web" name="direccion_web"
                placeholder="Ingrese la URL de la institución" value="" required="" maxlength="100">
            <small><span class="mensajeError text-danger" id="direccion_web_error"></span></small>

        </div>

        <div class="form-group col-md-4">
            <strong><label for="telefono" class="control-label">Télefono</label><label class="text-danger">*</label></strong>
            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Télefono" value=""
                required="" maxlength="20">
            <small><span class="mensajeError text-danger" id="telefono_error"></span></small>

        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-5">
            <strong><label for="ciudad" class="control-label">Ciudad</label><label class="text-danger">*</label></strong>

            <input type="text" class="form-control" id="ciudad" name="ciudad" placeholder="Ciudad de la institución"
                value="" required="" maxlength="30">
            <small><span class="mensajeError text-danger" id="ciudad_error"></span></small>

        </div>

        <div class="form-group col-md-5">
            <strong><label for="calle" class="control-label">Calle</label><label class="text-danger">*</label></strong>

            <input type="text" class="form-control" id="calle" name="calle" placeholder="Calle de la institución"
                value="" required="" maxlength="30">
            <small><span class="mensajeError text-danger" id="calle_error"></span></small>

        </div>

        <div class="form-group col-md-2">
            <strong><label for="numero" class=" control-label">Número</label><label class="text-danger">*</label></strong>

            <input type="text" class="form-control" id="numero" name="numero" placeholder="0000" value="" required="" maxlength="5">
            <small><span class="mensajeError text-danger" id="numero_error"></span></small>

        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-9">
            <strong><label for="colonia" class="control-label">Colonia</label><label class="text-danger">*</label></strong>

            <input type="text" class="form-control" id="colonia" name="colonia" placeholder="Colonia" value=""
                required="" maxlength="30">
            <small><span class="mensajeError text-danger" id="colonia_error"></span></small>

        </div>

        <div class="form-group col-md-3">
            <strong><label for="cp" class="control-label">CP</label><label class="text-danger">*</label></strong>

            <input type="text" class="form-control" id="cp" name="cp" placeholder="00000" value="" required="" maxlength="10">
            <small><span class="mensajeError text-danger" id="cp_error"></span></small>

        </div>
    </div>
    <div class="form-row">


        <div class="form-group col-md-6">
            <strong><label id="imagenlogo"> Logo</label><label class="text-danger">*</label></strong>
            <div class="custom-file">
                <input type="file" name="logo" class="custom-file-input" id="logo" lang="es"
                accept="image/x-png,image/gif,image/jpeg" onchange="readURL(this,'vistaPrevia');mostrar('nuevoLogo');">
                <label for="logo" class="custom-file-label">Seleccionar Archivo</label>
            </div>

            <small><span class="mensajeError text-danger" id="logo"></span></small>
            <div class="row">


                <div id="logoAnterior" class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="imglogo" id="logoactual" class="control-label"></label>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="text-align:center">
                        <img style="height:240px" src="" alt="" id="imglogo" class="img-fluid mx-auto">
                    </div>
                </div>
                <div id="nuevoLogo" class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-none">
                    <label for="imglogo" id="textVP" class="control-label">Nuevo Logo</label>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="text-align:center">
                        <img style="height:240px" src="" alt="" id="vistaPrevia" class="img-fluid mx-auto">
                    </div>
                </div>
            </div>
        </div>


        <div class="form-group col-md-6" id="col-logo">
            <strong><label for="googleMap" class="control-label">Ubicación</label><label class="text-danger">*</label></strong>

            <div id="googleMap" style="height: 300px;"></div>
            <input type='hidden' name='lat' id='lat'>
            <input type='hidden' name='lng' id='lng'>
        </div>

    </div>
    <div class="form-row">
        <div class="col-12" style="text-align:end">
            <div class="">
                <button type="button" class="btn btn-primary guardarInstitucion"
                    id="guardarInstitucion">Guardar</button>
            </div>
        </div>
    </div>
</form>
<strong class="text-danger">Campos requeridos *</strong>