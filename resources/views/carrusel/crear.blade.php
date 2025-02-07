@extends('admin.plantilla')

@section('contenido')
<a href="{{route('programa.VerPrograma')}}" data-original-title="Atras" style="height:40px" class="btn btn-xs btn-info">
        <span><i class="fas fa-arrow-left"></i>
        </span>Atras</a>
<h1>Nuevo slider</h1>
@if (session()->has('info'))
<div class="alert alert-success alert-dismissible" role="alert">
    {{session('info')}}
</div>

@endif
<div class="container mb-5">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <form method="POST" action="{{route('progrma.store')}}" enctype="multipart/form-data">
                    @include('programa.form',['programa' => new App\programa])
                </form>
            </div>
    
        </div>
    </div>
@endsection