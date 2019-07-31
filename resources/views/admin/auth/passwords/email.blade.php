@extends('Plantilla.plantillaLoginAdmin')
@section('links')
	<style>
    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 0;
        border-radius:0;
    }
    .card-header:first-child {
     border-radius:0;
    }
    .alert-warning{
        position: fixed;
        top: 30%;
        left: 50%;
        margin-left: -350px;
        /* margin: 0 auto; */
        width: 700px;
        z-index: 9999;
    }
	</style>
@endsection
@section('contenido')
<div class="container" style="width: 100%;  height: 300px ;">
    @if (session('status'))
                        <div class="alert alert-warning pb-3 text-justify alert-dismissible fade show" role="alert">
                            <h3 class="alert-heading">¡Aviso importante!</h3>
                            <strong>
                                ¡Te hemos enviado por correo el enlace para restablecer tu contraseña con una duración de 60 minutos!, después del plazo tendrá que volver a solicitar otro enlace para restablecer su contraseña.
                            </strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
    @endif
    <div class="d-flex row justify-content-center align-items-center align-items-center " style="height:550px">
        <div class="col-md-8">
            <div class="card" style="background: white; color: white;opacity: 0.9">
                <div class="card-header text-center pt-3" style="background: #777777;color: white;" ><h4>{{ __('Reset Password') }}</h4></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        
                    @endif

                    <form method="POST" action="{{ route('admin.password.email') }}" aria-label="{{ __('Reset Password') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right" style="color:black"><strong>{{ __('E-Mail Address') }}</strong></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
	<script src="{{ asset('js/Login/main2.js') }}"></script>
	<script src="{{ asset('js/popper.min.js') }}"></script>
@endsection
	
