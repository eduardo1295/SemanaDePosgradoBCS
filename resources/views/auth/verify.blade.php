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
                <div class="card-header text-center pt-3" style="background: #777777;color: white;" ><h4>{{ __('Verify Your Email Address') }}</h4></div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif
                    <div style="color:black">
                        {{ 'Antes de continuarAntes de continuar, por favor, confirme su correo electrónico.' }}
                    </div>
                    <div style="color:black">
                        <a href="{{ route('verification.resend') }}">{{ 'Haga clic aquí para solicitar un correo electrónico de confirmación.' }}</a>.
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                                <button class="btn btn-primary" type="button"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">Cerrar Sesión
                                    <span>
                                        <i class="fas fa-sign-out-alt"></i>
                                    </span></button>
                           
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
</form>
@endsection
