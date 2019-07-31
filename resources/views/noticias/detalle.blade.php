@extends('Plantilla.principal')
@section('links')
    <link rel="stylesheet" href="{{ asset('/css/Maqueta2.css')}}">
    
    <link rel="stylesheet" href="{{ asset('/css/imagenes/imagenes.css')}}">
@endsection

@section('contenido')
<div class="container" style=" word-wrap: break-word;">
    <div class="row">
        <div class="col-12">
            <h1 id="Titulo" class="display-5  font-weight-bold rounded p-auto pt-3">{{ $noticia->titulo }}</h1> <br>
        </div>
    </div>
    <div class="row mb-1 pb-3" id="">
        <div class="col-12 break-word pb-3">
            {!! $noticia->contenido !!}
        </div>
    </div>
</div>

        
@endsection

        