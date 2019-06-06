@extends('Plantilla.plantillaLoginAdmin')
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

	
