<section id="navbarM2">
    <div class="header">
        <div class="container-fluid pl-2 pr-0 pl-sm-2 pr-sm-0 pl-md-4 pr-md-4 pl-lg-5 pr-lg-5  ">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-3 d-flex justify-content-center">
                    @isset($semana->url_logo)
                        <a href="/"><img src="{{url('img/semanaLogo')}}/{{ $semana->url_logo }}" width="120px" height="65px" alt=""></a>    
                    @endisset
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-9 d-flex justify-content-end align-items-end">
                    <div class="navigation" style="width:100%">
                        <div id="navigation" style="float:right">
                            <ul>
                                <li class="active"><a href="/">Incio</a></li>
                                <li><a href="{{route('modalidad.index')}}" class="">Modalidades</a> </li>
                                <li class="has-sub"> <div class="aliga">Programa <i class="fas fa-angle-down d-none d-xl-inline-block "></i></div> 
                                    <ul>
                                    <li><a href="{{route('programa.mostrarProgramaGeneral')}}">General</a></li>
                                        <li><a href="{{route('modalidad.mostrarModalidad','Póster')}}">Póster</a></li>
                                        <li><a href="{{route('modalidad.mostrarModalidad','Entrevista')}}">Entrevista</a></li>
                                        <li><a href="{{route('modalidad.mostrarModalidad','Video')}}">Video</a></li>
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
                                    {{-- comment 
                                    <li><a href="/logout" title="Styleguide">Cerrar sesión {{auth()->user()->nombre}}</a> </li>
                                    --}}
                                    <li class="has-sub"> 
                                        <div class="aliga">
                                        <span><i class="fas fa-user"></i>{{' '}}</span>{{Auth::guard('admin')->user() ? Auth::guard('admin')->user()->nombre : auth()->user()->nombre}}
                
                                        </div> 
                                        <ul class="loginUsuario">
                                            @if(auth()->user() && auth()->user()->hasRoles(['alumno']))
                                                <li><a href="{{route('semana.subirTrabajo')}}" class="loginUsuario" >Subir Trabajo</a></li>
                                                <li><a href="{{route('alumno.generarGafete')}}" class="loginUsuario" >Generar Gafete</a></li>
                                                <li><a href="{{route('verConstancias')}}" class="loginUsuario" >Constancia de participación</a></li>
                                                <li><a href="{{route('alumno.edit',auth()->user()->id)}}" class="loginUsuario" >Editar Perfil</a></li>
                                            @elseif(auth()->user() && auth()->user()->hasRoles(['director']))
                                                <li><a href="{{route('director.revisarAlumnos')}}" class="loginUsuario" >Revisar Alumnos</a></li>
                                                <li><a href="{{route('director.edit',auth()->user()->id)}}" class="loginUsuario" >Editar Perfil</a></li>    
                                            @elseif(auth()->user() && auth()->user()->hasRoles(['coordinador']))
                                                <li><a href="{{route('coordinador.edit',auth()->user()->id)}}" class="loginUsuario" >Editar Perfil</a></li>    
                                            @elseif(auth('admin')->user())
                                                <li><a href="{{route('admin.editarPerfil',auth('admin')->user()->id)}}" class="loginUsuario" >Editar Perfil</a></li>
                                                <li><a href="/admin" class="loginUsuario">Panel control</a></li>
                                            @endif
                                            @if(auth()->user() && auth()->user()->hasRoles(['subadmin']))
                                                <li><a class="loginUsuario" href="{{route('admin.index')}}">Panel de control</a> </li>
                                            @endif
                                            @if(auth()->user() && auth()->user()->hasRoles(['coordinador']))
                                                <li><a class="loginUsuario" href="{{route('coordinador.index')}}">Administrar institución</a> </li>
                                            @endif

                                            <li><a class="loginUsuario" onclick="event.preventDefault();document.getElementById('logout-form').submit();" href="{{route($ruta)}}">Cerrar sesión</a> </li>
                                            
                                        <ul>
                                    </li>
                                    {{-- comment
                                    <li><a onclick="event.preventDefault();document.getElementById('logout-form').submit();" href="{{route($ruta)}}">Cerrar sesión {{Auth::guard('admin')->user() ? Auth::guard('admin')->user()->nombre : auth()->user()->nombre}}</a> </li>
                                    --}}
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
