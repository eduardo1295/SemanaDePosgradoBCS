@extends('admin.plantilla')
@section('contenido')


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
            <button class="btn btn-primary" id="btn-guardar" type="button">Guardar</button>
        </div>
        <div class="form-row col-12">
            <div class="form-group col-md-6 ">
                <p id="imagenslider"> Imagen actual:</p>
                <div class="custom-file">
                    <input type="file" name="imagenUsuario" class="custom-file-input" id="imagenUsuario" lang="es"
                        onchange="readURL(this,'vistaPrevia');mostrar('nuevaImagen');">
                    <label for="imagen" class="custom-file-label">Seleccionar Archivo</label>
                </div>
                <small><span class="mensajeError text-danger" id="imagenUsuario_error"></span></small>
                <div class="row">
                    <div id="imagenAnterior" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <label for="imgslide" id="imagenactualT" class="control-label"></label>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <img src="/img/fondo/{{$vistas[0]->url_imagen}}" alt="" id="imgslide"
                                class="img-fluid mx-auto">
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
                <h3>Imagen de fondo login usuario</h3>
                <button class="btn btn-primary" id="btn-guardar" type="button">Guardar</button>
            </div>
            <div class="form-row col-12">
                <div class="form-group col-md-6 ">
                    <p id="imagenslider"> Imagen actual:</p>
                    <div class="custom-file">
                        <input type="file" name="imagenAdmin" class="custom-file-input" id="imagenAdmin" lang="es"
                            onchange="readURL(this,'vistaPrevia2');mostrar('nuevaImagen2');">
                        <label for="imagen" class="custom-file-label">Seleccionar Archivo</label>
                    </div>
                    <small><span class="mensajeError text-danger" id="imagenAdmin_error"></span></small>
                    <div class="row">
                        <div id="imagenAnterior" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <label for="imgslide" id="imagenactualT" class="control-label"></label>
    
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <img src="/img/fondo/{{$vistas[0]->url_imagen}}" alt="" id="imgslide"
                                    class="img-fluid mx-auto">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6 d-flex align-items-end">
                    <div id="nuevaImagen2" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none">
                        <label for="imgni" id="textVP" class="control-label">Nueva imagen</label>
    
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <img src="" alt="" id="vistaPrevia2" class="img-fluid mx-auto" style="height:250px">
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </form>
    

</div>

@endsection
@section('scripts')
<script>
    
    $(document).ready(function () {
        $('.custom-file-input').on('change', function () {
            let fileName = $(this).val().split('\\').pop();
            if (!fileName.trim()) {
                $(this).next('.custom-file-label').removeClass("selected").html('Ningún archivo seleccionado');
                readURL(this,'vistaPrevia1')
            } else {
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            }
        });

        $('#btn-guardar').click(function () {
            var datos = new FormData($("#VistaForm")[0]);
            console.log(Array.from(datos));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: datos,
                //url: "{{route('VistaLogin.store')}}",
                url: "/VistaLogin",
                type: "POST",
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    var unique = $.now();
                    $("#snackbar").html("<span style='color:#32CD32;'><i class='far fa-check-circle'></i></span> imagen registrada exitosamente.");
                    $("#snackbar").addClass("show");
                    setTimeout(function () { $("#snackbar").removeClass("show"); }, 5000);
                    $('#nuevaImagen').addClass('d-none');
                    $('#vistaPrevia').prop('src', "");
                    if(data.nombre != 'sin imagen')
                        $('#imgslide').prop('src', "/img/fondo/" + data.nombre+'/?'+unique);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);

                },


            });
        })
    });
    function readURL(input, idimg) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#' + idimg)
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
        else{
            $('#' + idimg)
                    .attr('src', '');
        }
    }

    function mostrar(idMostrar) {
        $('#' + idMostrar).removeClass('d-none');
    }
</script>
@endsection