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
        
        $carrusel = new Carrusel;
        $carrusel->link_web = $request->link_web;
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
                $imagencarrusel->storeAs('public/img/carrusel',$nuevo_nombre);
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
            
            $carrusel->link_web = $request->link_web;
            $carrusel->url_imagen = $nuevo_nombre;
            $carrusel->creado_por= 1;
            $carrusel->save();
            if($carrusel && $imgBorrar != "sin_liga"){
                $pathDirectorio = storage_path('img\\carrusel').'\\'.$imgBorrar;
                if(Storage::disk('local')->exists($pathDirectorio)){
                    Storage::delete($pathDirectorio);
                }
            }
            //$institucion->update($request->all());
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
        $carrusel = Carrusel::where('id',$id)->first();

        $pathDirectorio = public_path('storage\\img\\carrusel').'\\'.$carrusel->url_imagen;
        
        if(File::exists($pathDirectorio)){
          //File::delete($pathDirectorio);
          //Storage::delete('img\\carrusel\\'.$carrusel->url_imagen);

        }
        $carrusel->forceDelete();

        return \Response::json($carrusel);
        }else{
            return abort(403);
        }
    }

    /**
     * reactiva el recurso especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reactivar(Request $request, $id)
    {
        if($request->ajax()){
        $carrusel = Carrusel::withTrashed()->where('id',$id)->restore();
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
        if($busqueda == 'activos'){
            $selectcarrusel = Carrusel::select('id','link_web','url_imagen','fecha_actualizacion');
            return datatables()->of($selectcarrusel)
            ->addColumn('action', 'admin.acciones')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
        }else if($busqueda == 'eliminados'){
            $selectcarrusel = Carrusel::onlyTrashed()->get(['id','link_web','url_imagen','fecha_actualizacion']);
            return datatables()->of($selectcarrusel)
            ->addColumn('action', 'admin.reactivar')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();   
        }
    }
}
