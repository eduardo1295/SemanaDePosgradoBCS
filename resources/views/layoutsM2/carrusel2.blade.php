<section id="intitucionesCa">
    <div id="carrusel" class="container-fluid border">
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
                <div class="row">
                  <div class="col-12 col-sm-3 d-flex">
                    <img src="{{url('img/logo')}}/{{ $institucion->url_logo }}" class="mx-auto img-fluid align-self-center" alt="">
                  </div>
                  <div class="col-12 col-sm-9">
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
                            <div class="col-11 pl-0">
                                    <span>Direcci&oacute;n Web: </span><a href="{{$institucion->direccion_web}}">{{$institucion->direccion_web}}</a> 
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

    function myFunction(x) {
      if (x.matches) { document.body.style.backgroundColor = "yellow"; } 
      else{
        console.log('nada');
      }
    }
    var extra_small = window.matchMedia("(max-width: 100px and max-width: 200px)");
    myFunction(extra_small) 
    extra_small.addListener(myFunction) 

    function myFunction2(x) {
      if (x.matches) { document.body.style.backgroundColor = "red"; } 
    }
    var small = window.matchMedia("(max-width: 300px and max-width: 400px)");
    myFunction2(small) 
    small.addListener(myFunction2) 

        
        
        

        
    </script>
</section>
