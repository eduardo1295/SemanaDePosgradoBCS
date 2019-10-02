<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Carrusel;
use App\Semana;
use DataTables;
use App\Http\Requests\carrusel\StoreCarruselRequest;
use App\Http\Requests\carrusel\UpdateCarruselRequest;
use Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use DB;
use Carbon\Carbon;

class CarruselController extends Controller
{
    public function __construct(){
        
        $this->middleware(['admin.auth:admin','verificarcontrasena','admin.verified'])->only(['carrusel','listCarrusel']);
        $this-> middleware(['esusuario'])->only(['store','update','edit','destroy']);
     }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCarruselRequest $request)
    {
        $nuevo_nombre = 'sin imagen';
        if($request->hasFile('imagenCarrusel')){
            
            $imagencarrusel = $request->file('imagenCarrusel');
            //agregar id de usuarios a nombre
            $nuevo_nombre = date("m-d-Y_h-i-s") ."_".$request->id_carrusel . '.' . $imagencarrusel->getClientOriginalExtension();
            //$imagencarrusel->move(public_path('img/carrusel'), $nuevo_nombre);
            //$imagencarrusel->storeAs('public/img/carrusel',$nuevo_nombre);
            $imagencarrusel->move(public_path('storage/img/carrusel'), $nuevo_nombre);
        }
        $ordenActual = DB::select('SELECT MAX(orden) AS maximo from carrusel');
        
            
        $carrusel = new Carrusel;
        if($ordenActual[0]->maximo == NULL)
            $carrusel->orden = 1;
        else
            $carrusel->orden = ($ordenActual[0]->maximo)+1;
        $url = $request->link_web;
        if (strlen($request->link_web)>0 && !preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "http://" . $url;
        }
        $carrusel->link_web = $url;
        $carrusel->url_imagen = $nuevo_nombre;
        $carrusel->creado_por= 1;
        $carrusel->save();
        
        //$institucion->update($request->all());
        return \Response::json($carrusel);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!auth()->user() && !auth('admin')->user()){
            return abort(403);
        }
        $carrusel  = Carrusel::select('id','link_web','url_imagen')->where('id', $id)->first();
        return \Response::json($carrusel);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $carrusel = Carrusel::where('id',$id)->first();
        
        $rules1 = [
            'link_web' => 'nullable|max:60',
            'imagenCarrusel' => 'required|mimes:jpeg,jpg,png|max:2048',
        ];

        $rules2 = [
            'link_web' => 'nullable|max:60',
        ];
        $sinerror='verdadero';
        $nuevo_nombre = 'sin imagen';
        $imgBorrar = "sin_liga";
        if($request->hasFile('imagenCarrusel')){
            $imgBorrar = $carrusel->url_imagen;
            $validator = Validator::make($request->all(), $rules1 );
            if(!$validator->fails()){
                $imagencarrusel = $request->file('imagenCarrusel');
                $nuevo_nombre = date("m-d-Y_h-i-s") ."_".$request->id_carrusel . '.' . $imagencarrusel->getClientOriginalExtension();
                //$imagencarrusel->storeAs('public/img/carrusel',$nuevo_nombre);
                $imagencarrusel->move(public_path('storage/img/carrusel'), $nuevo_nombre);
            }else{
                $sinerror='falso';
            }
        }
        else{
            $validator = Validator::make( $request->all(), $rules2 );
            if(!$validator->fails()){
                $sinerror='verdadero';
            }else{
                $sinerror='falso';
            }
            $nuevo_nombre = $carrusel->url_imagen;
        }
        
        if ($sinerror=='verdadero') {
            
            $url = $request->link_web;
            if (strlen($request->link_web)>0 && !preg_match("~^(?:f|ht)tps?://~i", $url)) {
                $url = "http://" . $url;
            }
            $carrusel->link_web = $url;
            $carrusel->url_imagen = $nuevo_nombre;
            $carrusel->creado_por= 1;
            $carrusel->save();
            if($carrusel && $imgBorrar != "sin_liga"){
                $pathDirectorio = public_path('storage/img/carrusel').'/'.$imgBorrar;
                // if(Storage::disk('local')->exists($pathDirectorio)){
                //     Storage::delete($pathDirectorio);
                // }
                if(File::exists($pathDirectorio)){
                    File::delete($pathDirectorio);
                //Storage::delete('img\\carrusel\\'.$carrusel->url_imagen);
                }
            }
            
            return \Response::json($carrusel);
            
        }
        else{
            return \Response::json(['errors' => $validator->errors()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if($request->ajax()){
            $carrusel = Carrusel::select('id','orden','url_imagen')->where('id',$id)->first();
            $ordenActual = $carrusel->orden;
            $pathDirectorio = public_path('storage/img/carrusel').'/'.$carrusel->url_imagen;
            
            if(File::exists($pathDirectorio)){
                File::delete($pathDirectorio);
            //Storage::delete('img\\carrusel\\'.$carrusel->url_imagen);
            }
            $carrusel->forceDelete();
            if($carrusel)
                $reordenar = DB::update('UPDATE carrusel set orden = orden-1 where orden > ?', [$ordenActual]);
            return \Response::json($carrusel);
        }else{
            return abort(403);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function carrusel(){
        $semana = Semana::select('id_semana','nombre','url_logo')->where('vigente',1)->first();
        return view('admin.carrusel.adminCarrusel',compact(['semana']));   
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listCarrusel(Request $request ){
        $busqueda = $request->busqueda;
        $maximo = DB::select('SELECT MAX(orden) FROM carrusel');
        
        if($busqueda == 'activos'){
            $selectcarrusel = DB::select('SELECT id, orden, (SELECT MAX(orden) FROM carrusel) AS maximo, url_imagen, fecha_actualizacion,link_web FROM carrusel ORDER BY id desc');
            
            return datatables()->of($selectcarrusel)
            ->addColumn('orden', function($selectcarrusel){
                if($selectcarrusel->orden==$selectcarrusel->maximo && $selectcarrusel->orden>1)
                    return "$selectcarrusel->orden<button data-id='$selectcarrusel->id' style='border:none;color:green' class='btn subir'><i class='fas fa-sort-up'></i></button>";
                else if ($selectcarrusel->orden==1 && $selectcarrusel->maximo>1)
                    return "$selectcarrusel->orden<button data-id='$selectcarrusel->id' style='border:none;color:green' class='btn bajar'><i class='fas fa-sort-down'></i></button>";
                else if($selectcarrusel->orden>1 && $selectcarrusel->maximo>1)
                    return "$selectcarrusel->orden<button data-id='$selectcarrusel->id' style='padding:5px;border:none;color:green' class='btn subir'><i class='fas fa-sort-up'></i></button>
                                                  <button data-id='$selectcarrusel->id' style='padding:5px;border:none;color:green' class='btn bajar'><i class='fas fa-sort-down'></i></button>";
                else
                    return "$selectcarrusel->orden";
            })
            ->addColumn('action', 'admin.acciones')
            ->rawColumns(['action','orden'])
            ->addIndexColumn()
            ->toJson();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ordenarBajar($id){
        $sliderActual = DB::select('SELECT id, orden from carrusel where id = ?', [$id]);
        $sliderMover = DB::select('SELECT id from carrusel where orden = ?', [$sliderActual[0]->orden+1]);
        $saO = $sliderActual[0]->orden;
        $fecha= Carbon::now();
        $actualizar = DB::update("UPDATE carrusel set fecha_actualizacion =  '$fecha', orden = $saO where id = ?", [$sliderMover[0]->id]);
        $fecha= Carbon::now();
        $actualizarActual = DB::update("UPDATE carrusel set fecha_actualizacion =  '$fecha', orden = $saO+1 where id = ?", [$sliderActual[0]->id]);
        return \Response::json($actualizarActual);
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ordenarSubir($id){
        
        $sliderActual = DB::select('SELECT id, orden from carrusel where id = ?', [$id]);
        $sliderMover = DB::select('SELECT id from carrusel where orden = ?', [$sliderActual[0]->orden-1]);
        $saO = $sliderActual[0]->orden;
        $fecha= Carbon::now();
        $actualizar = DB::update("UPDATE carrusel set fecha_actualizacion =  '$fecha',orden = $saO where id = ?", [$sliderMover[0]->id]);
        $fecha= Carbon::now();
        $actualizarActual = DB::update("UPDATE carrusel set fecha_actualizacion = '$fecha', orden = $saO-1 where id = ?", [$sliderActual[0]->id]);
        return \Response::json($actualizarActual);
    }

}
