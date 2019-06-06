@extends('Plantilla.plantillaLoginAdmin')
@section('contenido')
	<div class="container" style="width: 100%;  height: 300px ;">
		<div class="d-flex row justify-content-center align-items-center align-items-center " style="height:550px">
			<form action="{{route('admin.login')}}" method="post" class="col-10  col-sm-10 col-md-8 col-lg-6 " style="background : white;  opacity: 0.9">
				@csrf
				<div class="row">
					<div class="col-12" style="background: #777777; color: white">
						<h4 class="text-center pt-3"><strong >Login Administrador</strong></h4>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-10 offset-1 pt-3">
							<label for="email"><strong>Correo electrónico:</strong></label>
							<input type="email" name="email" id="email" class="form-control" placeholder="Email" aria-describedby="c1" value="{{old('email')}}" required>
							<small><span class="text-danger">{{$errors->first('email')}}</span></small>
					</div>
					<div class="form-group col-9 offset-1">
							<label for="password"><strong>Contraseña:</strong></label>
							<input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" aria-describedby="c2" required>
							<small><span class="text-danger">{{$errors->first('password')}}</span></small>
					</div>
					<div class="col-1 d-flex align-items-center align-items-center">
							<span class="btn-show-pass">
								<i class="fas fa-eye"></i>
							</span>
					</div>
					<div class="form-group col-10 offset-1">
							<div class="g-recaptcha mb-3 d-flex justify-content-center" data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}">
					</div>
					<small><span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span></small> 

					<div class="col-12">
							<div class="form-check">
								<input type="checkbox" name="remember" id="remember" class="form-check-input">
								<label for="remember" class="form-check-label">Mantener la sesión iniciada</label>
							</div>
					</div>
					
					<div class="col-12 pb-3 pt-3">
							<input type="submit" value="Login" class="btn btn-primary mx-auto  w-100">
							<small id="" class="text-muted"><a href="{{route('admin.password.request')}}">Olvidé mi contraseña</a></small>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection

	
