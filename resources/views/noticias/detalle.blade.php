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
        {{-- comment 
        <div class="col-3 d-flex justify-content-center">
        @if ($noticia->url_imagen!='sin imagen')
                <div class="row">
                    <div class="col-12">
                        <img src="{{url('img/noticias')}}/{{ $noticia->url_imagen }}" alt="" class="img-fluid">
                    </div>
            </div>
        @endif
        </div>    
        --}}
        
        
                
            
    </div>
</div>

        
@endsection

        