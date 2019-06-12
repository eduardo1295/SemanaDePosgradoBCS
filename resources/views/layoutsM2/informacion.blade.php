<section id="info">
    <div class="contenido h-100">
        <div class="mb-1">
            <div class="row">
                <div class="col-12 contenidoPrincipal" id="contenido">
                    <div class="row">
                        <div class="col-12 pl-0 pr-0 contenidoSubPrincipal">
                            @isset($semana->nombre)
                            <h2 class="pb-1 pt-1 pl-3 ">{{$semana->nombre}}</h2>        
                            @endisset
                        </div>
                        <div class="col-12 contenidoTexto">
                            @isset($semana->desc_general)
                                <div class="pl-1 pr-1 pl-md-5 pr-md-5 media-with-text mt-2 text-justify">
                                    {!!$semana->desc_general!!}
                                </div>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>