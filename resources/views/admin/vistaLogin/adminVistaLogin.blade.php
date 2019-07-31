@extends('admin.plantilla')
@section('contenido')

@php
 $datos = ['defecto.jpg','defecto.jpg'];    
 $x=0;
@endphp
@foreach ($vistas as $vista)
    @php
     $datos[$x] = $vista->url_imagen;
     $x++;    
    @endphp
@endforeach
<div class="container-fluid" id="#contenedor">
    <div class="row">
        <div class="col-12 mx-auto">
            <h1>Vista de Login</h1>
        </div>
    </div>
    <form id="VistaForm" name="VistaForm" class="form-horizontal" enctype="multipart/form-data">
    <div class="row">
        <div class="col-12 d-flex justify-content-between align-items-center ">
            <h3>Imagen de fondo login usuario</h3>
            <button class="btn btn-primary btn-guardar" id="" type="button">Guardar</button>
        </div>
        <div class="form-row col-12">
            <div class="form-group col-md-6 ">
                <p id="imagenslider"> Imagen actual:</p>
                <div class="custom-file">
                    <input type="file" name="imagenUsuario" class="custom-file-input" id="imagenUsuario" lang="es"
                        onchange="readURL(this,'vistaPrevia','nuevaImagen');mostrar('nuevaImagen');">
                    <label for="imagen" class="custom-file-label">Seleccionar Archivo</label>
                </div>
                <small><span class="mensajeError text-danger" id="imagenUsuario_error"></span></small>
                <div class="row">
                    <div id="imagenAnterior" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <label for="imgslide" id="imagenactualT" class="control-label"></label>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <img  src="{{ asset("/img/fondo/".$datos[0].'/?'.date('H:i:s')) }}" alt="" id="imgslide" class="img-fluid mx-auto">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-6 d-flex align-items-end">
                <div id="nuevaImagen" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none">
                    <label for="imgni" id="textVP" class="control-label">Nueva imagen</label>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <img src="" alt="" id="vistaPrevia" class="img-fluid mx-auto" style="height:250px">
                    </div>
                </div>
            </div>
        </div>
        <!---->
        <div class="col-12 d-flex justify-content-between align-items-center ">
                <h3>Imagen de fondo login Administrador</h3>
                <button class="btn btn-primary btn-guardar"  id="" type="button">Guardar</button>
            </div>
            <div class="form-row col-12">
                <div class="form-group col-md-6 ">
                    <p id="imagenslider"> Imagen actual:</p>
                    <div class="custom-file">
                        <input type="file" name="imagenAdmin" class="custom-file-input" id="imagenAdmin" lang="es"
                            onchange="readURL(this,'vistaPrevia2','nuevaImagen2');mostrar('nuevaImagen2','vistaPrevia2');">
                        <label for="imagen" class="custom-file-label">Seleccionar Archivo</label>
                    </div>
                    <small><span class="mensajeError text-danger" id="imagenAdmin_error"></span></small>
                    <div class="row">
                        <div id="imagenAnterior" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <label for="imgslide2" id="imagenactualT" class="control-label"></label>
    
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <img src="{{ asset("/img/fondo/".$datos[1].'/?'.date('H:i:s')) }}" alt="" id="imgslide2" class="img-fluid mx-auto">    
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6 d-flex align-items-end">
                    <div id="nuevaImagen2" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none">
                        <label for="imgni" id="textVP" class="control-label">Nueva imagen</label>
    
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <img alt="" id="vistaPrevia2" class="img-fluid mx-auto" style="height:250px">
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </form>
    

</div>

@endsection
@section('scripts')

<script src="{{ asset('js/admin/panelControl/vistaLogin.js') }}"></script>
<script>
var rutaBase ="{{route('VistaLogin.store')}}"
</script>
@endsection