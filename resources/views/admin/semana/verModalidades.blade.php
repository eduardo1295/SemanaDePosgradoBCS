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
<div class="container-fluid pl-1 pr-1 pl-md-5 pr-md-5">
    <div class="row">
        <div class="col-12">
            <h5 class="mb-4">La modalidad de participación será de acuerdo al periodo y nivel cursado como se muestra a continuación:</h5>
        </div>
        <div class="col-12">
        <table class="table">
            <thead>
            <tr>
            <th scope="col">Modalidad</th>
        <?php
        $columnas = [];
        $aux_per = array();
        $i=0;
        $bandera = true;
        foreach ($modalidades as $modalidad){
            if(isset($modalidad->niveles)){
                foreach ($modalidad->niveles as $datos) {
                    $nueva_columna = $datos->grado .' ('. $datos->periodo.')';
                    for ($x=0; $x < count($columnas) ; $x++) { 
                        if($columnas[$x] == $nueva_columna){
                            $bandera = false;
                        }
                    }
                    if($bandera){
                    echo '<th scope="col">'.$nueva_columna.'</th>';
                    array_push($columnas,$nueva_columna);
                    array_push($aux_per,[]);
                    }
                }
            }
            $i++;
        }
        $ww = 1;
        for ($x=0; $x < count($aux_per) ; $x++){
            for ($j=0; $j < count($columnas) ; $j++){
                array_push($aux_per[$x],$ww);
                $ww++;
            }
        }
        dd($aux_per);
        ?>
        </tr>
        </thead>
            <tbody>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
              </tr>
            </tbody>
        </table>
        </div>
    </div>




    @foreach ($modalidades as $mol)
            <div class="row">
                <div class="col-12">
                    <h3>{{$mol->nombre}}</h3> <hr>
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