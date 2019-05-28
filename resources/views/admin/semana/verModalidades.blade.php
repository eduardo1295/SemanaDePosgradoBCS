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
                    else {

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
                array_push($aux_per[$x],0);
                
            }
        }
        echo '</tr></thead><tbody>';
        //$array = Arr::add(['name' => 'Desk'], 'price', 100);
        //$array = Arr::prepend($array,'aa',50);
        //dd($columnas);
        $bandera10 = false;
        $columnaEncontrada = 0;
        $columnaFaltantes = 0;
        //dd($columnas);
        foreach ($modalidades as $modalidad){
            echo '<th scope="row">'.$modalidad->nombre.'</th>';
            foreach ($modalidad->niveles as $datos) {
                $nombre = $datos->grado .' ('. $datos->periodo.')';
                //echo $nombre;
                $bx =  $columnaFaltantes;
                
                while ($bx < count($columnas)) {
                    if($nombre == $columnas[$bx]){
                        //echo $bandera10 = $ax;
                        //$aa = App\posgrado::find($a[0]->niveles[0]->id)->periodos()->get();
                        $aa = App\posgrado::find($datos->id)->periodos()->get();
                        echo '<td class="text-center">'.$aa[0]->periodo_min. ' a '.$aa[0]->periodo_max.'</td>';
                        $columnaEncontrada++;
                        $columnaFaltantes++;
                        break;
                    }
                    else{
                        echo '<td></td>';
                        $columnaFaltantes++;
                    }
                    $bx++;
                }
            }
            //echo 'aqui'.$columnaEncontrada.'aca'.count($columnas);
            if($columnaFaltantes != count($columnas)){
                while ($columnaFaltantes < count($columnas)) {
                    echo '<td></td>';
                    $columnaFaltantes++;
                }
            }
            $columnaEncontrada = 0;
            $columnaFaltantes=0;
            echo '</tr>';
        }
        
        ?>
        </tbody>
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