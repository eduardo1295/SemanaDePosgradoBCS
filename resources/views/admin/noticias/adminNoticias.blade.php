@extends('admin.plantilla')
@section('contenido')


<div class="container-fluid" id="#contenedor">

    <div class="row">
            <div class="col-12 d-flex d-md-block justify-content-center justify-content-md-start">
            <h1>
                Noticias
            </h1>
        </div>
    </div>
    <div class="row mb-2">
    <div class="col-12 col-md-12 col-lg-12 d-flex d-md-block justify-content-center justify-content-md-start">
            <div class="d-flex justify-content-end">
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="crear-noticia"><span><i
                            class="fas fa-plus"></i></span> Nueva Noticia</a>

            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="display" cellspacing="0" style="width:100%" id="noticias">
                <thead>
                    <tr>
                        <th>id_noticia</th>
                        <th class="all">Título</th>
                        <th>Resumen</th>
                        <th>Última actualización</th>
                        <th class="all">Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>

@endsection
@section('extra')
@include('admin.noticias.modal')
@endsection
@section('scripts')

<script src="{{ asset('js/imagenes/vistaprevia.js') }}"></script>
<script src="{{ asset('plugins/summernote/summernote-bs4.js') }}"></script>
<script src="{{ asset('plugins/summernote/lang/summernote-es-ES.js') }}"></script>
<script src="{{ asset('plugins/summernote/plugin/cleaner/summernote-cleaner.js') }}"></script>
<script src="{{ asset('plugins/summernote/iniciarSummernote.js') }}"></script>

<script>
var rutaBaseNoticia = "{{route('noticias.index')}}";
var rutalistNoticia = "{{route('noticia.listNoticias')}}";
var rutaVistaPrevia = "{{route('noticia.vistaPrevia')}}";
</script>
<script src="{{ asset('js/admin/panelControl/noticia.js') }}"></script>



@endsection

@section('estilos')

<link rel="stylesheet" href="{{ asset('/plugins/summernote/summernote-bs4.css')}} ">
@endsection