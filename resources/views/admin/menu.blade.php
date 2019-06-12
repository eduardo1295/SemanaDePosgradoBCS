<div id="show-sidebar" class="btn btn-sm btn-dark">
    <i class="fas fa-bars"></i>
</div>
<nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-close">

        <div class="d-flex flex-row-reverse">

            <div id="close-sidebar">
                <i class="fas fa-times"></i>
            </div>

        </div>
    </div>
    <div class="sidebar-content">
        <!-- sidebar-brand  -->

        <!-- sidebar-header -->


        <!-- sidebar-menu  -->

        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="{{route('admin.index')}}">
                        <i class="fas fa-home"></i>
                        <span><strong>Inicio</strong></span>
                    </a>
                </li>
                <li>
                    <a href="{{route('noticia.VerNoticias')}}">
                        <i class="fas fa-newspaper"></i>
                        <span><strong>Noticias</strong></span>
                    </a>
                </li>

                <li>
                    <a href="{{route('institucion.VerInstituciones')}}">
                        <i class="fas fa-school"></i>
                        <span><strong>Instituciones</strong></span>
                    </a>
                </li>

                <li>
                    <a href="{{route('carrusel.VerCarrusel')}}">
                        <i class="fab fa-slideshare"></i>
                        <span><strong>Carrusel</strong></span>
                    </a>
                </li>

                <li>
                    <a href="{{route('programa.VerPrograma')}}">
                        <i class="fas fa-user-tie"></i>
                        <span><strong>Programas de estudio</strong></span>
                    </a>
                </li>
                <li>
                    <a href="{{route('modalidad.VerModalidad')}}">
                        <i class="far fa-id-card"></i>
                        <span><strong>Modalidades</strong></span>
                    </a>
                </li>

                {{-- comment 

                <li>
                    <a href="{{route('coordinador.VerCoodinadores')}}">
                        <i class="fas fa-user-tie"></i>
                        <span><strong>Coordinadores</strong></span>
                    </a>
                </li>
                
                <li>
                    <a href="{{route('director.VerDirectores')}}">
                        <i class="fas fa-user"></i>
                        <span><strong>Directores de tesis</strong></span>
                    </a>
                </li>

                <li>
                    <a href="{{route('alumnos.VerAlumnos')}}">
                        <i class="fas fa-user-graduate"></i>
                        <span><strong>Alumnos</strong></span>
                    </a>
                </li>
                --}}
                <li class="sidebar-dropdown">
                    <a>
                        <i class="fas fa-user"></i>
                        <span><strong>Usuarios</strong></span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{route('coordinador.VerCoodinadores')}}">
                                    
                                    <span><strong>Coordinadores</strong></span>
                                </a>
                            </li>
                            
                            <li>
                                    <a href="{{route('director.VerDirectores')}}">
                                        
                                        <span><strong>Directores de tesis</strong></span>
                                    </a>
                            </li>

                            <li>
                                <a href="{{route('alumnos.VerAlumnos')}}">
                                    
                                    <span><strong>Alumnos</strong></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!---->
                <li class="sidebar-dropdown">
                    <a>
                        <i class="fas fa-cogs"></i>
                        <span><strong>Diseño General</strong></span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{route('vistaLogin.VerVistaLogin')}}">
                                    <span><strong>Vista Login</strong></span>
                                </a>
                                <a href="{{route('vistaLogin.disenoColores')}}">
                                    <span><strong>Diseño Colores</strong></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>

        <!-- sidebar-menu  -->
    </div>
    <!-- sidebar-footer  -->
    <div class="sidebar-footer">
        <!--
        <div class="dropdown">
            <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-cog"></i>
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuMessage">
                <a class="dropdown-item" href="#">Mi cuenta</a>
                <a class="dropdown-item" href="#">Ayuda</a>
                <a class="dropdown-item" href="#">Setting</a>
            </div>
        </div>
    -->
        <div>
            @if(auth('admin')->user() || auth()->user())
            @php
            $ruta = auth('admin')->user() ? 'admin.logout' : 'logout';
            @endphp
            <a onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                href="{{route($ruta)}}">Cerrar Sesión
                <i class="fas fa-sign-out-alt"></i>
            </a>

            <form id="logout-form" action="{{route($ruta)}}" method="POST" style="display: none;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
            @endif

        </div>
    </div>
</nav>