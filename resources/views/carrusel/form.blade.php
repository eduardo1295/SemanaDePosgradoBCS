
            {{ csrf_field() }}

          <div class="form-group">
            <label for="usr">Title of Feature:</label>
            <input type="text" class="form-control" name="titulo" value="{{$carrusel->titulo ?? old('titulo')}}">
            {{$errors->first('titulo')}}
          </div>
          <div class="form-group">
            <strong>Details:</strong>
            <input type="text" class="form-control" name="contenido" value="{{$carrusel->contenido ?? old('contenido')}}">
            {{$errors->first('contenido')}}
          </div>
          <input type="file"  name="imgcarrusel" class="form-control-file" id="logo">
          {{$errors->first('imgcarrusel')}}
          <div class="form-group">           
              @if ($carrusel->url_imagen!='sin imagen')
                <strong>Imagen actual:</strong>
                <img src="{{$carrusel->url_imagen}}" alt="">
              @endif         
          </div>
          <button type="submit" class="btn btn-primary" value="{{isset($btnText) ? $btnText : 'Guardar'}}">Guardar</button>
