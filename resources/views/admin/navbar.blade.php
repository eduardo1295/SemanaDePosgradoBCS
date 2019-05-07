<div class="container-fluid" id="#contenedor" style="z-index:0">
    <div class="row">
        <div class="col-10 offset-1 col-sm-12 offset-sm-0">
            <div class="row d-flex  justify-content-center justify-content-sm-between align-items-center">
                <div class="col-12 col-md-3 d-flex justify-content-center justify-content-sm-start">
                    <a href="/"><img src="/img/logo.png" width="120px"
                            alt="Hair Salon Website Templates Free Download"></a>
                </div>
                <div class="col-12 col-md-6 pt-3 pt-md-0">
                    <h1 class="text-center">Área Administrativa</h1>
                </div>
                <div class="col-12 col-md-3 d-flex justify-content-end">
                    <div class="dropdown  aa">
                        <button class="btn btn-sm btnmenu  btn-primary dropdown-toggle d-block d-sm-none" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="fas fa-bars"></i>
                        </button>

                        <button class="btn btn-primary dropdown-toggle d-none d-sm-block" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user"></i> {{auth('admin')->user()->nombre}}
                        </button>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Mi Perfil</a>
                            <a class="dropdown-item" href="/logout">Cerrar Sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>

@media screen and (max-width: 768px) {
  .dropdown-toggle::after { display: none !important; }
  .aa{ position: fixed; top: 25px; right: 0px ;}
  .btnmenu{ width: 35px; border-radius: 4px 0  0px 4px; }
}

/*
@media screen (max-with: 200px){
    
    
*/

</style>