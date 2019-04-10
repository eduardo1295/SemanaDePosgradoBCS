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
                <div class="col-12 mt-3">
                    <div class="row">
                        @include('layoutsM2.noticias')
                    </div>
                    
                </div>
            </div>
        </div>
    
    
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
