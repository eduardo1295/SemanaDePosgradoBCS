{{-- SECCION BLADE--}}
@extends('layoutsM1.principal')

@section('contenido')
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


@if ($semana->url_convocatoria=='no_disponible')
    <div class="container-fluid pl-1 pr-1 pl-md-5 pr-md-5" style="height:100vh">
        <h1>Convocatoria no no disponible</h1>
    </div> 
@else
    <div class="container-fluid pl-1 pr-1 pl-md-5 pr-md-5">
        <embed class="embed-responsive-item" src="{{ URL::to('/') }}/pdf/convocatoria/{{$semana->url_convocatoria}}"
            type="application/pdf" style="width:100%;height: 100vh;" internalinstanceid="9">
    </div> 
@endif


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
@endsection