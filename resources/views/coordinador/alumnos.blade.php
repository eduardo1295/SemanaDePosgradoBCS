<div class="container-fluid" id="#contenedor">
    <div class="row">
            <div class="col-12 d-flex d-md-block justify-content-center justify-content-md-start">
            <h1>
                Alumnos participantes
            </h1>
        </div>



    </div>
    <div class="row mb-2">
        <legend
            class="col-form-label col-12 col-md-3 col-lg-2 pt-0   d-flex d-md-block justify-content-center justify-content-md-start">
            Mostrar Alumnos</legend>
        <div class="col-12 col-md-4 col-lg-4 d-flex d-md-block justify-content-center justify-content-md-start">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="alumnoR1" checked name="verAlumno" value="activos">
                <label class="form-check-label" for="alumnoR1">Activos</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="alumnoR2" name="verAlumno" value="eliminados">
                <label class="form-check-label" for="alumnoR2">Eliminados</label>
            </div>
        </div>
        <div class="col-12 col-md-5 col-lg-6 d-flex d-md-block justify-content-center justify-content-md-start">
            <div class="d-flex justify-content-end">
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="crear-alumno"><span><i
                            class="fas fa-plus"></i></span> Agregar alumno</a>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="display" cellspacing="0" style="width:100%" id="alumnosDT">
                <thead>
                    <tr>
                        <th>id</th>

                        <th class="all">No. Control</th>
                        <th class="none">Programa de estudios</th>
                        <th >Nombre</th>
                        <th >Primer apellido</th>
                        <th >Segundo apellido</th>
                        <th >Email</th>
                        
                        <th class="none">Director de tesis</th>
                        <th >Última Actualización</th>
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
                        
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div>
        <form id="alumnosImportarForm" name="alumnosImportarForm" class="pl-0 col-12 form-horizontal"
            enctype="multipart/form-data">
            <strong><label for="">Importar alumnos:</label></strong><br>
            
                    <div class="col-12 alert alert-warning" role="alert">
                        Es necesario registrar previamente los directores de tesis
                    </div>
            
            <div class="form-row">
                <div class="form-group col-md-8">
                    <div class="custom-file">
                        <input type="file" name="archivo" class="custom-file-input" id="archivo" lang="es">
                        <label for="archivo" class="custom-file-label">Seleccionar Archivo</label>
                    </div>
                </div>
                
                <div class="form-group col-md-4" style="text-align:start">

                    <a onclick="importarAlumnos();"  class="btn btn-primary importarAlumnos"
                        id="importarAlumnos" style="cursor: pointer;color:white;">Importar</a>

                </div>
            </div>
        </form>

        <div id="mensajeAlumnos" class="col-12" style="display:none">

        </div>
        <strong><label for="">Exportar alumnos:</label></strong><br>
        <a href="{{route('alumno.ExportarAlumnos')}}" target="_blank" id="pdf" class="btn btn-primary">PDF</a>
        <a href="{{route('alumno.exportarXLSAlumnos')}}" class="btn btn-primary">Excel</a>
    </div>

</div>
