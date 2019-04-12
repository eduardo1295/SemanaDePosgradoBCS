@extends('layoutsM1.principal')

@section('links')

    <link rel="stylesheet" href="/css/Login/main2.css">
	<link rel="stylesheet" href="/css/Login/util2.css">
	<script src='https://www.google.com/recaptcha/api.js'></script>

	<style>
	body{
		background: #666666
	}
	</style>
@endsection


@section('contenido')
	<div class="container">
		<div class="row d-flex justify-content-start  flex-wrap">
			
			<form method="POST"  action="/login/admin" class="login100-form col-10 offset-1 col-sm-8 offset-sm-2 col-md-6 offset-md-3  validate-form align-self-center
						 pr-3 pl-2  pr-sm-5 pl-sm-5 pb-5 pt-5 mt-5 mb-5">
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
@endsection
	
@section('scripts')
	<script src="/js/Login/main2.js"></script>
	<script src="/js/popper.min.js"></script>
@endsection
	
