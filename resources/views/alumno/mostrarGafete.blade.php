{{-- SECCION BLADE--}}
@extends('Plantilla.principal')

@section('links')
<link rel="stylesheet" href="{{ asset('/css/Maqueta2.css')}}">
<link href="{{ asset('/css/imagenes/cargando.css')}} " rel="stylesheet">

<style>
    .holo {
        border-left: 10px solid white;
    }
</style>
@endsection

@section('contenido')
        @if (isset($institucionActiva) && !$institucionActiva)
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1 class="display-3 alert alert-info mt-3" role="alert" style="text-align:center">La institución a la que perteneces no es participante activo en el evento.</h1>
                    </div>
                </div>
            </div>
        @else
            <div class="container">
            <!--<div class="container-fluid pl-1 pr-1 pl-md-5 pr-md-5">-->
                <div class="row">
                    <div class="col-12">
                        <h1 id="Titulo" class="display-5 font-weight-bold rounded p-auto pt-3 pb-0">Gafete de participación</h1> <br>
                    </div>
                </div>
                <embed class="embed-responsive-item embed-responsive-1by1 pb-5"  src="{{ URL::to('/') }}/storage/gafete.pdf/?{{date('H:i:s')}}" 
                    type="application/pdf" style="width:100%;height: 100vh;" internalinstanceid="9">
            </div>
        @endif
@endsection