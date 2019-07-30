{{-- SECCION BLADE--}}
@extends('Plantilla.principal')

@section('contenido')
@section('links')
<link rel="stylesheet" href="/css/Maqueta2.css">
<link href="/css/modales/snackbar.css" rel="stylesheet">

@endsection
<section id="trabajo">
        <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1 id="Titulo" class="display-5  font-weight-bold rounded p-auto pt-3">Editar perfil</h1> <br>
                    </div>
                </div>
                <form id="alumnoForm" name="alumnoForm" class="form-horizontal mb-5 formulario" enctype="multipart/form-data">
                    <input type="hidden" name="" value="{{auth()->user()->id}}" id="alumno_id">
                    <div class="form-row pl-5 pr-5 pt-3">
                        <div class="form-group col-12">
                            <strong><label for="Nombre" class="control-label">Nombre</label><label class="text-danger">*</label></strong>
                            <input type="text" name="nombre" id="nombre" value="{{$usuario->nombre}}" class="form-control" max="40">
                            <small><span class="text-danger mensajeError errorposgrado" id="nombre_error"></span></small>
                        </div>
                        <div class="form-group col-6">
                            <strong><label for="primer_apellido" class="control-label">Apellido paterno</label><label class="text-danger">*</label></strong>
                            <input type="text" name="primer_apellido" id="primer_apellido" value="{{$usuario->primer_apellido}}" class="form-control" max="30">
                            <small><span class="text-danger mensajeError errorposgrado" id="primer_apellido_error"></span></small>
                        </div>
                        
                        <div class="form-group col-6">
                                <strong><label for="segundo_apellido" class="control-label">Apellido materno</label></strong>
                                <input type="text" name="segundo_apellido" id="segundo_apellido" value="{{$usuario->segundo_apellido}}" class="form-control" max="30">
                                <small><span class="text-danger mensajeError errorposgrado" id="segundo_apellido_error"></span></small>
                        </div>
                        @yield('camposExtras','')
                        <div class="form-group col-6">
                                <strong><label for="primer_apellido" class="control-label">Correo Electrónico</label><label class="text-danger">*</label></strong>
                                <input type="text" name="email" id="email" value="{{$usuario->email}}" class="form-control" max="60">
                                <small><span class="text-danger mensajeError errorposgrado" id="email_error"></span></small>
                        </div>
                        <div class="form-group col-md-6">
                            <strong><label for="password" class="control-label">Contraseña</label></strong>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Contraseña para la cuenta" value="" maxlength="60" required=""
                                    aria-describedby="passwordHelpBlock">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary btn-show-pass" type="button"><span>
                                            <i class="fas fa-eye"></i>
                                        </span></button>
                                </div>
                            </div>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                Su contraseña debe tener mínimo 6 caracteres, debe contener al menos 1 letra mayúscula,
                                1 letra minúscula, 1 número y 1 carácter especial(#?!@$^&-).
                            </small>
                            <small><span class="mensajeError text-danger" id="password_error"></span></small>
                        </div>
                        
                        <div class="col-12 d-flex justify-content-between pb-3">
                            <strong class="text-danger">Campos requeridos *</strong>
                            <button type="button" class="btn btn-primary" id="btn-save" value="{{auth()->user()->roles()->first()->nombre}}">Guardar</button>
                        </div>        
                    </div>
                </form>
            </div>
            <div id="snackbar"></div>
            <div id="snackbarError" style="z-index:1051;"></div>
</section>
<script>

</script>

@section('scripts')
<script src="{{ asset('/js/alumno/editarAlumno.js') }}"></script>
<script src="{{ asset('/js/snack/snack.js') }}"></script>
@endsection
@endsection