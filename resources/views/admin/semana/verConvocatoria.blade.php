{{-- SECCION BLADE--}}
@extends('layoutsM1.principal')

@section('links')
<link rel="stylesheet" href="{{ mix('css/Maqueta2.css')}} ">
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
        @if ($semana->url_convocatoria=='no_disponible')
        <div class="container-fluid pl-1 pr-1 pl-md-5 pr-md-5" style="height:100vh">
            <h1>Convocatoria no disponible</h1>
        </div>
        @else
        <div class="container">
        <!--<div class="container-fluid pl-1 pr-1 pl-md-5 pr-md-5">-->
            <div class="row">
                <div class="col-12">
                    <h1 id="Titulo" class="display-5 font-weight-bold rounded p-auto pt-3 pb-0">Convocatoria</h1> <br>
                </div>
            </div>
            <embed class="embed-responsive-item pb-5" src="{{ URL::to('/') }}/pdf/convocatoria/{{$semana->url_convocatoria}}"
                type="application/pdf" style="width:100%;height: 100vh;" internalinstanceid="9">
        </div>
        @endif
    @else
        <div class="container-fluid pl-1 pr-1 pl-md-5 pr-md-5" style="height:100vh">
            <h1>Convocatoria no disponible</h1>
        </div>
    @endif
@endsection

@section('menu')
    @include('layoutsM2.navbar')
@endsection

@section('footer')
    @include('layoutsM2.footer')
@endsection
{{-- END SECCION BLADE--}}

@section('scripts')
    <script src="/js/menumaker.js"></script>
@endsection
