<div id="show-sidebar" class="btn btn-sm btn-dark" >
    <i class="fas fa-bars"></i>
</div>
<nav id="sidebar" class="sidebar-wrapper">
        <div class="sidebar-close">
               
                <div class="d-flex flex-row-reverse">
                    
                        <div  id="close-sidebar">
                                <i class="fas fa-times"></i>
                            </div>
                    
                </div>
            </div>
    <div class="sidebar-content">
        <!-- sidebar-brand  -->

        <!-- sidebar-header -->
        <div class="sidebar-header">
            <div class="d-flex flex-nowrap">
                <div class="mx-auto">
                    <img src="{{ URL::to('/') }}/img/logo.png" height="80" />
                </div>

            </div>


            <div class="sidebar-header d-flex flex-nowrap">
                <div class="user-info mx-auto">
                    <span class="user-name">Jhon
                        <strong>Smith</strong>
                    </span>
                    <span class="user-role">Administrator</span>
                </div>
            </div>
        </div>

        <!-- sidebar-menu  -->

        <div class="sidebar-menu">
            <ul>
                <li class="header-menu">
                    <span>General</span>
                </li>
                <li class="sidebar-dropdown">
                    <a>
                        <i class="fa fa-tachometer-alt"></i>
                        <span>Administrar semanas</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="#">Agregar semana
                                </a>
                            </li>
                            <li>
                                <a href="#">Ver semanas</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="sidebar-dropdown">
                        <a>
                            <i class="fas fa-newspaper"></i>
                            <span>Administrar noticias</span>
                        </a>
                        <div class="sidebar-submenu">
                            <ul>
                                <li>
                                    <a href="{{route('noticia.create')}}">Agregar noticia
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('noticia.VerNoticias')}}">Ver noticias</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <li class="sidebar-dropdown">
                    <a>
                            <i class="fas fa-school"></i>
                        <span>Administrar Instituciones</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="#">Agregar institución</a>
                            </li>
                            <li>
                                <a href="{{route('institucion.VerInstituciones')}}">Ver instituciones</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="header-menu">
                    <span>Extra</span>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-book"></i>
                        <span>Convocatoria</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-calendar"></i>
                        <span>Carrusel principal</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-folder"></i>
                        <span>Pie de pagina</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.usuarios')}}">
                        <i class="fa fa-folder"></i>
                        <span>Todos los usuarios</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-folder"></i>
                        <span>Pie de pagina</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.usuarios')}}">
                        <i class="fa fa-folder"></i>
                        <span>Todos los usuarios</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- sidebar-menu  -->
    </div>
    <!-- sidebar-footer  -->
    <div class="sidebar-footer">
            <div class="dropdown">
                <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-cog"></i>
                    <span class="badge-sonar"></span>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuMessage">
                    <a class="dropdown-item" href="#">Mi cuenta</a>
                    <a class="dropdown-item" href="#">Ayuda</a>
                    <a class="dropdown-item" href="#">Setting</a>
                </div>
            </div>
            <div>
                
                    <a href="/logout">
                        <i class="fas fa-power-off"></i>
                    </a>
            </div>
        </div>
</nav>