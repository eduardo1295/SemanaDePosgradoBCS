@extends('Plantilla.principal')
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
                <div class="card-header text-center pt-3" style="background: #777777;color: white;" ><h4>{{ __('Verify Your Email Address') }}</h4></div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{__('A fresh verification link has been sent to your email address.')}}
                        </div>
                    @endif
                    <div style="color:black">
                        {{__('Before proceeding, please check your email for a verification link.')}}
                    </div>
                    <div style="color:black">
                        {{__('If you did not receive the email')}}, <a href="{{ route('admin.verification.resend') }}">{{__('click here to request another')}}</a>.
                    </div>
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
	
