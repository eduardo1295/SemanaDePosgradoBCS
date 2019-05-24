<div class="modal fullscreen-modal fade" id="semana-crud-modal" aria-hidden="true" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="semanaCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form id="semanaForm" name="semanaForm" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="semana_id" id="semana_id">

                    <div class="form-row">
                        <div class="form-group col-md-7">
                            <label for="nombre" class="control-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre"
                                value="" maxlength="100" required="">
                            <small><span class="mensajeError text-danger" id="nombre_error"></span></small>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="institucionSelect">Institución</label>
                            <select class="form-control" id="institucionSelect" name="id_institucion">
                                <option selected value="">Seleccione una institución</option>
                                @foreach ($instituciones as $institucion)
                                <option value={{$institucion->id}}>{{$institucion->nombre}}</option>
                                @endforeach
                            </select>
                            <small><span class="mensajeError text-danger" id="id_institucion_error"></span></small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="fecha" class="control-label">Periodo del evento</label>
                            <input type="text" id="fecha" name="fecha" class="form-control"
                                value="{{date('Y-m-d')}} - {{date('Y-m-d')}}">
                            <small><span class="mensajeError text-danger" id="fecha_inicio_error"></span></small>
                            <small><span class="mensajeError text-danger" id="fecha_fin_error"></span></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label id="ligaConvo"> Convocatoria</label>
                            
                            
                            
                            <div class="custom-file">
                                <input type="file" name="convocatoria" class="custom-file-input" id="convocatoria"
                                    lang="es">
                                <label for="convocan" class="custom-file-label">Seleccionar Archivo</label>
                            </div>
                            <small><span class="mensajeError text-danger" id="convocatoria_error"></span></small>
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
                            <strong>Información genereal:</strong>
                            <textarea class="summernote" style=" word-wrap: break-word;" id="contenido"
                                name="contenido"></textarea>
                                <small><span class="mensajeError text-danger" id="contenido_error"></span></small>
                            </div>
                        
                    </div>

                    <div class="form-row">


                        <div class="form-group col-md-6">
                            <p id="logos"> Logo del evento:</p>
                            <div class="custom-file">
                                <input type="file" name="imagensemana" class="custom-file-input" id="imagensemana"
                                    lang="es" onchange="readURL(this,'vistaPrevia');mostrar('nuevoLogo');">
                                <label for="imagen" class="custom-file-label">Seleccionar Archivo</label>
                            </div>

                            <small><span class="mensajeError text-danger" id="imagensemana_error"></span></small>
                            <div class="row">
                                <div id="imagenAnterior" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <label for="imglogo" id="imagenactualT" class="control-label"></label>

                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <img src="" alt="" id="imglogo" class="img-fluid mx-auto">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div id="nuevoLogo" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none">
                                <label for="imgN" id="textVP" class="control-label">Nuevo logo</label>

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