{{-- SECCION BLADE--}}
@extends('Plantilla.principal')

@section('menu')
         @include('layoutsM3.navbar')
@endsection

@section('footer')
        @include('layoutsM3.footer')
@endsection

@section('contenido')
    @section('links')
        <link rel="stylesheet" href="/css/Maqueta3.css"> 
        <script  src="/js/owl.carousel.min.js"> </script> 
    @endsection
    <div class="container pl-0 pr-0 ">
        <div class="row ml-0 mr-0">
            <div class="col-12 col-sm-12 col-md-12 col-lg-7 col-xl-8 pl-0 pr-0 ">
                @include('layoutsM2.carrusel')
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-5 col-xl-4 pt-2 pb-2 pt-lg-0 pb-lg-0">
                @include('layoutsM3.noticias')        
            </div>
        </div>
    </div>
    
    

    <div class="container">
        <div class="row ">
            <div class="col-12 col-sm-12 col-md-12 ">
                    @include('layoutsM2.informacion')
            </div>
            <div class="col-12 col-sm-12 col-md-12">
                @include('layoutsM3.sede')
            </div>
        </div>
    </div>    

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
    <div class="container">
            @include('layoutsM3.modalidades')
    </div>
    
    
    @section('scripts')
        <script src="{{ mix('js/Maqueta3.js')}}"></script>
    @endsection


@endsection
