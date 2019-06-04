@extends('Plantilla.principal')

@section('links')
    
    <link rel="stylesheet" href="/css/Login/main2.css">
	<link rel="stylesheet" href="/css/Login/util2.css">
	<style>
	body{
		background: #666666
	}
    </style>
    <script>
        
    </script>
    
@endsection
@section('contenido')
	<div class="container">
		<div class="row">
			<form class="login100-form col-12 col-sm-12 col-md-10 col-lg-8 col-xl-6 offset-md-1 offset-lg-2 offset-xl-6 mx-auto needs-validation align-self-center pt-2 pr-2 pl-2 pb-2 pt-sm-5 pr-sm-5 pl-sm-5 pb-sm-5" novalidate>
				<span class="login100-form-title pb-5">
					Registrar Trabajo
                </span>
                <div class="row">
                    <div class="col-12">
                        <div class="form-row">
                            <label for="validationTooltip01">Modalidad:</label>
                            <select class="custom-select" id="validationTooltip01" required>
                                <option value="">Seleccione una opcion</option>
                                <option value="1">Ponenecia Oral</option>
                            </select>
                            <div class="invalid-feedback">Seleccione una opción</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Titulo:</label>
                            <input type="text" name="" id="" placeholder="Ingrese su titulo" class="form-control" required>
                            <div class="invalid-feedback">Ingrese el titulo</div>

                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Resumen:</label>
                            <textarea class="form-control"  name="" id="" cols="10" rows="10" required placeholder="Ingrese Resumen"></textarea>
                            <div class="invalid-feedback">Falta el resumen</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Director Tesis:</label>
                            <select class="custom-select" required>
                                <option value="">Seleccione una opcion</option>
                                <option value="1">Joel Perez</option>
                            </select>
                            <div class="invalid-feedback">Seleccione una opcion</div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-end form-group">
                    <div class="col-12">
                            <label for="asda">Palabras Claves:</label>
                    </div>
                    <div class="col-12 col-sm mb-2 mb-sm-0">
                        <input type="text" name="" id="" class="form-control" placeholder="clv 1" required>
                    </div>
                    <div class="col-12 col-sm mb-2 mb-sm-0">
                        <label for="asda"> </label>
                        <input type="text" name="" id="" class="form-control" placeholder="clv 2" required>
                    </div>
                    <div class="col-12 col-sm mb-2 mb-sm-0">
                        <label for="asda"> </label>
                        <input type="text" name="" id="" class="form-control" placeholder="clv 3" required>
                    </div>
                    <div class="col-12 col-sm mb-2 mb-sm-0">
                        <label for="asda"> </label>
                        <input type="text" name="" id="" class="form-control" placeholder="clv 4" required>
                    </div>
                    <div class="col-12 col-sm mb-2 mb-sm-0">
                        <label for="asda"> </label>
                        <input type="text" name="" id="" class="form-control" placeholder="clv 5" required>
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
	
