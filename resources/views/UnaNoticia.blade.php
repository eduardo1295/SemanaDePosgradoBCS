@extends('layoutsM1.principal')
@section('links')
    <link rel="stylesheet" href="/css/Maqueta2.css "> 
    
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
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Aqui va el titulo</h1>
            </div>
        </div>
        <div class="row mb-5 border" id="contenido">
            <div class="col-6 offset-3 text-center break-word pb-3 pt-3">Aqui va la parte del Contenido</div>
            <div class="col-2 offset-5" id="subcontenido">
                <img src="/img/logo.png" alt="" class="img-fluid">
            </div>
        </div>
    </div>

    
@endsection

