@extends('layoutsM1.principal')
@section('links')
	<style>
	body{ background-image: url('/img/nature.jpg'); background-position: center center; background-repeat: no-repeat; background-attachment: fixed; background-size: cover; }
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
	</style>
@endsection
@section('contenido')
<div class="container" style="width: 100%;  height: 300px ;">
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

                    <form method="POST" action="{{ route('password.email') }}"aria-label="{{ __('Reset Password') }}">
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
	<script src="/js/Login/main2.js"></script>
	<script src="/js/popper.min.js"></script>
@endsection