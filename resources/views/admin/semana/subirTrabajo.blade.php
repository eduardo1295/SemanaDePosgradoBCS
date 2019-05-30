{{-- SECCION BLADE--}}
@extends('layoutsM1.principal')

@section('contenido')
@section('links')
<link rel="stylesheet" href="{{ mix('css/Maqueta2.css')}} ">
<script src="/js/owl.carousel.min.js"> </script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@endsection
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 id="Titulo" class="display-5  font-weight-bold rounded p-auto pt-3">Subir trabajo</h1> <br>
        </div>
    </div>
    
    <form action="" method="POST" class="border" >
        <div class="form-row">
            <div class="form-group col-12">
                <strong><label for="posgrado" class="control-label">Modalidad</label></strong>
                    <select class="form-control posgrado" id="posgrado" name="posgrado">
                        <option selected value="">Seleccione modalidad</option>
                        <option value="Póster">Póster</option>
                        <option value="Doctorado">Entrevista</option>
                        <option value="Maestría">Video</option>
                        <option value="Doctorado">Ponencia Oral</option>
                        
                    </select>
                <small><span class="text-danger mensajeError errorposgrado" id="modalidad_error"></span></small>
            </div>
            <div class="form-group col-12">
                <strong><label for="titulo" class="control-label">Titulo</label></strong>
                    <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Titulo del trabajo">
                <small><span class="text-danger mensajeError errorposgrado" id="titulo_error"></span></small>
            </div>
            <div class="form-group col-12">
                <strong><label for="resumen" class="control-label">Resumen</label></strong>
                <textarea class="form-control" id="resumen" name="resumen" rows="5" placeholder="Resumen del programa"></textarea>
            </div>
        </div>
        <strong><label for="clave" class="control-label">Palabra clave</label></strong> <br>
        <div class="form-group row">
                
                <div class="col"><input type="text" name="clave1"  id="clave1" class="form-control" placeholder="clave 1"></div>
                <div class="col"><input type="text" name="clave2"  id="clave2" class="form-control" placeholder="clave 2"></div>
                <div class="col"><input type="text" name="clave3"  id="clave3" class="form-control" placeholder="clave 3"></div>
                <div class="col"><input type="text" name="clave4"  id="clave4" class="form-control" placeholder="clave 4"></div>
                <div class="col"><input type="text" name="clave5"  id="clave5" class="form-control" placeholder="clave 5"></div>
        </div>
        <div class="row">
            <div class="form-group col-12">
                    <strong><label for="resumen" class="control-label">Director de tesis</label></strong>
                    <input type="text" class="form-control" id="directortesis" name="directortesis" placeholder="director de tesis">
            </div>
        </div>
        
    </form>
</div>

@section('menu')
@include('layoutsM2.navbar')
@endsection
@section('footer')
@include('layoutsM2.footer')
@endsection
{{-- END SECCION BLADE--}}

@section('scripts')
<script src="/js/menumaker.js"></script>
@endsection
@endsection