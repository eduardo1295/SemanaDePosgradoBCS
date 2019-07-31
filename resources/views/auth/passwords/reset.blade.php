@extends('Plantilla.plantillaLogin')
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
        border-radius: 0;
    }

    .card-header:first-child {
        border-radius: 0;
    }

</style>
@endsection
@section('contenido')
<div class="container" style="width: 100%;  height: 300px ;">
    <div class="d-flex row justify-content-center align-items-center align-items-center " style="height:550px">
        <div class="col-md-8">
            <div class="card" style="background: white; color: white;opacity: 0.9">
                <div class="card-header text-center pt-3" style="background: #777777;color: white;">
                    <h4>{{ __('Reset Password') }}</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right"
                                style="color:black"><strong>{{ __('E-Mail Address') }}</strong></label>

                            <div class="col-md-6">
                                <input id="email" type="email"
                                    class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                    value="{{ $email ?? old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right"
                                style="color:black"><strong>{{ __('Password') }}</strong></label>

                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <input aria-describedby="passwordHelpBlock" id="password" type="password"
                                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        name="password" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="mostrarContra('password',this)"><span>
                                                <i class="fas fa-eye"></i>
                                            </span></button>
                                    </div>
                                    @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Su contraseña debe tener mínimo 6 caracteres, debe contener al menos 1 letra mayúscula,
                                    1 letra minúscula, 1 número y 1 carácter especial(#?!@$^&-).
                                </small>
                            </div>
                            
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right"
                                style="color:black"><strong>{{ __('Confirm Password') }}</strong></label>

                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="mostrarContra('password-confirm',this)"><span>
                                                <i class="fas fa-eye"></i>
                                            </span></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
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
<script src="{{ asset('js/admin/mostrarPassword.js') }}"></script>
<script src="{{ asset('js/Login/main2.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
@endsection
