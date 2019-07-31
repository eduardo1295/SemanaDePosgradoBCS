{{-- SECCION BLADE--}}
@extends('Plantilla.principal')

@section('links')
<link rel="stylesheet" href="{{ asset('/css/Maqueta2.css')}}  ">

<style>
    .holo {
        border-left: 10px solid white;
    }
</style>
@endsection

@section('contenido')


@if(isset($trabajo))
@if ($trabajo->url=='no_disponible')
<div class="container-fluid pl-1 pr-1 pl-md-5 pr-md-5" style="height:100vh">
    <h1>Trabajo no disponible</h1>
</div>
@else
<div class="container">
    <!--<div class="container-fluid pl-1 pr-1 pl-md-5 pr-md-5">-->
    <div class="row">
        <div class="col-12">
            <h1 id="Titulo" class="display-   font-weight-bold rounded p-auto pt-3">Revisión de trabajo</h1>
        </div>
    </div>
    <div class="row">

    </div>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-8 col-xl-9">
            <embed class="embed-responsive-item embed-responsive-16by9"
                src="{{ URL::to('/') }}/documentos/trabajos/{{$trabajo->url}}" type="application/pdf"
                style="width:100%;height: 100vh;" internalinstanceid="9">
        </div>
        <form id="trabajoForm" name="trabajoForm" class="col-12 col-sm-12 col-md-4 col-xl-3 formulario form-horizontal mb-2" method="POST"
            action="{{route('trabajo.revisionTrabajo')}}">
            @csrf
            <input type="hidden" name="id_trabajo" id="id_trabajo" value="{{$trabajo->id_trabajo}}">
            <div class="row">
                <div class="form-group col-12">
                    <label for="comentario" class="control-label"><h3>Comentario:</h3></label>
                    <textarea  class="form-control" id="comentario" name="comentario" rows="3" 
                        placeholder="comentario" @isset($trabajo) @if($trabajo->autorizado == 1) readonly @endif  @endisset>@isset($trabajo->comentario){{$trabajo->comentario}}@endisset</textarea>
                    <small><span class="text-danger mensajeError errorposgrado" id="comentario_error"></span></small>
                </div>
                <div class="col-12 d-flex justify-content-end">
                    
                    <input type="button" class="btn btn-success mr-3" data-toggle="modal" data-target="#mensajeModal" value="Aceptado"  @isset($trabajo) @if($trabajo->autorizado == 1) disabled @endif  @endisset>
                    <input type="button" class="btn btn-danger" data-toggle="modal" data-target="#mensajeModal2" value="Rechazado" @isset($trabajo) @if($trabajo->autorizado == 1) disabled @endif  @endisset>
                </div>
            </div>

            <div class="modal fade" id="mensajeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Mensaje</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        ¿Seguro qué desea aceptar el trabajo?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                      <input type="submit" name="revisado" class="btn btn-info mr-3" value="Aceptado">
                    </div>
                  </div>
                </div>
            </div>
            <div class="modal fade" id="mensajeModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Mensaje</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      ¿Seguro que desea rechazar el trabajo?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                      <input type="submit" name="revisado" class="btn btn-warning" value="Rechazado">
                    </div>
                  </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endif
@else
<div class="container-fluid pl-1 pr-1 pl-md-5 pr-md-5" style="height:100vh">
    <h1>Convocatoria no disponible</h1>
</div>
@endif
@endsection