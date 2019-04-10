{!!csrf_field()!!}
<form id="institucionForm" name="institucionForm" class="form-horizontal">
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="nombre">Nombre</label>
        <input class="form-control" id="nombre" name="nombre" placeholder="Nombre de la institución">
      </div>
      <div class="form-group col-md-6">
        <label for="direccion_web">Dirección web</label>
        <input type="password" class="form-control" id="direccion_web" name="direccion_web" placeholder="URL de la institución">
      </div>
    </div>
    <div class="form-group">
      <label for="telefono">Teléfono</label>
      <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Télefono de la institución">
    </div>
    <div class="form-group">
      <label for="ciudad">Ciudad</label>
      <input type="text" class="form-control" id="ciudad" name="ciudad" placeholder="Apartment, studio, or floor">
    </div>
    <div class="form-group">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="gridCheck">
        <label class="form-check-label" for="gridCheck">
          Check me out
        </label>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Sign in</button>
  </form>



@if($showFields)
    <label for="nombre">
        Autor
        <input class="form-control" type="text" name="autor" value="{{$post->autor ?? old('autor')}}">
        {{$errors->first('autor')}}
    </label>    
@endif
            
<label for="titulo">
    Título
    <input class="form-control" type="text" name="titulo" value="{{$post->titulo ?? old('titulo')}}">
    {{$errors->first('titulo')}}
</label>
    <br><br>
<label for="Contenido">
    Contenido
    <textarea id="conte" class="form-control " type="text" name="contenido">{{ $post->contenido ?? old('contenido')}}</textarea>
    {{$errors->first('contenido')}}
</label>
    <br><br>
    <input class="btn btn-success" type="submit" value="{{isset($btnText) ? $btnText : 'Guardar'}}">
    <br><br>
    <h4>Etiquetas</h4>
    @if ($tags->count()>=1)
        @foreach ($tags as $id => $nombre)
            <label>
                <input type="checkbox" 
                value={{$id}}
                {{ $post->tags->pluck('id')->contains($id) ? 'checked': ''}}
                name="tags[]">
                {{$nombre}}
            </label>
        @endforeach
    @else
        <h6>No hay etiquetas para seleccionar</h6>
    @endif
    {{$errors->first('tags')}}
    <h4>Categorías</h4>
    @if ($categories->count()>=1)
        @foreach ($categories as $id => $nombre)
            <label>
                <input type="checkbox" 
                value={{$id}}
                {{ $post->categories->pluck('id')->contains($id) ? 'checked': ''}}
                name="categories[]">
                {{$nombre}}
            </label>
        @endforeach
    @else
        <h6>No hay categorías para seleccionar</h6>
    @endif
    <br>
    {{$errors->first('categories')}}