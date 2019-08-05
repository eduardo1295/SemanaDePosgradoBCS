<div class="container-fluid redimensionar" id="contenedor" style="z-index:0 ; background:#ececec;">
    <div class="row">
        <div class="col-12">
            <div class="row d-flex  justify-content-center justify-content-xl-between align-items-center">
                <div class="col-12 col-sm-3 col-md-3 d-flex justify-content-center justify-content-md-start">
                    <a href="{{ route('admin.index')}}"><img id="logoMenu" src="{{ asset('/storage/img/semanaLogo').'/'.$semana->url_logo.'/?'.date('H:i:s') }}" width="120px" alt=""></a>
                </div>
                <div class="col-12 col-sm-9 col-md-6 col-xl-6  pt-3 pt-md-0">
                    <h1 class="text-center">Área Administrativa</h1>
                </div>
                <div class="col-12 col-md-3 d-flex justify-content-end" style="background:black;">
                    <div id="navbarM2" class="d-none d-lg-block" style="position: absolute; width: auto;  ">
                        <div class="header" style="padding-top:0; top: -15px;">
                            <div class="">
                                <div class="row">
                                    <div class="">
                                        <div class="navigation" style="width:100%">
                                            <div id="navigation">
                                                <ul>
                                                    @php
                                                    $ruta = auth('admin')->user() ? 'admin.logout' : 'logout';
                                                    @endphp
                                                    <li class="has-sub">
                                                        <div class="aliga" style="background-color: #007bff ; color: white; padding: 10px; border-radius: 15px; ">
                                                            <span><i
                                                                    class="fas fa-user"></i>{{' '}}</span>{{Auth::guard('admin')->user() ? Auth::guard('admin')->user()->nombre : auth()->user()->nombre}}
                                                        </div>
                                                        <ul class="loginUsuario">
                                                            <li><a href="{{ route('admin.index')}}"
                                                                class="loginUsuario">Panel control</a></li>
                                                            <li><a href="{{Auth::guard('admin')->user() ? route('admin.editarPerfil',auth('admin')->user()->id) : route('coordinador.edit',auth()->user()->id)}}"
                                                                    class="loginUsuario">Editar Perfil</a></li>
                                                            @if(auth()->user() && auth()->user()->hasRoles(['coordinador']))
                                                                <li><a class="loginUsuario" href="{{route('coordinador.index')}}">Administrar institución</a> </li>
                                                            @endif
                                                            <li><a class="loginUsuario"
                                                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                                                    href="{{route($ruta)}}">Cerrar sesión</a> </li>
                                                            <ul>
                                                    </li>
                                                    <form id="logout-form" action="{{route($ruta)}}" method="POST"
                                                        style="display: none;">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    </form>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="navbarM2" class="aa d-block d-lg-none" style="position: absolute; width: auto;  ">
                    <div class="header" style="padding-top:0; top: -15px; background-color:transparent;">
                        <div class="">
                            <div class="row">
                                <div class="">
                                    <div class="navigation" style="width:100%;position:fixed">
                                        <div id="navigation">
                                            <ul>
                                                @php
                                                $ruta = auth('admin')->user() ? 'admin.logout' : 'logout';
                                                @endphp
                                                <li class="has-sub">
                                                    <div class="aliga" style="border-radius: 4px 0 0 4px;background-color: #007bff ; color: white; padding: 10px;">
                                                        <span><i class="fas fa-bars"></i>
                                                    </div>
                                                    <ul class="loginUsuario">
                                                        <li><a class="loginUsuario"
                                                                onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                                                href="{{ route('admin.index')}}">Panel de Control</a> </li>
                                                        <li><a href="{{Auth::guard('admin')->user() ? route('admin.editarPerfil',auth('admin')->user()->id) : route('coordinador.edit',auth()->user()->id)}}"
                                                                class="loginUsuario">Editar Perfil</a></li>
                                                                @if(auth()->user() && auth()->user()->hasRoles(['coordinador']))
                                                                    <li><a class="loginUsuario" href="{{route('coordinador.index')}}">Administrar institución</a> </li>
                                                                @endif
                                                        <li><a class="loginUsuario"
                                                                onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                                                href="{{route($ruta)}}">Cerrar sesión</a> </li>

                                                    <ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
<style>

@media screen and (max-width: 992px) {
  .dropdown-toggle::after { display: none !important; }
  .aa{ position: fixed; top: 25px; right: 0px ;}
  .btnmenu{ width: 35px; border-radius: 4px 0  0px 4px; }
}
@media (max-width: 992px) and (min-width: 768px){
#navbarM2 {
    overflow: visible !important;
}

</style>