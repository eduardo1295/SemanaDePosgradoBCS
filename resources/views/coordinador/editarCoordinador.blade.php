@extends('usuario.editarPerfil')

@section('camposExtras')

<div class="form-group col-6">
    <strong><label for="puesto" class="control-label">Puesto</label><label class="text-danger">*</label></strong>
    <input readonly type="text" name="puesto" id="puesto" value="@isset($usuario->coordinadores->puesto) {{$usuario->coordinadores->puesto}}@endisset" class="form-control" max="30">
    <small><span class="text-danger mensajeError errorposgrado" id="puesto_error"></span></small>
</div>
@endsection