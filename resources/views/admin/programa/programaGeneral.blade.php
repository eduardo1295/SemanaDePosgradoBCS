@extends('admin.plantilla')
@section('contenido')


<div class="container-fluid" id="#contenedor">
    <div class="row">
        <div class="col-12 mx-auto">
            <h1>
                Programa General 
            </h1>
        </div>

        <div id="mensaje-acciones" class="col-12 alert alert-success alert-dismissible" role="alert"
            style="display:none">
            <strong> </strong>
        </div>
    </div>
    <form id="programaGeneralForm" name="programaGeneralForm" class="form-horizontal" enctype="multipart/form-data">
        <div class="row">
                <div class="form-group col-md-12">
                    <strong><label id="ligaConvo">Subir programa general</label></strong>
                    @if(file_exists(public_path().'\documentos\programaGeneral\ProgramaGeneral.pdf')) 
                    <a target="_blank" href='{{ URL::to("/") }}/documentos/programaGeneral/ProgramaGeneral.pdf'> Programa actual </a>
                    @endif
                    <div class="custom-file">
                        <input type="file" name="programaGeneral" class="custom-file-input" id="programaGeneral"
                            lang="es" accept="application/pdf">
                        <label for="convocan" class="custom-file-label">Seleccionar Archivo</label>
                    </div>
                    <small><span class="mensajeError text-danger" id="convocatoria_error"></span></small>
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <input type="button" value="Guardar" id="guardar" class="btn btn-primary">
                </div>
        </div>
    </form>
    <div id="snackbar"></div>
</div>


@endsection
@section('extra')

@endsection
@section('scripts')

<script src="{{ asset('js/programa/subirProgramaGeneral.js') }}"></script>
<script>
    $('.custom-file-input').on('change', function () {
        let fileName = $(this).val().split('\\').pop();
        if (!fileName.trim()) {
            $(this).next('.custom-file-label').removeClass("selected").html('Ningún archivo seleccionado');
        } else {
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        }
    });
</script>

@endsection

@section('estilos')
<link href="{{ asset('/css/modales/modalimagen.css')}}" rel="stylesheet">
@endsection