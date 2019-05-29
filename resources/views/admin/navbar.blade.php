<div class="container-fluid" id="#contenedor" style="z-index:0 ; background:#ececec;" >
    <div class="row" >
        <div class="col-12">
            <div class="row d-flex  justify-content-center justify-content-sm-between align-items-center">
                <div class="col-12 col-sm-6 col-md-3 d-flex justify-content-center justify-content-sm-start">
                    <a href="/admin"><img src="{{url('img/semanaLogo')}}/{{ $semana->url_logo }}" width="120px"
                            alt="" id="logoMenu"></a>
                </div>
                <div class="col-12 col-sm-12 col-md-6 pt-3 pt-md-0">
                    <h1 class="text-center">Gestor Administrativo</h1>
                </div>
                <div class="col-12 col-md-3 d-flex justify-content-end">
                    <div class="dropdown  aa">
                        <button class="btn btn-sm btnmenu  btn-primary dropdown-toggle d-block d-lg-none" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="fas fa-bars"></i>
                        </button>

                        <button class="btn btn-primary dropdown-toggle d-none d-lg-block" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user"></i> {{auth('admin')->user()->nombre}}
                        </button>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Mi Perfil</a>
                            @if(auth('admin')->user() || auth()->user())
                                {{-- comment 
                                @if(auth()->user()->hasRoles(['alumno']))
                                    <li><a href="/login" title="Styleguide">Entro</a> </li>
                                @endif
                                --}}
                                @php
                                  $ruta = auth('admin')->user() ? 'admin.logout' : 'logout';                                      
                                @endphp
                                <a class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();" href="{{route($ruta)}}">Cerrar Sesión</a>
                                <form id="logout-form" action="{{route($ruta)}}" method="POST" style="display: none;">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </form>
                            @endif
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
  .aa{ position: fixed; top: 25px; right: 0px ; z-index: 10000}
  .btnmenu{ width: 35px; border-radius: 4px 0  0px 4px; }
}

/*
@media screen (max-with: 200px){
    
    
*/

</style>