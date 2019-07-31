{{-- SECCION BLADE--}}
@extends('Plantilla.principal')
@section('contenido')
@section('links')
<link rel="stylesheet" href="{{ asset('/css/Maqueta2.css')}}">
<link rel="stylesheet" href="{{ asset('/css/modales/snackbar.css')}}">

@endsection
<section id="trabajo">
        <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1 id="Titulo" class="display-   font-weight-bold rounded p-auto pt-3">Subir trabajo</h1> <br>
                    </div>
                </div>
                <form id="trabajoForm" name="trabajoForm" class="formulario form-horizontal mb-5" enctype="multipart/form-data">
                    <input type="hidden" name="id_semana" id="id_semana" value="{{$semana->id}}">
                    <input type="hidden" name="id_director" id="id_director" value="5">
                    <input type="hidden" name="id_alumno" id="id_alumno" value="{{auth()->user()->id}}">
                    <div class="form-row pl-5 pr-5 pt-3">
                        <div class="form-group col-12">
                            <strong><label for="modalidad" class="control-label">Modalidad</label><label class="text-danger">*</label></strong></strong>
                            
                                <select class="form-control modalidad" id="modalidad" name="modalidad">
                                    <option selected value="">Seleccione modalidad</option>
                                    @foreach ($modalidades as $modalidadP)   
                                        @if(isset($trabajo))
                                            @if($modalidadP->id_modalidad == $trabajo->modalidad)
                                            <option value="{{$modalidadP->id_modalidad}}" selected>{{$modalidadP->nombre}} </option>
                                            @else
                                            <option value="{{$modalidadP->id_modalidad}}">{{$modalidadP->nombre}} </option>
                                            @endif
                                        @else
                                        
                                        <option value="{{$modalidadP->id_modalidad}}">{{$modalidadP->nombre}} </option>
                                        @endif
                                    @endforeach
                                </select>
                            <small><span class="text-danger mensajeError errorposgrado" id="modalidad_error"></span></small>
                        </div>
                        <div class="form-group col-12">
                            <strong><label for="titulo" class="control-label">Título</label><label class="text-danger">*</label></strong></strong>
                        <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Titulo del trabajo" value="@isset($trabajo){{$trabajo->titulo}}@endisset">
                            <small><span class="text-danger mensajeError errorposgrado" id="titulo_error"></span></small>
                        </div>
                        <div class="form-group col-12">
                            <strong><label for="resumen" class="control-label">Resumen</label><label class="text-danger">*</label></strong></strong>
                            <textarea class="form-control" id="resumen" name="resumen" rows="5" placeholder="Resumen del programa">@isset($trabajo){{$trabajo->resumen}}@endisset</textarea>
                            <small><span class="text-danger mensajeError errorposgrado" id="resumen_error"></span></small>
                        </div>
                        <div class="form-group col-12">
                            <strong><label for="customFileLang" class="control-label">Trabajo: </label><label class="text-danger">*</label></strong></strong>
                            @isset($trabajo)
                            <a href='{{ URL::to("/") }}/documentos/trabajos/{{$trabajo->url}}'target="_blank" id="link" >Entrega Actual</a>
                            <input type="hidden" name="auxUrl" value="{{$trabajo->url}}">
                            @endisset
                            <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFileLang" lang="es" name="url" accept="application/pdf" >
                                    <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                            </div>
                            <small><span class="text-danger mensajeError errorposgrado" id="url_error"></span></small>
                        </div>
                    </div>
                    <strong><label for="clave" class="control-label pl-5">Palabra clave</label><label class="text-danger">*</label></strong></strong><br>
                    <div class="form-group row pl-5 pr-5" >
                        <div class="col-12 col-sm-6 pb-2 col-md pb-md-0 pt-2 pt-sm-0"><input type="text" name="pal_clv1"  id="pal_clv1" class="form-control" placeholder="clave 1" value="@isset($trabajo){{$trabajo->pal_clv1}}@endisset"></div>
                        <div class="col-12 col-sm-6 pb-2 col-md pb-md-0 pt-2 pt-sm-0 d-md-none"><small><span class="text-danger mensajeError errorposgrado pal_clv1_error" id=""></span></small></div>
                        <div class="col-12 col-sm-6 pb-2 col-md pb-md-0 pt-2 pt-sm-0"><input type="text" name="pal_clv2"  id="pal_clv2" class="form-control" placeholder="clave 2" value="@isset($trabajo){{$trabajo->pal_clv2}}@endisset"></div>
                        <div class="col-12 col-sm-6 pb-2 col-md pb-md-0 pt-2 pt-sm-0 d-md-none"><small><span class="text-danger mensajeError errorposgrado pal_clv2_error" id=""></span></small></div>
                        <div class="col-12 col-sm-6 pb-2 col-md pb-md-0 pt-2 pt-sm-0"><input type="text" name="pal_clv3"  id="pal_clv3" class="form-control" placeholder="clave 3" value="@isset($trabajo){{$trabajo->pal_clv3}}@endisset"></div>
                        <div class="col-12 col-sm-6 pb-2 col-md pb-md-0 pt-2 pt-sm-0 d-md-none"><small><span class="text-danger mensajeError errorposgrado pal_clv3_error" id=""></span></small></div>
                        <div class="col-12 col-sm-6 pb-2 col-md pb-md-0 pt-2 pt-sm-0"><input type="text" name="pal_clv4"  id="pal_clv4" class="form-control" placeholder="clave 4" value="@isset($trabajo){{$trabajo->pal_clv4}}@endisset"></div>
                        <div class="col-12 col-sm-6 pb-2 col-md pb-md-0 pt-2 pt-sm-0 d-md-none"><small><span class="text-danger mensajeError errorposgrado pal_cv4_error" id=""></span></small></div>
                        <div class="col-12 col-sm-6 pb-2 col-md pb-md-0 pt-2 pt-sm-0"><input type="text" name="pal_clv5"  id="pal_clv5" class="form-control" placeholder="clave 5" value="@isset($trabajo){{$trabajo->pal_clv5}}@endisset"></div>
                        <div class="col-12 col-sm-6 pb-2 col-md pb-md-0 pt-2 pt-sm-0 d-md-none"><small><span class="text-danger mensajeError errorposgrado pal_clv5_error" id=""></span></small></div>
                    </div>
                    <div class="form-group row pl-5 pr-5 d-none d-md-flex">
                        <div class="col-12 col-sm-6 pb-2 col-md pb-md-0 pt-2 pt-sm-0"><small><span class="text-danger mensajeError errorposgrado pal_clv1_error" id=""></span></small></div>
                        <div class="col-12 col-sm-6 pb-2 col-md pb-md-0 pt-2 pt-sm-0"><small><span class="text-danger mensajeError errorposgrado pal_clv2_error" id=""></span></small></div>
                        <div class="col-12 col-sm-6 pb-2 col-md pb-md-0 pt-2 pt-sm-0"><small><span class="text-danger mensajeError errorposgrado pal_clv3_error" id=""></span></small></div>
                        <div class="col-12 col-sm-6 pb-2 col-md pb-md-0 pt-2 pt-sm-0"><small><span class="text-danger mensajeError errorposgrado pal_clv4_error" id=""></span></small></div>
                        <div class="col-12 col-sm-6 pb-2 col-md pb-md-0 pt-2 pt-sm-0"><small><span class="text-danger mensajeError errorposgrado pal_clv5_error" id=""></span></small></div>
                    </div>
                    <div class="form-row pl-5 pr-5 pb-3 ">
                        <div class="form-group col-12">
                            <strong><label for="directortesis" class="control-label">Director de tesis</label><label class="text-danger">*</label></strong></strong>
                        <input value="{{ $director->nombre .' '. $director->primer_apellido .' '. $director->segundo_apellido }}" type="text" class="form-control" id="directortesis" name="directortesis" placeholder="director de tesis" readonly>
                        </div>
                        <div class="form-group col-12">
                            <strong><label for="area" class="control-label">Área</label><label class="text-danger">*</label></strong></strong>
                            <input type="text" class="form-control" id="area" name="area" placeholder="programa de estudios" value="@isset($programa){{$programa->nombre}}@endisset" readonly>
                        </div>
                        <div class="col-12 d-flex pt-3 d-flex justify-content-between">
                            <strong class="text-danger">Campos requeridos *</strong>
                            @if(isset($trabajo))
                                @if($trabajo->autorizado == 1)
                                    <button type="button" class="btn btn-success" disabled id="btn-save" value="editar">Tu trabajo fue aprobado</button>
                                @elseif($trabajo->revisado == 0 && $trabajo->url != "")
                                    <button type="button" class="btn btn-secondary" disabled id="btn-save" value="editar">No ha sido revisado</button> 
                                @else
                                    <button type="button" class="btn btn-primary" id="btn-save" value="editar">Guardar</button>
                                @endif
                            @else
                            <button type="button" class="btn btn-primary " id="btn-save" value="editar">Guardar</button>
                            @endif
                        </div>        
                    </div>
                </form>
                
            </div>
            <div id="snackbar"></div> 
            <div id="snackbarError"></div>
</section>
<script>

$('.custom-file-input').on('change', function () {
        let fileName = $(this).val().split('\\').pop();
        if (!fileName.trim()) {
            $(this).next('.custom-file-label').removeClass("selected").html('Ningún archivo seleccionado');
        } else {
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        }
    })
</script>
{{-- END SECCION BLADE--}}
@section('scripts')
<script src="{{ asset('js/trabajo/subirtrabajo.js') }}"></script>
<script src="{{ asset('js/snack/snack.js') }}"></script>
<script>
var rutaBase = "{{route('trabajo.index')}}"
</script>
@endsection
@endsection