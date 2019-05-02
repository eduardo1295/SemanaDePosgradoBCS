@extends('layoutsM1.principal')

@section('links')
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<style>
	body{
		background-image: url('/img/nature.jpg');
		background-repeat: no-repeat; /* Do not repeat the image */
		background-size: cover;
		
	}
	</style>
@endsection

@section('contenido')
	<div class="container" style="width: 100%;  height: 300px ;">
		<div class="d-flex row justify-content-center align-items-center align-items-center " style="height:550px">
			<form action="/login/admin" method="post" class="col-6" style="background : white;  opacity: 0.9">
				@csrf
				<div class="row">
					<div class="col-12" style="background: #777777; color: white">
						<h4 class="text-center pt-3"><strong >Login Administrador</strong></h4>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-10 offset-1 pt-3">
							<label for="email"><strong>Email:</strong></label>
							<input type="email" name="email" id="email" class="form-control" placeholder="Email" aria-describedby="c1" required>
							<small id="c1" class="text-muted">Ingrese su coreeo electronico</small>
					</div>
					<div class="form-group col-9 offset-1">
							<label for="password"><strong>Contraseña:</strong></label>
							<input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" aria-describedby="c2" required>
							<small id="c2" class="text-muted">Ingrese su contraseña</small>
							<div class="invalid-feedback">
									<a href="#">Olvide mi contraseña</a>
							</div>
					</div>
					<div class="col-1 d-flex align-items-center align-items-center">
							<span class="btn-show-pass">
								<i class="fas fa-eye"></i>
							</span>
					</div>

					<div class="form-group col-10 offset-1">
							<div class="g-recaptcha mb-3" data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}">
					</div>
					

					<div class="col-sm-12">
						@if (count($errors) > 0)
							<div class="alert alert-danger">
								<p>{{ $errors->first('g-recaptcha-response') }}</p>
							</div>
						@endif
					</div>
					
					<div class="col-12 pb-3 pt-3">
							<input type="submit" value="Login" class="btn btn-primary mx-auto pl-5 pr-5 w-100">
					</div>
				</div>
				
				
					
				
				
				

				
				

				
			</form>
		</div>
	</div>

	{{-- comment 
	
	<div class="container-fluid h-100">
		<div class="row d-flex justify-content-center align-items-center align-content-center">
			<form method="POST"  action="/login/admin" class="login100-form col-6 validate-form align-content-center">
				<div class="col-12">
						<h4 class="text-center pb-5"> Acceso Administrador</h4>
				</div>
				<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
					<input class="input100" type="text" name="email" value="{{ old('email') }}">
					<span class="focus-input100"></span>
					<span class="label-input100">Email</span>
				</div>
				<div class="row align-items-center">
					<div class="col-11 ">
						<div class="wrap-input100 validate-input" data-validate="Password is required">
							<input class="input100" id="pass" type="password" name="password">
							<span class="focus-input100"></span>
							<span class="label-input100">Password</span>
						</div>
					</div>
					<div class="col-1 pr-0 pl-0">
						<span class="btn-show-pass">
							<i class="fas fa-eye"></i>
						</span>
					</div>
				</div>
				<div class="flex-sb-m w-full p-t-3 p-b-32">
					<div class="contact100-form-checkbox">
						<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
						<label class="label-checkbox100" for="ckb1">
							Remember me
						</label>
					</div>
					<div>
						<a href="#" class="txt1">
							Forgot Password?
						</a>
					</div>
				</div>
				@csrf
				<div class="g-recaptcha mb-3" data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}">
				</div>
				<div class="col-sm-12">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<p>{{ $errors->first('g-recaptcha-response') }}</p>
						</div>
					@endif
				</div>
				<div class="container-login100-form-btn">
					<input type="submit" value="Login" class="login100-form-btn">
				</div>
			</form>
		</div>
	</div>
	--}}
@endsection
	
@section('scripts')
	<script src="/js/Login/main2.js"></script>
	<script src="/js/popper.min.js"></script>
@endsection
	
