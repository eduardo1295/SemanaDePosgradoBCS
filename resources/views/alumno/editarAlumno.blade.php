@extends('usuario.editarPerfil')

@section('camposExtras')
<div class="form-group col-6">
        <strong><label for="primer_apellido" class="control-label">Número de Control</label><label class="text-danger">*</label></strong>
        <input type="text" name="num_control" id="num_control" value="{{$usuario->alumnos->num_control}}" readonly class="form-control" max="60">
        <small><span class="text-danger mensajeError errorposgrado" id="primer_apellido_error"></span></small>
</div>
<div class="form-group col-6">
        <strong><label for="primer_apellido" class="control-label">Semestre</label><label class="text-danger">*</label></strong>
        <input type="text" name="semestre" id="semestre" value="{{$usuario->alumnos->semestre}}" readonly class="form-control" max="60">
        <small><span class="text-danger mensajeError errorposgrado" id="primer_apellido_error"></span></small>
</div>
@endsection