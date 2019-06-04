{{-- SECCION BLADE--}}
@extends('Plantilla.principal')
@section('contenido')
@section('links')
<link rel="stylesheet" href="/css/Maqueta2.css">
<link href="/css/modales/snackbar.css" rel="stylesheet">
<script src="/js/owl.carousel.min.js"> </script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>
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
                    <input type="hidden" name="id_director" id="id_director" value="1">
                    <div class="form-row pl-5 pr-5 pt-3">
                        <div class="form-group col-12">
                            <strong><label for="posgrado" class="control-label">Modalidad</label></strong>
                                <select class="form-control posgrado" id="posgrado" name="posgrado">
                                    <option selected value="">Seleccione modalidad</option>
                                    @foreach ($modalidades as $modalidadP)
                                        <option value={{$modalidadP->id_modalidad}}>{{$modalidadP->nombre}}</option>
                                    @endforeach
                                </select>
                            <small><span class="text-danger mensajeError errorposgrado" id="modalidad_error"></span></small>
                        </div>
                        <div class="form-group col-12">
                            <strong><label for="titulo" class="control-label">Titulo</label></strong>
                        <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Titulo del trabajo" value="@isset($trabajo){{$trabajo->titulo}}@endisset">
                            <small><span class="text-danger mensajeError errorposgrado" id="titulo_error"></span></small>
                        </div>
                        <div class="form-group col-12">
                            <strong><label for="resumen" class="control-label">Resumen</label></strong>
                            <textarea class="form-control" id="resumen" name="resumen" rows="5" placeholder="Resumen del programa">@isset($trabajo){{$trabajo->resumen}}@endisset</textarea>
                            <small><span class="text-danger mensajeError errorposgrado" id="resumen_error"></span></small>
                        </div>
                        <div class="form-group col-12">
                            <strong><label for="customFileLang" class="control-label">Trabajo: </label></strong>
                            @isset($trabajo)
                            <a href='{{ URL::to("/") }}/documentos/trabajos/{{$trabajo->url}}'target="_blank" id="link" >Trabajo Subido</a>
                            <input type="hidden" name="auxUrl" value="{{$trabajo->url}}">
                            @endisset
                            <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFileLang" lang="es" name="url" accept="application/pdf" >
                                    <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                            </div>
                            <small><span class="text-danger mensajeError errorposgrado" id="url_error"></span></small>
                        </div>
                    </div>
                    <strong><label for="clave" class="control-label pl-5">Palabra clave</label></strong><br>
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
                            <strong><label for="directortesis" class="control-label">Director de tesis</label></strong>
                            <input type="text" class="form-control" id="directortesis" name="directortesis" placeholder="director de tesis">
                        </div>
                        <div class="form-group col-12">
                            <strong><label for="area" class="control-label">Área</label></strong>
                            <input type="text" class="form-control" id="area" name="area" placeholder="director de tesis" value="@isset($programa){{$programa->nombre}}@endisset" readonly>
                        </div>
                        <div class="col-12 d-flex justify-content-end pt-3">
                            <button type="button" class="btn btn-primary" id="btn-save" value="editar">Guardar
                            </button>
                        </div>        
                    </div>
                </form>
            </div>
            <div id="snackbar"></div>
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
@section('menu')
@include('layoutsM2.navbar')
@endsection
@section('footer')
@include('layoutsM2.footer')
@endsection
{{-- END SECCION BLADE--}}
@section('scripts')
<script src="/js/menumaker.js"></script>
<script src="/js/trabajo/subirtrabajo.js"></script>
@endsection
@endsection