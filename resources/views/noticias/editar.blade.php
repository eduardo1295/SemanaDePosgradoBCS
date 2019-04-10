@extends('admin.plantilla')

@section('contenido')
    <h1>Editar Noticia</h1>
    @if (session()->has('info'))
    <div class="alert alert-success alert-dismissible" role="alert">
            {{session('info')}}
        </div>    
    @endif
    <div class="container mb-5">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
    <form method="POST" action="{{route('noticia.update',$noticia->id_noticia)}}" enctype="multipart/form-data">
        {!! method_field('PUT') !!}
        @include('noticias.form', ['btnText' => 'Actualizar'])
    </form>
</div>
  
</div>
</div>

@endsection


@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.js"></script>


<script src="/js/summer/summernote-text-findnreplace.js"></script>
<script src="/js/summer/summernote-list-styles-bs4.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.summernote').summernote({
            height: 300,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,
        });
        $('.summernote').summernote({
            toolbar: [
                // [groupName, [list of button]]
                // The button
                ['color', ['color']],
                ['style', ['style']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['font', ['bold', 'italic', 'underline', 'clear']],


                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'hr']],
                ['view', ['fullscreen', 'codeview']],
                ['custom', ['findnreplace']],
            ],
            styleTags: ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
        });

        $('.summernote').summernote({
            shortcuts: false
        });

        $('.summernote').summernote({
            disableDragAndDrop: true
        });

        $('.summernote').summernote({
            popover: {
                image: [
                    ['custom', ['imageTitle']],
                    ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                    ['float', ['floatLeft', 'floatRight', 'floatNone']],
                    ['remove', ['removeMedia']]
                ],
            },
            lang: 'en-US', // Change to your chosen language

        });



    });

</script>

@endsection

@section('estilos')
<link href="/css/summer/summernote-list-styles-bs4.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.css" rel="stylesheet">
<style>
    html {
        overflow-y: scroll;
    }
</style>
@endsection