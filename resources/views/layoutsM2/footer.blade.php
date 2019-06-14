<section class="footer">
    <div class="container-fluid pl-1 pr-1 pl-md-5 pr-md-5">
        <div class="row footer-block ml-0 mr-0">
            <div class="col-12 mb-3">
                <p><h2 class="text-center" id="Titulo">Contactos</h2></p>
            </div>
            @foreach ($instituciones as $institucion)
            <div class="col-12 col-lg-6 mb-3 mb-md-2">
                <div class="row">
                    <div class="col-12 col-md-3">
                            <img src="{{url('img/logo')}}/{{ $institucion->url_logo }}" alt="" class="d-block d-md-inline mx-auto img-footer-logo">
                        </div>
                        <div class="col-12 col-sm-9 ml-auto mx-sm-auto">
                            <div class="row">
                                <div class="col-1 pl-0 pr-0 d-flex justify-content-end align-self-center"> <i class="fa  fa-phone"></i> </div>
                            <div class="col-11 pr-0"> <span>Tel&eacute;fono:</span> {{$institucion->telefono}}</div>
                                <div class="col-1 pl-0 pr-0 d-flex justify-content-end align-self-center"> <i class="fa  fa-envelope"> </i> </div>
                                <div class="col-11 pr-0"> <span>Email: </span><a href="mailto:{{ $institucion->email }}">{{ $institucion->email }}</a></div>
                                <div class="col-1 pl-0 pr-0 d-flex justify-content-end align-self-center"> <i class="fas fa-globe"></i> </div>
                                <div class="col-11 pr-0 text-left"> <span>Direcci&oacute;n Web: </span><a href="{{$institucion->direccion_web}}">{{$institucion->siglas}}</a></div>
                                <div class="col-1 pl-0 pr-0 d-flex justify-content-end align-self-center"> <i class="far fa-address-card"></i> </div>
                                <div class="col-11 pr-0"> </i><span>Coordinador: </span>{{ $institucion->coordinador_nombre }}</div>
                            </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<section class="endfooter">
    <div class="container-fluid">
        <div class="text-center pb-3 pt-3">
            Copyright © {{date("Y")}} {{__('All rights reserved.')}}
        </div>
    </div>
</section>