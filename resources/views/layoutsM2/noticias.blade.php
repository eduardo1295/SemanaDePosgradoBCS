<section id="noticias" class="w-100">
    <div class="site-section" id="fondo">
        <div class="container mt-2" id="contenido">
            <div class="row">
                <h2 class="w-100 d-block d-lg-none pl-3 mb-0 rounded" id="titulo">Noticias.</h2>
                <h2 class="w-75 d-none d-lg-block pl-3 mb-0 rounded-left" id="titulo">Noticias.</h2>
                <h2 class="w-25 d-none d-lg-block  pl-3 mb-0 rounded-right" id="titulo">Sede</h2>                          
            </div>
          <div class="row mb-5">
            @php
                $cont=0;
            @endphp
              @foreach ($noticias as $noticia)
              <div class=" nota col mb-lg-0">
                  <div class="media-with-text  mt-4">
                    <h2 class="h5 mb-2"><a href="#">{{$noticia->titulo}}</a></h2>
                    <span class="mb-2 d-block post-date">{{$noticia->fecha_actualizacion}}</span>
                    <p>{{$noticia->resumen}}
                    </p>
                  </div>
                  @if ($cont+1 == 3)
                    <div class="d-flex justify-content-end ">
                      <h4><a href="/noticia" class="badge badge-success">Ver todas.</a></h4>
                    </div>
                  @endif
                  @php
                      $cont++;
                  @endphp
                  
                </div>  
              @endforeach
               
            {{-- comment
            
            <div class="nota col-md-6 col-lg-3 mb-lg-0">
              <div class="media-with-text mt-4">
                <h2 class="h5 mb-2"><a href="#">Lorem ipsum dolor sit amet</a></h2>
                <span class="mb-2 d-block post-date">January 20, 2018 </span>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio dolores culpa qui aliquam placeat nobis...
                </p>
              </div>
            </div>
            <div class="nota col-md-6 col-lg-3 mb-lg-0">
              <div class="media-with-text mb-5 mt-4">
                <h2 class="h5 mb-2"><a href="#">Learn How To Pray</a></h2>
                <span class="mb-2 d-block post-date">January 20, 2018 </span>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio dolores culpa qui aliquam placeat nobis...
                </p>
              </div>
              <div class="d-flex justify-content-end ">
                <h4><a href="/noticias" class="badge badge-success">Ver todas.</a></h4>
              </div>
            </div>
             --}}
            <h2 class="w-100 pl-3 mb-3 d-block d-lg-none rounded" id="titulo">Sede</h2>             
            <div class="col">
              <div class="mt-4 pb-5">
                      <div class="col-12 content-map">
                      <div class="embed-responsive embed-responsive-16by9">
                              <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7281.759518255637!2d-110.3471169338684!3d24.14086048631198!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x86ae2cbee53fa875%3A0xbad08a31e0884b0d!2sCICIMAR!5e0!3m2!1ses-419!2smx!4v1553490975941" frameborder="0" style="border:0" allowfullscreen></iframe>
                      </div>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>

{{-- comment 
<section id="noticias">
    <div class="site-section" id="fondo">
        <div class="container" id="contenido">
            <div class="row">
                <h2 class="w-100 pl-3 mb-0" id="titulo">Noticias.</h2>
            </div>
          <div class="row">
            <div class=" nota col-md-6 col-lg-12  mb-lg-0">
              <div class="media-with-text mt-1">
                <h2 class="h5 mb-2"><a href="#">Lorem ipsum dolor sit amet</a></h2>
                <span class="mb-2 d-block post-date">January 20, 2018</span>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio dolores culpa qui aliquam placeat nobis...
                </p>
              </div>
            </div>
            <div class="nota col-md-6 col-lg-12 mb-lg-0">
              <div class="media-with-text">
                <h2 class="h5"><a href="#">Lorem ipsum dolor sit amet</a></h2>
                <span class="mb-1 d-block post-date">January 20, 2018 </span>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio dolores culpa qui aliquam placeat nobis...
                </p>
              </div>
            </div>
            <div class="nota col-md-6 col-lg-12 mb-lg-0">
              <div class="media-with-text mb-1 mt-1">
                <h2 class="h5 mb-2"><a href="#">Learn How To Pray</a></h2>
                <span class="mb-2 d-block post-date">January 20, 2018 </span>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio dolores culpa qui aliquam placeat nobis...
                </p>
              </div>
            </div>
            <div class="col-md-6 col-lg-12 mb-lg-0 pb-3">
              <div class="mt-1">
                  <div class="col-12">
                      <h3>Sede</h3>
                  </div>
                      <div class="embed-responsive embed-responsive-21by9">
                              <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7281.759518255637!2d-110.3471169338684!3d24.14086048631198!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x86ae2cbee53fa875%3A0xbad08a31e0884b0d!2sCICIMAR!5e0!3m2!1ses-419!2smx!4v1553490975941" frameborder="0" style="border:0" class="pl-5 pr-5"></iframe>
                      </div>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section> 
--}}