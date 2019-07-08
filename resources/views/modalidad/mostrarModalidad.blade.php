{{-- SECCION BLADE--}}
@extends('Plantilla.principal')

@section('links')
<link rel="stylesheet" href="/css/Maqueta2.css ">
<script src="/js/owl.carousel.min.js"> </script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

</script>
<style>
    .holo {
        border-left: 10px solid white;
    }
</style>
@endsection

@section('contenido')
    @if(isset($semana))
        @if (file_exists( public_path(). '\documentos\modalidad\\'.$nombre.'.pdf'))
        <div class="container">
            <!--<div class="container-fluid pl-1 pr-1 pl-md-5 pr-md-5">-->
                <div class="row">
                    <div class="col-12">
                        <h1 id="Titulo" class="display-5 font-weight-bold rounded p-auto pt-3 pb-0">{{ucfirst($nombre)}}</h1> <br>
                    </div>
                </div>
                <embed class="embed-responsive-item embed-responsive-1by1 pb-5" src="{{ URL::to('/') }}/documentos/modalidad/{{$nombre}}.pdf"
                    type="application/pdf" style="width:100%;height: 100vh;" internalinstanceid="9">
            </div>
        
        @else
        <div class="container" style="height:100vh">
            <div class="row">
                <div class="col-12">
                    <h1 id="Titulo" class="display-5 font-weight-bold rounded p-auto pt-3 pb-0">No disponible</h1> <br>
                </div>
            </div>
        </div>
        @endif
    @else
        <div class="container-fluid pl-1 pr-1 pl-md-5 pr-md-5" style="height:100vh">
            <h1>No disponible</h1>
        </div>
    @endif
@endsection

@section('scripts')
    <script src="/js/menumaker.js"></script>
@endsection
