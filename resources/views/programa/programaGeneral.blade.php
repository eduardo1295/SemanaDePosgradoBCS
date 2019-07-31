{{-- SECCION BLADE--}}
@extends('Plantilla.principal')

@section('links')
<link rel="stylesheet" href="{{ asset('/css/Maqueta2.css')}}">

<style>
    .holo {
        border-left: 10px solid white;
    }
</style>
@endsection

@section('contenido')
    @php
    $nombre_fichero = public_path().'/storage/documentos/programaGeneral/ProgramaGeneral.pdf';
    @endphp
    @if(file_exists($nombre_fichero)) 
        <div class="container">
        <!--<div class="container-fluid pl-1 pr-1 pl-md-5 pr-md-5">-->
            <div class="row">
                <div class="col-12">
                    <h1 id="Titulo" class="display-5 font-weight-bold rounded p-auto pt-3 pb-0">Programa general</h1> <br>
                </div>
            </div>
            <embed class="embed-responsive-item embed-responsive-1by1 pb-5" src="{{ asset('/storage/documentos/programaGeneral/ProgramaGeneral.pdf/?'.date('H:i:s')) }}"
                type="application/pdf" style="width:100%;height: 100vh;" internalinstanceid="9">
        </div>
    @else 
        <div class="container" style="height:100vh">
            <h1>Programa general no disponible</h1>
        </div>
    @endif
@endsection
