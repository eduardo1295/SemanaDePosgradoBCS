@extends('usuario.editarPerfil')

@section('camposExtras')

<div class="form-group col-6">
    <strong><label for="grado" class="control-label">Grado</label></strong>
    <input type="text" name="grado" id="grado" value="{{$usuario->directortesis->grado}}" class="form-control" max="30">
    <small><span class="text-danger mensajeError errorposgrado" id="grado_error"></span></small>
</div>
@endsection