<section id="intitucionesCa">
    <div id="" class="container-fluid border">
        <div id="carruselinst" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner" role="listbox">
            @php
            $x = 0 
               
            @endphp
            @foreach ($instituciones as $institucion)
            @if ($x==0)
            <div class="carousel-item active">
            @php
                $x++;
            @endphp
            @else
            <div class="carousel-item">
            @endif
              <div class="carousel-caption d-block text-justify">
                <div class="row d-flex justify-content-center">
                  <div class="col-12 col-sm-3 d-flex">
                    <img src="{{url('img/logo')}}/{{ $institucion->url_logo }}" class="mx-auto img-fluid align-self-center img-carrusel-logo" alt="">
                  </div>
                  <div class="col-10  col-sm-9">
                      <h4>{{$institucion->nombre}} </h4> <br>
                      <div class="row">
                            
                            <div class="col-1 pl-0  d-flex justify-content-end align-items-center">
                                <i class="fa  fa-map-marker"></i> 
                            </div> 
                            <div class="col-11 pl-0 text-left">
                                    <span>Ubicaci&oacute;n </span>{{$institucion->domicilio}}
                            </div>
                            <div class="col-1 pl-0  d-flex justify-content-end align-items-center">
                                <i class="fa fa-phone"></i> 
                            </div> 
                            <div class="col-11 pl-0">
                                    <span>Tel&eacute;fono:</span> {{$institucion->telefono}} 
                            </div>
                            <div class="col-1 pl-0  d-flex justify-content-end align-items-center">
                                <i class="fa  fa-envelope"> </i> 
                            </div>
                            <div class="col-11 pl-0">
                                    <span>Email: </span><a href="mailto:lfcota@itlp.edu.mx">pendiente</a> 
                            </div> 
                            <div class="col-1 pl-0  d-flex justify-content-end align-items-center"> 
                                <i class="fas fa-globe"></i> 
                            </div>
                            <div class="col-11 pl-0 text-left">
                                    <span>Direcci&oacute;n Web: </span><a href="{{$institucion->direccion_web}}" > {{$institucion->direccion_web}}</a> 
                            </div>  
                            <div class="col-1 pl-0  d-flex justify-content-end align-items-center">
                                <i class="far fa-address-card"></i> 
                            </div>
                            <div class="col-11 pl-0">
                                <span>Coordinador: </span>pendiente 
                           </div>
                            <div class="col-1 pl-0  d-flex justify-content-end align-items-center">
                                <i class="fas fa-location-arrow"></i>
                            </div>
                            <div class="col-11 pl-0">
                                  <button type="button" class=" cola btn btn-outline-primary" style="border:none"  onclick="mostrarMapa({{$institucion->latitud}},{{$institucion->longitud}})">
                                    Mostrar ubicación
                                  </button>
                            </div>
                        </div>
                  </div>
                </div>
              </div>
            </div>
            @endforeach

            <section id="modales">
              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-label="modalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h4 class="modal-title" id="modalLabel">
                                  Ubicación sede
                              </h4>
                              <button type="button" class="close modalP" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                              <div class="row mt-2 justify-content-center">
                                  <div class="embed-responsive embed-responsive-16by9 mt-3">
                                      <iframe id="mapa12"
                                          src=""
                                          frameborder="0" style="border:0" allowfullscreen>
                                      </iframe>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
          </section>




            
          </div>
          <a class="carousel-control-prev" href="#carruselinst" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
          <a class="carousel-control-next" href="#carruselinst" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
        </div>
      </div>

    <script>
    var mostrarMapa = function (latitud, longitud){
      console.log(latitud);
      $('#mapa12').prop('src','http://maps.google.com/maps?q='+latitud +','+ longitud+'&z=15&output=embed');
      $('#exampleModal').modal('show');
    }
    $('.modalP').click(function (){
        $('#mapa12').prop('src',' ');
    });
/*
    function myFunction(x) {
      if (x.matches) {  
        console.log($('.carousel-item'));
        
        //var datos2 =  $('.carousel-item').height();
        
        console.log(datos+','+datos2);
        } 
      else{  }
    }
    function myFunction2(x) {
      if (x.matches) { console.log("si2"); }
      else{  }
    }
    function myFunction3(x) {
      if (x.matches) { console.log("si3"); }
      else{  }
    }
    function myFunction4(x) {
      if (x.matches) { console.log("si4"); }
      else{  }
    }
    function myFunction5(x) {
      if (x.matches) { console.log("si5"); }
      else{  }
    }

    var extra_small = window.matchMedia("(min-width: 0) and (max-width: 576px)");
    var small = window.matchMedia("(min-width: 577px) and (max-width: 767px)");
    var medium = window.matchMedia("(min-width: 767px) and (max-width: 992px)");
    var large = window.matchMedia("(min-width: 992px) and (max-width: 1200px)");
    var extra_large= window.matchMedia("(min-width: 1200px)");

    myFunction(extra_small); 
    myFunction(small); 
    myFunction(medium); 
    myFunction(large); 
    myFunction(extra_large); 

    extra_small.addListener(myFunction);
    small.addListener(myFunction2);
    medium.addListener(myFunction3);
    large.addListener(myFunction4);
    extra_large.addListener(myFunction5);
    */
    </script>
</section>
