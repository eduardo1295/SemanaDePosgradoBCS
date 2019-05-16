<div class="modal fullscreen-modal fade" id="noticia-crud-modal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="noticiaCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form id="noticiaForm" name="noticiaForm" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="semana_id" id="semana_id">

        <div class="form-group">
            <label for="nombre" class="control-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre"
                value="" maxlength="100" required="">
            <span class="mensajeError" id="nombre_error"></span>

        </div>

        <div class="form-group">
            <label for="fecha" class="control-label">Periodo del evento</label>
            <input type="text" id="fecha" name="fecha" class="form-control" value="{{date('Y-m-d')}} - {{date('Y-m-d')}}" >
            <span class="mensajeError" id="fecha_inicio_error"></span>
            <span class="mensajeError" id="fecha_fin_error"></span>
        </div>

        <div class="form-row mt-2">
                <div class="form-group col-12">
                    <strong>Información genereal:</strong>
                    <textarea class="summernote"  style=" word-wrap: break-word;"  id="contenido" name="contenido"></textarea>
                  </div>
                  <span class="mensajeError" id="infoge_error"></span>
        </div>

        <div class="form-row mt-1">
                           
            <div class="col-12">

                    <div class="d-flex justify-content-end">
                            <button class="btn btn-success preview-btn">Vista previa</button>
                        </div>
        
                </div>
</div>
        <div class="form-row">


            <div class="form-group col-md-6">
                <p id="logos"> Logo del evento:</p>
                <div class="custom-file">
                    <input type="file" name="imagensemana" class="custom-file-input" id="imagensemana" lang="es"
                        onchange="readURL(this,'vistaPrevia');mostrar('nuevaImagen');">
                    <label for="imagen" class="custom-file-label">Seleccionar Archivo</label>
                </div>

                <span class="mensajeError" id="imagensemana_error"></span>
                <div class="row">
                    <div id="imagenAnterior" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <label for="imgslide" id="imagenactualT" class="control-label"></label>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <img src="" alt="" id="imgslide" class="img-fluid mx-auto">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-6">
                <div id="nuevaImagen" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none">
                    <label for="imgni" id="textVP" class="control-label">Nuevo logo</label>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <img src="" alt="" id="vistaPrevia" class="img-fluid mx-auto">
                    </div>
                </div>
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