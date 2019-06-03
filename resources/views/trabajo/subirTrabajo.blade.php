{{-- SECCION BLADE--}}
@extends('layoutsM1.principal')

@section('contenido')
@section('links')
<link rel="stylesheet" href="/css/Maqueta2.css">
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
                                    <option value="Póster">Póster</option>
                                    <option value="Entrevista">Entrevista</option>
                                    <option value="Video">Video</option>
                                    <option value="Ponencia Oral">Ponencia Oral</option>
                                </select>
                            <small><span class="text-danger mensajeError errorposgrado" id="modalidad_error"></span></small>
                        </div>
                        <div class="form-group col-12">
                            <strong><label for="titulo" class="control-label">Titulo</label></strong>
                                <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Titulo del trabajo">
                            <small><span class="text-danger mensajeError errorposgrado" id="titulo_error"></span></small>
                        </div>
                        <div class="form-group col-12">
                            <strong><label for="resumen" class="control-label">Resumen</label></strong>
                            <textarea class="form-control" id="resumen" name="resumen" rows="5" placeholder="Resumen del programa"></textarea>
                        </div>
                        <div class="form-group col-12">
                            <strong><label for="customFileLang" class="control-label">Archivo</label></strong>
                            <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFileLang" lang="es" name="url">
                                    <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                            </div>
                        </div>
                    </div>
                    <strong><label for="clave" class="control-label pl-5">Palabra clave</label></strong> <br>
                    <div class="form-group row pl-5 pr-5">
                            <div class="col-12 col-sm pt-2 pt-sm-0"><input type="text" name="clave1"  id="clave1" class="form-control" placeholder="clave 1"></div>
                            <div class="col-12 col-sm pt-2 pt-sm-0"><input type="text" name="clave2"  id="clave2" class="form-control" placeholder="clave 2"></div>
                            <div class="col-12 col-sm pt-2 pt-sm-0"><input type="text" name="clave3"  id="clave3" class="form-control" placeholder="clave 3"></div>
                            <div class="col-12 col-sm pt-2 pt-sm-0"><input type="text" name="clave4"  id="clave4" class="form-control" placeholder="clave 4"></div>
                            <div class="col-12 col-sm pt-2 pt-sm-0"><input type="text" name="clave5"  id="clave5" class="form-control" placeholder="clave 5"></div>
                    </div>
                    <div class="form-row pl-5 pr-5 pb-3 ">

                        <div class="form-group col-12">
                            <strong><label for="directortesis" class="control-label">Director de tesis</label></strong>
                            <input type="text" class="form-control" id="directortesis" name="directortesis" placeholder="director de tesis">
                        </div>
                        <div class="form-group col-12">
                            <strong><label for="area" class="control-label">Área</label></strong>
                            <input type="text" class="form-control" id="area" name="area" placeholder="director de tesis" value="{{$programa->nombre}}" readonly>
                        </div>
                        <div class="col-12 d-flex justify-content-end pt-3">
                            <button type="button" class="btn btn-primary" id="btn-save" value="editar">Guardar
                            </button>
                        </div>        
                    </div>
                    
                    
                    
                </form>
            </div>
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