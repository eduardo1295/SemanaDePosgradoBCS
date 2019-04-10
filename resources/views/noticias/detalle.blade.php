@extends('layoutsM1.principal')
@section('links')
    <link rel="stylesheet" href="{{ mix('css/Maqueta2.css')}} ">
    <link rel="stylesheet" href="/.css"> 
@endsection
@section('menu')
    @include('layoutsM2.navbar')
@endsection
@section('footer')
    @include('layoutsM2.footer')
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
    <div class="row mb-5 border pb-3" id="contenido">
        <div class="col-12 break-word pb-3 pt-3">
            {!! $noticia->contenido !!}
        </div>
            <div class="col-2 offset-5" id="subcontenido">
                @if ($noticia->url_imagen!='sin imagen')
                <img src="{{url('img/noticias')}}/{{ $noticia->url_imagen }}" alt="" class="img-fluid">
                @endif
                
            </div>
    </div>
</div>

        
@endsection

        