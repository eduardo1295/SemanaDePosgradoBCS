{{-- SECCION BLADE--}}


@extends('layoutsM1.principal')

@section('contenido')
    @section('links')
        <link rel="stylesheet" href="{{ mix('css/Maqueta2.css')}} "> 
        <script  src="/js/owl.carousel.min.js"> </script> 
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
            <div class="col-12 hololo mb-4" id="noticias">
                <div class="row">
                    <div class="col-9 hololo d-flex justify-content-between align-items-center bordeizqarriba bordederarriba" id="titulo">
                        <h2 class="pl-3  mb-0 rounded-left">Noticias.</h2>
                        <h4 class="mb-0" > <a href="/noticia" class="badge badge-primary mb-0 align-self-center">Ver todas <i class="fas fa-arrow-circle-right"></i></a> </h4>

                    </div>
                    <div class="col-3 holo bordeizqarriba bordederarriba" id="titulo">
                        <h2 class="pl-3 mb-0 rounded-left">Sede</h2>
                    </div>
                    @php
                    $cont=0;
                    @endphp
                    @foreach ($noticias as $noticia)
                    @if ($cont == 0)
                        <div class=" nota col-3 mb-lg-0 bordeizqabajo" id="contenido">
                    @elseif ($cont == 2 )
                        <div class=" nota col-3 mb-lg-0 bordederabajo hololo" id="contenido">
                    @else
                        <div class=" nota col-3 mb-lg-0 " id="contenido">
                    @endif
                        <div class="media-with-text  mt-4">
                            <h2 class="h5 mb-2">
                                <a href="/noticia/{{$noticia->id_noticia}}" id="tituloNoticia">{{$noticia->titulo}}</a>
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
                    <div class="col-3 holo bordeizqabajo bordederabajo" id="contenido">
                        <div class="embed-responsive embed-responsive-16by9 mt-3">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7281.759518255637!2d-110.3471169338684!3d24.14086048631198!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x86ae2cbee53fa875%3A0xbad08a31e0884b0d!2sCICIMAR!5e0!3m2!1ses-419!2smx!4v1553490975941"
                                frameborder="0" style="border:0" allowfullscreen></iframe>
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
