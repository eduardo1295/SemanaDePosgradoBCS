<section class="footer">
    <div class="container-fluid pl-5 pr-5">
        <div class="row footer-block ml-0 mr-0">
            <div class="col-12 mb-3">
                <p><h2 class="text-center" id="Titulo">Contactos</h2></p>
            </div>
            @foreach ($instituciones as $institucion)
                
            
            <div class="col-12 col-lg-6 mb-3 mb-md-2">
                <div class="row">
                    <div class="col-12 col-md-3">
                            <img src="{{url('img/logo')}}/{{ $institucion->url_logo }}" alt="" class="img-fluid d-block d-md-inline mx-auto">
                        </div>
                        <div class="col-12 col-sm-9 ml-auto mx-sm-auto">
                            <div class="row">
                                <div class="col-1 pl-0 pr-0 d-flex justify-content-end align-self-center"> <i class="fa  fa-phone"></i> </div>
                            <div class="col-11 pr-0"> <span>Tel&eacute;fono:</span> {{$institucion->telefono}}</div>

                                <div class="col-1 pl-0 pr-0 d-flex justify-content-end align-self-center"> <i class="fa  fa-envelope"> </i> </div>
                                <div class="col-11 pr-0"> <span>Email: </span><a href="mailto:lfcota@itlp.edu.mx">Pendiente</a></div>

                                <div class="col-1 pl-0 pr-0 d-flex justify-content-end align-self-center"> <i class="fas fa-globe"></i> </div>
                                <div class="col-11 pr-0"> <span>Direcci&oacute;n Web: </span><a href="{{$institucion->direccion_web}}">{{$institucion->direccion_web}}</a></div>

                                <div class="col-1 pl-0 pr-0 d-flex justify-content-end align-self-center"> <i class="far fa-address-card"></i> </div>
                                <div class="col-11 pr-0"> </i><span>Coordinador: </span>Pendiente</div>
                            </div>
                    </div>
                </div>
                
            </div>
            @endforeach



            {{-- comment 
            
            <div class="col-12 col-lg-6 mb-3 mb-md-3">
                <div class="row">
                    <div class="col-12 col-md-3">
                    <img src="/img/aubcs_logo.png" alt="" class="img-fluid d-block d-md-inline mx-auto">
                    </div>
                    <div class="col-12 col-sm-9 mx-auto">
                        <div class="row">
                                <div class="col-1 pl-0 pr-0 d-flex justify-content-end align-self-center">
                                    <i class="fa  fa-phone"></i> 
                                </div> 
                                <div class="col-11 pr-0">
                                    <span>Tel&eacute;fono:</span> (612) 123 8800 <br>  
                                </div>   
                                <div class="col-1 pl-0 pr-0 d-flex justify-content-end align-self-center">
                                    <i class="fa  fa-envelope"> </i> 
                                </div>
                                <div class="col-11 pr-0">
                                     <span>Email: </span><a href="mailto:apoyopos@uabcs.mx">apoyopos@uabcs.mx</a> <br>
                                </div> 
                                <div class="col-1 pl-0 pr-0 d-flex justify-content-end align-self-center"> 
                                    <i class="fas fa-globe"></i> 
                                </div>
                                <div class="col-11 pr-0"> <span>Direcci&oacute;n Web: </span><a href="http://www.uabcs.mx/inicio">UABCS</a></div>  
                                <div class="col-1 pl-0 pr-0 d-flex justify-content-end align-self-center">
                                    <i class="far fa-address-card"></i> 
                                </div>
                                <div class="col-11 pr-0">
                                <span>Coordinador: </span>Dr. Ricardo B&oacute;rquez Reyes
                               </div>
                        </div>    
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 mb-3 mb-md-5">
                <div class="row">
                    <div class="col-12 col-md-3">
                    <img src="/img/cicimar_logo.png" alt="" class="img-fluid d-block d-md-inline mx-auto">
                    </div>
                    <div class="col-12 col-sm-9 mx-auto">
                            <div class="row">
                                    <div class="col-1 pl-0 pr-0 d-flex justify-content-end align-self-center">
                                        <i class="fa  fa-phone"></i> 
                                    </div> 
                                    <div class="col-11 pr-0">
                                            <span>Tel&eacute;fono:</span> (52+612)123 4658, 123 4734 y 123 4666 
                                    </div>   
                                    <div class="col-1 pl-0 pr-0 d-flex justify-content-end align-self-center">
                                        <i class="fa  fa-envelope"> </i> 
                                    </div>
                                    <div class="col-11 pr-0">
                                        <span>Email: </span><a href="mailto:silopez@ipn.mx">silopez@ipn.mx</a> 
                                    </div> 
                                    <div class="col-1 pl-0 pr-0 d-flex justify-content-end align-self-center"> 
                                        <i class="fas fa-globe"></i> 
                                    </div>
                                    <div class="col-11 pr-0">
                                            <span>Direcci&oacute;n Web: </span><a href="http://www.cicimar.ipn.mx/Paginas/Inicio.aspx">CICIMAR-IPN</a> 
                                    </div>  
                                    <div class="col-1 pl-0 pr-0 d-flex justify-content-end align-self-center">
                                        <i class="far fa-address-card"></i> 
                                    </div>
                                    <div class="col-11 pr-0">
                                        <span>Coordinador: </span>Dr. Silverio L&oacute;pez L&oacute;pez <br>
                                   </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 mb-3 mb-md-5">
                <div class="row">
                    <div class="col-12 col-md-3">
                    <img src="/img/cibnor_logo.png" alt="" class="img-fluid d-block d-md-inline mx-auto">
                    </div>
                    <div class="col-12 col-sm-9 mx-auto">
                        <div class="row">
                                <div class="col-1 pl-0 pr-0 d-flex justify-content-end align-self-center">
                                    <i class="fa  fa-phone"></i> 
                                </div> 
                                <div class="col-11 pr-0">
                                        <span>Tel&eacute;fono:</span> (000) 000 0000 
                                </div>   
                                <div class="col-1 pl-0 pr-0 d-flex justify-content-end align-self-center">
                                    <i class="fa  fa-envelope"> </i> 
                                </div>
                                <div class="col-11 pr-0">
                                        Email: <a href="mailto:nhernan04@cibnor.mx">nhernan04@cibnor.mx</a> 
                                </div> 
                                <div class="col-1 pl-0 pr-0 d-flex justify-content-end align-self-center"> 
                                    <i class="fas fa-globe"></i> 
                                </div>
                                <div class="col-11 pr-0">
                                        <span>Direcci&oacute;n Web: </span><a href="https://www.cibnor.gob.mx">CIBNOR</a> 
                                </div>  
                                <div class="col-1 pl-0 pr-0 d-flex justify-content-end align-self-center">
                                    <i class="far fa-address-card"></i> 
                                </div>
                                <div class="col-11 pr-0">
                                    Coordinador: Dra. Norma Y. Hern&aacute;ndez Saavedra <br>
                               </div>
                        </div>
                    </div>
                </div>
            </div>
            --}}
        </div>
    </div>
</section>

<section class="endfooter">
    <div class="container-fluid">
        <div class="text-center pb-3 pt-3">
            Copyright © 2019 Todos los derechos reservados.
        </div>
    </div>
</section>