<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Institucion;
use App\Semana;
use DB;
use DataTables;
use App\Http\Requests\excelrequest\ExcelUploadRequest;
use App\Http\Requests\instituciones\UpdateInstitucionRequest;
use App\Http\Requests\instituciones\StoreInstitucionRequest;

class InstitucionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct(){
        $this->middleware('admin.auth:admin')->only('instituciones');

     }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInstitucionRequest $request)
    {
        $nuevo_nombre = 'no_logo.png';
        
        
        $institucion = new Institucion;
        $institucion->nombre = $request->nombre;
        $institucion->id_institucion = date("Yhis");
        $institucion->direccion_web = $request->direccion_web;
        $institucion->telefono = $request->telefono;
        $institucion->ciudad = $request->ciudad;
        $institucion->calle = $request->calle;
        $institucion->numero = $request->numero;
        $institucion->colonia = $request->colonia;
        $institucion->cp =  $request->cp;
        $institucion->latitud = $request->lat;
        $institucion->longitud = $request->lng;
        $institucion->url_logo = $nuevo_nombre;
        $institucion->creado_por = 1;
        $institucion->save();


        $fechaArchivo = date("Y");
        if($request->hasFile('logo')){
            $imagenLogo = $request->file('logo');
            $nuevo_nombre = 'logo'.'_'. $institucion->id .'_'.$fechaArchivo. '.' . $imagenLogo->getClientOriginalExtension();
            //$nuevo_nombre = date("m-d-Y_h-i-s") ."_".$request->nombre . '.' . $imagenLogo->getClientOriginalExtension();
            $imagenLogo->move(public_path('img/logo'), $nuevo_nombre);
        }

        $institucion->url_logo = $nuevo_nombre;
        $institucion->save();

        //$userId = $request->user_id;
        /*
        $institucion   =   Institucion::updateOrCreate(['id' => $userId],
                    ['nombre' => $request->nombre, 
                    'direccion_web' => $request->direccion_web,
                    'telefono' => $request->telefono, 
                    'ciudad' => $request->ciudad, 
                    'calle' => $request->calle, 
                    'numero' => $request->numero, 
                    'colonia' => $request->colonia, 
                    'cp' => $request->cp,
                    'latitud' => $request->lat,
                    'longitud' => $request->lng,
                    'url_logo'=> $nuevo_nombre ]);
                    */
        return \Response::json($institucion);
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
        $institucion  = Institucion::where('id', $id)->first();
        return \Response::json($institucion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateInstitucionRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInstitucionRequest $request, $id)
    {
        $institucion  = Institucion::where('id', $id)->first();

        $nuevo_nombre = 'no_logo.png';
        $fechaArchivo = date("Y");

        if($request->hasFile('logo')){
            $imagenLogo = $request->file('logo');
            $nuevo_nombre = 'logo'.'_'. $institucion->id .'_'.$fechaArchivo. '.' . $imagenLogo->getClientOriginalExtension();
            //$nuevo_nombre = 'logo'.'_'. $fechaArchivo. '.' . $imagenLogo->getClientOriginalExtension();
            //$nuevo_nombre = date("m-d-Y_h-i-s") ."_".$request->nombre . '.' . $imagenLogo->getClientOriginalExtension();
            $imagenLogo->move(public_path('img/logo'), $nuevo_nombre);
        }else{
            $nuevo_nombre = $institucion->url_logo;
        }

        $institucion->nombre = $request->nombre;
        $institucion->direccion_web = $request->direccion_web;
        $institucion->telefono = $request->telefono;
        $institucion->ciudad = $request->ciudad;
        $institucion->calle = $request->calle;
        $institucion->numero = $request->numero;
        $institucion->colonia = $request->colonia;
        $institucion->cp = $request->cp;
        $institucion->latitud = $request->lat;
        $institucion->longitud=  $request->lng;
        $institucion->url_logo= $nuevo_nombre;
        
        $institucion->save();
   
        
        return \Response::json($institucion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $institucion = Institucion::where('id',$id)->delete();
        return \Response::json($institucion);
    }

    /**
     * reactiva el recurso especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reactivar($id)
    {
        $institucion = Institucion::withTrashed()->where('id',$id)->restore();
        return \Response::json($institucion);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function instituciones(){
        $semana = Semana::select('id_semana','nombre','url_logo')->where('vigente',1)->first();
        return view('admin.instituciones.adminInstituciones',compact(['semana']));
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listInstituciones(Request $request ){
        $busqueda = $request->busqueda;
        if($busqueda == 'activos'){
            $selectinstituciones = Institucion::select('id','nombre','direccion_web','telefono','calle','colonia','numero','cp','latitud','longitud','fecha_actualizacion');
            /*
            return datatables()->of($selectinstituciones)
            ->addColumn('direccion', function($Dir){
                    return $Dir->calle.' #'.$Dir->numero.', col. '.$Dir->colonia.', C.P.' .$Dir->cp;
            })
            ->addColumn('action', 'institucion.acciones')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();*/
            return datatables()->of($selectinstituciones)
            ->addColumn('direccion', function($Dir){
                    return $Dir->fecha_actualizacion;
            })
            ->addColumn('action', 'admin.acciones')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
        }else if($busqueda == 'eliminados'){
            $selectinstituciones = Institucion::onlyTrashed()->get(['id','nombre','direccion_web','telefono','calle','colonia','numero','cp','latitud','longitud','fecha_actualizacion']);
            /*
            return datatables()->of($selectinstituciones)
            ->addColumn('direccion', function($Dir){
                    return $Dir->calle.' #'.$Dir->numero.', col. '.$Dir->colonia.', C.P.' .$Dir->cp;
            })
            ->addColumn('action', 'institucion.reactivar')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();   
            */
            return datatables()->of($selectinstituciones)
            ->addColumn('direccion', function($Dir){
                    return $Dir->fecha_actualizacion;
            })
            ->addColumn('action', 'admin.reactivar')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();   
        }
    }
}