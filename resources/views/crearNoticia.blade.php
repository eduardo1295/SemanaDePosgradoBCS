@extends('layoutsM1.principal')

@section('links')
    
    <link rel="stylesheet" href="/css/Login/main2.css">
	<link rel="stylesheet" href="/css/Login/util2.css">
	<style>
	body{
		background: #666666
	}
  .custom-file-label::after{
    content: "Buscar";
  }
  </style>
    
    
@endsection
@section('contenido')
	<div class="container">
		<div class="row">
			<form class="login100-form col-12 col-sm-12 col-md-10 col-lg-8 col-xl-6 offset-md-1 offset-lg-2 offset-xl-6 mx-auto needs-validation align-self-center pt-2 pr-2 pl-2 pb-2 pt-sm-5 pr-sm-5 pl-sm-5 pb-sm-5" novalidate>
				<span class="login100-form-title pb-3">
					<h3><b> Nueva noticia</b> </h3>
                </span>
                <div class="row">
                    <div class="col-12 pb-2">
                        <div class="form-row">
                            <label for="validationTooltip01">Titulo:</label>
                            <input type="text" name="titulo" id="" placeholder="Titulo" class="form-control" required>
                            <div class="invalid-feedback">Ingrese titulo</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Contenido:</label>
                            <textarea class="form-control"  name="contenido" id="" cols="10" rows="10" required placeholder="Ingrese Resumen"></textarea>
                            <div class="invalid-feedback">Dato faltante</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Resumen:</label>
                            <textarea class="form-control"  name="resumen" id="" cols="3" rows="3"   maxlength="100" required placeholder="Ingrese Resumen"></textarea>
                            <div class="invalid-feedback">Dato faltante</div>
                        </div>
                    </div>
                    <div class="col-12 pb-3">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFileLang" lang="es" accept="image/*" required>
                            <label class="custom-file-label" for="customFileLang">Seleccione un  archivo</label>
                            <div class="invalid-feedback">Dato faltante</div>
                        </div>
                    </div>
                </div>

                <div class=" col-7 col-sm-6 col-md-5 col-lg-4 col-xl-3 mx-auto ">
                        <button type="submit" class="btn btn-outline-success btn-lg   pl-0 pr-0 w-100  ">Enviar</button>
                </div>
            </form>
            
		</div>
    </div>
    <script>
            // Disable form submissions if there are invalid fields
            (function() {
              'use strict';
              window.addEventListener('load', function() {
                // Get the forms we want to add validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                  form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                      event.preventDefault();
                      event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                  }, false);
                });
              }, false);
            })();
    </script>
    

@endsection
	
@section('scripts')
    
	<script src="/js/Login/main2.js"></script>
    <script src="/js/popper.min.js"></script>
 
@endsection
	
