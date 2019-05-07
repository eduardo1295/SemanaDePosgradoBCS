
<section id="navbarM2">
    <div class="header">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                    <a href="/"><img src="/img/logo.png" width="120px"  alt="Hair Salon Website Templates Free Download"></a>
                </div>
                <div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 d-md-flex justify-content-md-end">
                    <div class="navigation float-none">
                        <div id="navigation">
                            <ul>
                                <li class="active"><a href="/" title="Home">Incio</a></li>
                                <li><a href="contact.html" class="" title="Contact Us">Modalidades</a> </li>
                                <li class="has-sub"><a href="blog-default.html" title="Blog ">Programa</a>
                                    <ul>
                                        <li><a href="blog-default.html" title="Blog">General</a></li>
                                        <li><a href="blog-single.html" title="Blog Single ">Póster</a></li>
                                        <li><a href="blog-single.html" title="Blog Single ">Entrevista</a></li>
                                        <li><a href="blog-single.html" title="Blog Single ">Video</a></li>
                                    </ul>
                                </li>
                                <li><a href="contact.html" class="" title="Contact Us">Convocatoria</a> </li>
                                
                                @if(Auth::guard()->check())
                                    @if(auth()->user()->hasRoles(['alumno']))
                                        <li><a href="/login" title="Styleguide">Entro</a> </li>
                                    @endif

                                    <li><a href="/login" title="Styleguide">hola 1</a> </li>

                                @elseif(Auth::guard('admin')->check())
                                    <li><a href="/logout" title="Styleguide">hola 2</a> </li>
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
