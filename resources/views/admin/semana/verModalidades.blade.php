{{-- SECCION BLADE--}}
@extends('layoutsM1.principal')

@section('contenido')
@section('links')
<link rel="stylesheet" href="{{ mix('css/Maqueta2.css')}} ">
<script src="/js/owl.carousel.min.js"> </script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@endsection
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 id="Titulo" class="display-5  font-weight-bold rounded p-auto pt-3">Modalidades</h1> <br>
        </div>
        <div class="col-12">
            <h5 class="mb-4">La modalidad de participación será de acuerdo al periodo y nivel cursado como se muestra a continuación:</h5>
        </div>
        <div class="col-12">
        <div class="table-responsive">
            <table class="table table-striped">
            <thead>
            <tr>
            <th scope="col">Modalidad</th>
            {!!$tabla!!}
            {{-- Aqui iba el codigo php --}}
       
        
            </table>
        </div>
        </div>
        <div class="col-12">
             <p>La información proporcionada en cada una de las modalidades es responsabilidad de los autores 
                y podrá ser utilizada para los fines académicos correspondientes y su distribución en línea.</p>
            Los criterios de participación de cada modalidad son.
        </div>

    </div>




    @foreach ($modalidades as $mol)
            <div class="row" >
                <div class="col-12 text-justify">
                    <h3 class="border-bottom-info"><strong class="text-info" id="{{$mol->nombre}}"> {{$mol->nombre}} </strong></h3> 
                    {!! $mol->descripcion !!}
                </div>
            </div>
    @endforeach
</div>
    
    
        
        


        
    </div> 

@section('menu')
@include('layoutsM2.navbar')
@endsection
@section('footer')
@include('layoutsM2.footer')
@endsection
{{-- END SECCION BLADE--}}

@section('scripts')
<script src="/js/menumaker.js"></script>
@endsection
@endsection