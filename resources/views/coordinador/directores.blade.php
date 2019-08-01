<div class="container-fluid" id="#contenedor">
        <div class="row">
            <div class="col-12 mx-auto">
                <h1>
                    Directores de tesis
                </h1>
            </div>
    
            <div id="mensaje-acciones" class="col-12 alert alert-success alert-dismissible" role="alert"
                style="display:none">
                <strong> </strong>
            </div>
        </div>
        <div class="row mb-2">
            <legend class="col-form-label col-12 col-md-3 col-lg-3 pt-0   d-flex d-md-block justify-content-center justify-content-md-start">Mostrar Directores de tesis</legend>
            <div class="col-12 col-md-5 col-lg-4 d-flex d-md-block justify-content-center justify-content-md-start">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="verDir1" checked name="verDir" value="activos">
                    <label class="form-check-label" for="verDir1">Activos</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="verDir2" name="verDir" value="eliminados">
                    <label class="form-check-label" for="verDir2">Eliminados</label>
                </div>
            </div>
            <div class="col-12 col-md-4 col-lg-5 d-flex d-md-block justify-content-center justify-content-md-start">
                <div class="d-flex justify-content-end">
                    <a href="javascript:void(0)" class="btn btn-info ml-3" id="crear-director"><span><i
                                class="fas fa-plus"></i></span> Agregar director</a>
    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="display" cellspacing="0" style="width:100%" id="directoresdt">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th class="all">Nombre</th>
                            <th>Primer apellido</th>
                            <th class="min-tablet-l">Segundo apellido</th>
                            <th class="min-tablet-l">Email</th>
                            <th class="min-tablet-l">Última Actualización</th>
                            <th class="all">Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                </table>
            </div>
        </div>
    </div>
    