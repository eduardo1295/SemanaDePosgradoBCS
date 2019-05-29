<section id="navbarM2">
    <div class="header">
        <div class="container-fluid pl-2 pr-0 pl-sm-2 pr-sm-0 pl-md-4 pr-md-4 pl-lg-5 pr-lg-5  ">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-3 d-flex justify-content-center">
                    @isset($semana->url_logo)
                        <a href="/"><img src="{{url('img/semanaLogo')}}/{{ $semana->url_logo }}" width="120px"  alt=""></a>    
                    @endisset
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-9 d-flex justify-content-end align-items-end">
                    <div class="navigation" style="width:100%">
                        <div id="navigation" style="float:right">
                            <ul>
                                <li class="active"><a href="/">Incio</a></li>
                                <li><a href="{{route('semana.verModalidades')}}" class="">Modalidades</a> </li>
                                <li class="has-sub"> <div class="aliga">Programa <i class="fas fa-angle-down d-none d-xl-inline-block "></i></div> 
                                    <ul>
                                        <li><a href="blog-default.html">General</a></li>
                                        <li><a href="blog-single.html">Póster</a></li>
                                        <li><a href="blog-single.html">Entrevista</a></li>
                                        <li><a href="blog-single.html">Video</a></li>
                                    </ul>
                                </li>
                                <li><a href="{{route('semana.verConvocatoria')}}" class="">Convocatoria</a> </li>
                                
                                
                                @if(auth('admin')->user() || auth()->user())
                                    {{-- comment 
                                    @if(auth()->user()->hasRoles(['alumno']))
                                        <li><a href="/login" title="Styleguide">Entro</a> </li>
                                    @endif
                                    --}}
                                    @php
                                      $ruta = auth('admin')->user() ? 'admin.logout' : 'logout';                                      
                                    @endphp
                                    
                                    <li><a href="/logout" title="Styleguide">Cerrar sesión {{auth()->user()->nombre}}</a> </li>
                                    --}}
                                    <li class="has-sub"> <div class="aliga">{{auth()->user()->nombre}}</div> 
                                        <ul>
                                            <li><a href="{{route('semana.subirTrabajo')}}" class="loginUsuario" >Subir Trabajo</a></li>
                                            <li><a class="loginUsuario" onclick="event.preventDefault();document.getElementById('logout-form').submit();" href="{{route($ruta)}}">Cerrar sesión {{Auth::guard('admin')->user() ? Auth::guard('admin')->user()->nombre : auth()->user()->nombre}}</a> </li>
                                        </ul>
                                    </li>
                                    
                                    <li><a onclick="event.preventDefault();document.getElementById('logout-form').submit();" href="{{route($ruta)}}">Cerrar sesión {{Auth::guard('admin')->user() ? Auth::guard('admin')->user()->nombre : auth()->user()->nombre}}</a> </li>
                                    
                                    <form id="logout-form" action="{{route($ruta)}}" method="POST" style="display: none;">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    </form>
                                @else
                                <li><a href="/login">Acceso</a> </li>
                                @endif
                                {{-- comment 
                                
                                @if (!Auth('admin')->check() && !Auth::check())
                                    <li><a href="/login" title="Styleguide">Acceso</a> </li>
                                @endif
                                
                                <li><a href="styleguide.html" title="Styleguide">Soporte</a> </li>

                                @if (Auth('admin')->check() || Auth::check())
                                    <li><a href="/logout" title="Styleguide">Cerrar sesión</a> </li>
                                @endif
                                --}}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  </div>
</section>
<div id="espacioBlanco">
