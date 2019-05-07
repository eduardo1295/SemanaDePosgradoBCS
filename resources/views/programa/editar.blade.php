@extends('admin.plantilla')

@section('contenido')
    <h1>Editar slider</h1>
    @if (session()->has('info'))
    <div class="alert alert-success alert-dismissible" role="alert">
            {{session('info')}}
        </div>    
    @endif
    <div class="container mb-5">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
    <form method="POST" action="{{route('programa.update',$programa->id)}}" enctype="multipart/form-data">
        {!! method_field('PUT') !!}
        @include('programa.form', ['btnText' => 'Actualizar'])
    </form>
</div>
  
</div>
</div>

@endsection