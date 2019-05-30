<div class="container">
    
    @foreach($data as $row)
    <div class="row">
        <div class="col-12">
            <div class="card mb-3 hvr-underline-from-left w-100">
                <div class="row no-gutters align-items-center">
                    <div class="col-sm-4 col-md-2">
                            @if ($row->url_imagen!='sin imagen')
                            <img src="{{url($row->url_imagen)}}" alt="" class="img-fluid img-noti-pag">
                            @endif
                    </div>
                    <div class="col-sm-8 col-md-10">
                        <div class="card-body ">
                            <h5 class="card-title">{{ $row->titulo }}</h5>
                            <p class="card-text">{{ $row->resumen }}</p>
                            <div class="d-flex justify-content-between ">
                                <p class="card-text"><small class="text-muted">Ultima modiciacion
                                        {{ $row->fecha_creacion }}</small></p>
                                <h4><a href="{{route('noticias.show',$row->id_noticia)}}" class="badge badge-primary">Ver Mas</a></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endforeach
</div>

<div class="d-flex justify-content-center">
{!! $data->links() !!}
</div>