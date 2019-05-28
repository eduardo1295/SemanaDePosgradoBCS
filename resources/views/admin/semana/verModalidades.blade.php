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
        //use Illuminate\Support\Arr;
        $columnas = [];
        $aux_per = array();
        $i=0;
        $bandera = true;
        foreach ($modalidades as $modalidad){
            if(isset($modalidad->niveles)){
                foreach ($modalidad->niveles as $datos) {
                    $nueva_columna = $datos->grado .' ('. $datos->periodo.')';
                    //echo $nueva_columna.'+';
                    $bandera = true;
                    for ($x=0; $x < count($columnas) ; $x++) { 
                        if($columnas[$x] == $nueva_columna){
                            $bandera = false;
                        }
                    }
                    if($bandera){
                    echo '<th scope="col" class="text-center">'.$nueva_columna.'</th>';
                    array_push($columnas,$nueva_columna);
                    }
                }
                $bandera = true;
                //$datata =array( 'holo' => [] );
                array_push($aux_per, []);
            }
            $i++;
        }
        for ($x=0; $x < $i ; $x++){
            for ($j=0; $j < count($columnas) ; $j++){
                array_push($aux_per[$x],"<td></td>");
            }
        }
        echo '</tr></thead><tbody>';
        $j=0;
        $nombreModalidaddes = [];
        foreach ($modalidades as $modalidad) {
            array_push($nombreModalidaddes,$modalidad->nombre);
            foreach ($modalidad->niveles as $datos) {
                $nombre = $datos->grado .' ('. $datos->periodo.')';
                //dd($columnas);
                for ($i=0; $i < count($columnas) ; $i++) { 
                    if($columnas[$i] == $nombre){
                        $aa = App\posgrado::find($datos->id)->periodos()->get();
                        $aux_per[$j][$i] = '<td class="text-center">'.$aa[0]->periodo_min. ' a '.$aa[0]->periodo_max.'</td>' ;
                    }
                }
            }
            $j++;
        }
        for ($i=0; $i < count($aux_per) ; $i++) { 
            echo '<tr>';
            echo '<th scope="row">'.$nombreModalidaddes[$i].'</th>';
            for ($x=0; $x < count($aux_per[$i]) ; $x++) { 
                echo $aux_per[$i][$x];
            }
            echo '</tr>';
        }
        ?>
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