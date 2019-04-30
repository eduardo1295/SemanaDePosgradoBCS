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

@include('layoutsM2.carrusel')
{{-- comment 
    
    <div class="container mt-4 mb-4">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-8 contenidoPrincipal">
                @include('layoutsM2.informacion')
            </div>
            <div class="col-4">
                @include('layoutsM2.noticias')
            </div>
        </div>
    </div>
    --}}
<div class="container mt-5 mb-4">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 contenidoPrincipal">
            @include('layoutsM2.informacion')
        </div>
    </div>
</div>
<div class="container">
    


    <div class="row">
        {{--Lo que funca--}}
        <div class="col-12  mb-4" id="noticias">
            <div class="row">
                <div class="col-9  d-flex justify-content-between align-items-center " id="titulo1">
                    <h2 class="mb-0 rounded-left">Noticias.</h2>
                    <h4 class="mb-0"> <a href="/noticia" class="badge badge-primary mb-0 align-self-center">Ver todas 
                        <i class="fas fa-arrow-circle-right"></i></a> </h4>
                </div>
                <div class="pl-0 col-3 holo bordeizqarriba bordederarriba" id="titulo2">
                    <h2 class="pl-3 mb-0 rounded-left">Sede</h2>
                </div>
                @php
                $cont=0;
                @endphp
                @foreach ($noticias as $noticia)
                @if ($cont == 0)
                <div class=" nota n1 col-3 mb-lg-0 " id="contenido">
                    @elseif ($cont == 2 )
                    <div class=" nota n3 col-3 mb-lg-0 " id="contenido">
                        @else
                        <div class=" nota n2 col-3 mb-lg-0 " id="contenido">
                            @endif
                            <div class="media-with-text  mt-4">
                                <h2 class="h5 mb-2">
                                    <a href="/noticia/{{$noticia->id_noticia}}"
                                        id="tituloNoticia">{{$noticia->titulo}}</a>
                                </h2>
                                <span class="mb-2 d-block post-date">
                                    {{$noticia->fecha_actualizacion}}
                                </span>
                                <p> {{$noticia->resumen}} </p>
                            </div>
                        </div>
                        @php
                        $cont++;
                        @endphp
                        @endforeach
                        <div class="col-3 n4 mx-auto" id="contenido">
                            <div class="row">
                                <div class="col-12">
                                        <p class="text-center pt-2"> <strong>Institución: </strong> {{$institucionSede->nombre}} </p>
                                        <div class="d-flex">
                                            <img class="img-fluid mx-auto" src="{{url('img/logo')}}/{{ $institucionSede->url_logo }}" alt="" >
                                        </div>
                                        <a class="nav-link active lead text-right" data-toggle="modal" href="#cerrar">
                                        <i class="fas fa-map-marker-alt"></i> Mostrar Ubicacion </a>
                                </div>
                                    
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--
    <div class="container">
        <div class="row" >
            <div class="col-8" id="contenido">
                    @include('layoutsM2.noticias')        
            </div>
            <div class="col-4" id="contenido">
                hola
            </div>
                
        </div>
        
    </div>
    --}}

    {{--
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 ">
                    @include('layoutsM2.informacion')
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-5 pr-0">
                @include('layoutsM2.sede')
            </div>
        </div>
    </div>    
    --}}
    <section id="carruselInstituciones" class="mb-5">
        <div id="fondo">

            <div class="container" id="contenido">
                <div class="row">
                    <h2 id="titulo" class="w-100">Instituciones Participantes</h2>
                </div>
                <div class="row">
                    <div class=" col-12 pb-4 pt-4">
                        @include('layoutsM2.carrusel2')
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="modales">
        <div class="modal fade" id="cerrar" tabindex="-1" role="dialog" aria-label="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalLabel">
                            Ubicación sede
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 justify-content-center">
                            <div class="embed-responsive embed-responsive-16by9 mt-3">
                                <iframe
                                    src="http://maps.google.com/maps?q=+{{$institucionSede->latitud}}+, +{{$institucionSede->longitud}}+&z=15&output=embed"
                                    frameborder="0" style="border:0" allowfullscreen>
                                </iframe>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary lead" data-dismis="modal">Cerrar</button>
                    </div>
                </div>
            </div>
    </section>




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