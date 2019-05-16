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

<div class="container-fluid mt-5 mb-4 pl-1 pr-1 pl-md-5 pr-md-5">
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 contenidoPrincipal">
        @include('layoutsM2.informacion')
    </div>
</div>
<div class="container-fluid pl-1 pr-1 pl-md-5 pr-md-5">
        <div class="col-12  mb-4" id="noticias">
            <div class="row">
                <div class="col-12 col-md-9  d-flex justify-content-between align-items-center " id="titulo1">
                    <h2 class="mb-0 rounded-left">Noticias.</h2>
                    <h4 class="mb-0"> <a href="/noticia" class="badge badge-primary mb-0 align-self-center">Ver todas 
                        <i class="fas fa-arrow-circle-right"></i></a> </h4>
                </div>
                <div class="pl-0 col-3 d-none d-md-block holo bordeizqarriba bordederarriba" id="titulo2">
                    <h2 class="pl-3 mb-0 rounded-left">Sede</h2>
                </div>
                @php
                $cont=0;
                @endphp
                @foreach ($noticias as $noticia)
                @if ($cont == 0)
                <div class=" nota n1 col-12 col-md-3 mb-lg-0 " id="contenido">
                    @elseif ($cont == 2 )
                    <div class=" nota n3 col-12 col-md-3 mb-lg-0 " id="contenido">
                        @else
                        <div class=" nota n2 col-12 col-md-3 mb-lg-0 " id="contenido">
                            @endif
                            <div class="media-with-text  mt-4">
                                <h2 class="h5 mb-2">
                                    <a href="/noticia/{{$noticia->id_noticia}}"
                                        id="tituloNoticia">{{$noticia->titulo}}</a>
                                </h2>
                                <small><span class="mb-2 d-block post-date"> {{$noticia->fecha_actualizacion}}</span></small>
                                <p> {{$noticia->resumen}} </p>
                            </div>
                        </div>
                        @php
                        $cont++;
                        @endphp
                        @endforeach
                        <div class="pl-0 mt-3 col-12 d-block d-md-none  bordeizqarriba bordederarriba" id="titulo2">
                                <h2 class="pl-3 mb-0 rounded-left">Sede</h2>
                        </div>
                        <div class="col-12 col-md-3 n4 mx-auto ubicacionSede" id="contenido">
                            <div class="row">
                                <div class="col-12">
                                    @if (isset($institucionSede))
                                        <p class="text-md-center pt-2">{{$institucionSede->nombre}} </p>
                                        <div class="d-flex">
                                            <div class="col-12 d-flex justify-content-center">
                                                    <img id="logoSede" class="mx-auto" src="{{url('img/logo')}}/{{ $institucionSede->url_logo }}" alt="" >
                                            </div>
                                        </div>
                                        <a class="nav-link active lead text-md-right" data-toggle="modal" href="#cerrar">
                                        <i class="fas fa-map-marker-alt"></i> Mostrar Ubicacion </a>
                                    @endif
                                </div>
                                    
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <section id="carruselInstituciones" class="mb-5 pl-1 pr-1 pl-md-5 pr-md-5">
        <div id="fondo">
            <div class="container-fluid" id="contenido">
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

    @if (isset($institucionSede))
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
                    </div>
                </div>
            </div>
    </section>
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