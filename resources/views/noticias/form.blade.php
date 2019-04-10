
          <form method="POST" action="{{ route('noticia.store') }}" enctype="multipart/form-data">
              {{ csrf_field() }}
            <div class="form-group">
              <label for="usr">Titulo</label>
              <input type="text" class="form-control" name="titulo" value="{{$noticia->titulo ?? old('titulo')}}">
              {{$errors->first('titulo')}}
            </div>
            <div class="form-group">
                <label for="usr">Resumen:</label>
                <input type="text" class="form-control" name="resumen" value="{{$noticia->resumen ?? old('resumen')}}">
                {{$errors->first('resumen')}}
              </div>
            <div class="form-group">
              <strong>Contenido:</strong>
              <textarea class="form-control summernote" name="contenido">
                      {{$noticia->contenido ?? old('contenido')}}
              </textarea>
              {{$errors->first('contenido')}}
            </div>
            <div class="form-group">
                <strong>Imagen de la noticia:</strong>
                <input type="file"  name="imgnoticia" class="form-control-file" id="logo">
                {{$errors->first('imgnoticia')}}
              </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary" value="{{isset($btnText) ? $btnText : 'Guardar'}}">Guardar</button>
            </div> 
            
          </form>
