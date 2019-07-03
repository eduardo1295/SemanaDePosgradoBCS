@extends('admin.plantilla')
@section('contenido')


<div class="container-fluid" id="#contenedor">
    <div class="row">
        <div class="col-12 mx-auto">
            <h1>
                Programas General 
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
                    <a target="_blank" href='{{ URL::to("/") }}/documentos/programaGeneral/ProgramaGeneral.pdf'> Convocatoria actual </a>
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
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="/js/programa/subirProgramaGeneral.js"></script>
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

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">

<link rel="stylesheet" href="/css/datatable/colores.css">
<link href="/css/modales/modalresponsivo.css" rel="stylesheet">
<link href="/css/modales/snackbar.css" rel="stylesheet">
<link href="/css/modales/modalimagen.css" rel="stylesheet">

<style>
    .custom-file-input~.custom-file-label::after {
        content: "Elegir";
    }
    
</style>

@endsection