<div class="container-fluid" id="#contenedor">
    <div class="row">
        <div class="col-12 mx-auto">
            <h1>
                Programas de estudio
            </h1>
        </div>

        <div id="mensaje-acciones" class="col-12 alert alert-success alert-dismissible" role="alert"
            style="display:none">
            <strong> </strong>
        </div>
    </div>
    <div class="row mb-2">
        <legend class="col-form-label col-12 col-md-3 col-lg-3 pt-0   d-flex d-md-block justify-content-center justify-content-md-start">Mostras programas de estudio</legend>
        <div class="col-12 col-md-5 col-lg-4 d-flex d-md-block justify-content-center justify-content-md-start">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="verPro1" checked name="verPro" value="activos">
                <label class="form-check-label" for="verPro1">Activos</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="verPro2" name="verPro" value="eliminados">
                <label class="form-check-label" for="verPro2">Eliminados</label>
            </div>
        </div>
        <div class="col-12 col-md-4 col-lg-5 d-flex d-md-block justify-content-center justify-content-md-start">
            <div class="d-flex justify-content-end">
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="crear-programa"><span><i
                            class="fas fa-plus"></i></span> Nuevo Programa</a>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="display" cellspacing="0" style="width:100%" id="programasDT">
                <thead>
                    <tr>
                        <th>id</th>
                        <th class="all">Nombre</th>
                        <th>Clave Programa</th>
                        <th>Nivel</th>
                        <th>Periodo</th>
                        <th>Última actualización</th>
                        <th>Acciones</th>
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
