@extends('Plantilla.principal')
@section('links')
    <link rel="stylesheet" href="/css/Maqueta2.css ">
    <link rel="stylesheet" href="/css/imagenes/imagenes.css">
@endsection
@section('scripts')
        <script src="/js/menumaker.js"></script>
@endsection

@section('contenido')
<div class="container" style=" word-wrap: break-word;">
    <div class="row">
        <div class="col-12">
            <h1>{{ $noticia->titulo }}</h1>
        </div>
    </div>
    <div class="row mb-5 pb-3" id="">
        <div class="col-12 break-word pb-3 pt-3">
            {!! $noticia->contenido !!}
        </div>
    </div>
</div>

        
@endsection

        