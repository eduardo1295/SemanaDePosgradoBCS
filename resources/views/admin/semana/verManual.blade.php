{{-- SECCION BLADE--}}
@extends('Plantilla.principal')

@section('links')
<link rel="stylesheet" href="{{ asset('/css/Maqueta2.css')}} ">

<style>
    .holo {
        border-left: 10px solid white;
    }
</style>
@endsection

@section('contenido')
        <div class="container">
        <!--<div class="container-fluid pl-1 pr-1 pl-md-5 pr-md-5">-->
            <div class="row">
                <div class="col-12">
                    <h1 id="Titulo" class="display-5 font-weight-bold rounded p-auto pt-3 pb-0">Manual de usuario</h1> <br>
                </div>
            </div>
            <embed class="embed-responsive-item embed-responsive-1by1 pb-5" src="{{ URL::to('/') }}/storage/pdf/manual/manual.pdf/?{{date('H:i:s')}}"
                type="application/pdf" style="width:100%;height: 100vh;" internalinstanceid="9">
        </div>
@endsection
