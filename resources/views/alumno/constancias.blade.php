{{-- SECCION BLADE--}}
@extends('Plantilla.principal')

@section('links')
<link rel="stylesheet" href="{{ asset('/css/Maqueta2.css')}}  ">

@endsection

@section('contenido')

    @if (count($constancias)>0)
    <div class="container">
        <!--<div class="container-fluid pl-1 pr-1 pl-md-5 pr-md-5">-->
            <div class="row">
                <div class="col-12">
                    {!! "<h1 id='Titulo'>Constancia de participación</h1>" !!}
                <ul>
                    @foreach ($constancias as $constancia)
                
                <h2><li><a target="_blank" href="{{route('constancia.generarPDF',$constancia->id_semana)}}">
                {{ $constancia->nombre }}
                </a></li></h2>
        @endforeach 
                </ul>   
                </div>
            </div>
    </div>
        
    @else
    <div class="container">
        <!--<div class="container-fluid pl-1 pr-1 pl-md-5 pr-md-5">-->
            <div class="row">
                <div class="col-12">
                    {!! "<h1 id='Titulo'>No tienes ninguna constancia de participación</h1>" !!}
                </div>
            </div>
    </div>
        
    @endif
    
@endsection

@section('scripts')
    <script src="/js/menumaker.js"></script>
@endsection
