
<section id="navbarM2">
    <div class="header">
        <div class="container-fluid pl-5 pr-5">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                    <a href="/"><img src="{{url('img/semanaLogo')}}/{{ $semana->url_logo }}" width="120px"  alt=""></a>
                </div>
                <div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 d-md-flex justify-content-md-end">
                    <div class="navigation float-none">
                        <div id="navigation">
                            <ul>
                                <li class="active"><a href="/">Incio</a></li>
                                <li><a href="contact.html" class="">Modalidades</a> </li>
                                <li class="has-sub"> <div class="aliga">Programa </div> 
                                    <ul>
                                        <li><a href="blog-default.html">General</a></li>
                                        <li><a href="blog-single.html">Póster</a></li>
                                        <li><a href="blog-single.html">Entrevista</a></li>
                                        <li><a href="blog-single.html">Video</a></li>
                                    </ul>
                                </li>
                                <li><a href="{{route('semana.verConvocatoria')}}" class="">Convocatoria</a> </li>
                                
                                @if(Auth::guard()->check())
                                    {{-- comment 
                                    @if(auth()->user()->hasRoles(['alumno']))
                                        <li><a href="/login" title="Styleguide">Entro</a> </li>
                                    @endif
                                    --}}
                                    <li><a href="/logout" title="Styleguide">Cerrar sesión {{auth()->user()->nombre}}</a> </li>
                                    
                                @elseif(Auth::guard('admin')->check())
                                    <li><a href="/logout" title="Styleguide">Cerrar sesión {{auth('admin')->user()->nombre}}</a> </li>
                                    
                                @else
                                <li><a href="/login" title="Styleguide">Acceso</a> </li>
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
