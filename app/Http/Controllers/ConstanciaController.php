<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Constancia;
use App\Semana;
use DB;
use Image;
use PDF;
use View;
use Dompdf\Dompdf;
use DOMXPath;

class ConstanciaController extends Controller
{
    public function __construct(){
        //$this-> middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $semana = Semana::select('id_semana','nombre','url_logo')->where('vigente',1)->first();
        $semanaquery = DB::select(DB::raw('SELECT semanas.id_semana, '.
		' semanas.url_logo,vigente'.		
		' FROM semanas'.
        ' WHERE vigente = 1'));
        
        $instituciones = DB::select(DB::raw('SELECT instituciones.id, '.
		' instituciones.url_logo,nombre,siglas'.
		' FROM instituciones'.
		' WHERE '.
        ' deleted_at IS NULL ORDER BY nombre'));

        $constancia = DB::select('SELECT constancias.id, constancias.cComponentes, constancias.cHTML, constancias.cCSS, constancias.url_imagen_fondo'.
		' FROM constancias'.
        ' WHERE id_semana = ?',[$semanaquery[0]->id_semana]);


        $coordinadores = DB::select(DB::raw('SELECT CONCAT(users.nombre," ", users.primer_apellido, " ", users.segundo_apellido) AS coordinador_nombre,'.
		' coordinadores.puesto,instituciones.siglas'.
		' FROM instituciones, coordinadores, users, rol_usuario'.
		' WHERE '.
		' users.id_institucion = instituciones.id'.
		' AND rol_usuario.id_usuario = users.id'.
		' AND users.id = coordinadores.id'.
        ' AND rol_usuario.id_rol = 3;'));
        
        $imagenes = [];

        $rutaEvento =  asset('img/semanaLogo/'.$semanaquery[0]->url_logo);
        
        $etiquetaEvento = "<img style='vertical-align:top;width:130px;height:100px;' src = '".$rutaEvento."'>";
        
        
        $imagenes[] = [$etiquetaEvento,'Semana de Posgrado BCS'];
        
        /*
        $imagenes = '<div data-highlightable="1"'. 
        'class="gjs-row" style="width:100%"><div '.
        'data-highlightable="1" class="gjs-cell" style="vertical-align: top;width:100%">';
        foreach ($instituciones as $insticion){
            $ruta =  asset('img/logo/'.$insticion->url_logo);
            
            $imagenes .= '<img style="vertical-align: top;width:130px;height:100px;"src = "'.$ruta.'">';
        }
        $imagenes .= '</div></div>';
        */
        //dd($imagenes);

        foreach ($instituciones as $institucion) {
            $ruta =  asset('img/logo/'.$institucion->url_logo);
            $imagenes [] = ["<img style='vertical-align:top;width:130px;height:100px;' src = '".$ruta."'>",$institucion->siglas];
        }
        
        
        return view('constancias.diseno',compact(['imagenes','coordinadores','constancia','semana']));
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
    public function store(Request $request)
    {
        $estilos = $request->cCSS;
        $estilos = str_replace('* { box-sizing: border-box; } body {margin: 0;}body{width:100%;border:none;padding:20px;}','',$estilos);
        
        $semana = DB::select(DB::raw('SELECT semanas.id_semana,'.
		' semanas.url_logo,vigente'.
		' FROM semanas'.
        ' WHERE vigente = 1'));

        $constancia = DB::select('SELECT constancias.id'.
		' FROM constancias'.
        ' WHERE id_semana = ?',[$semana[0]->id_semana]);

        $pathDirectorio = public_path('img\\constancia');
        if(!is_dir($pathDirectorio)){
            //File::makeDirectory($pathDirectorio);
            mkdir($pathDirectorio);
            mkdir($pathDirectorio.'\\'.$semana[0]->id_semana);
        }else{
            if(!is_dir($pathDirectorio.'\\'.$semana[0]->id_semana))
                mkdir($pathDirectorio.'\\'.$semana[0]->id_semana);
        }
            
        if(count($constancia)>0){
            
            $constanciaActual = Constancia::find($constancia[0]->id);
            
            $constanciaActual->cComponentes = $request->cComponentes;
            $constanciaActual->cHTML = $request->cHTML;
            $constanciaActual->cCSS = $estilos;

            $rutaFondo = $constanciaActual->url_imagen_fondo;
            if($request->hasFile('fondo')){
                $imagenFondo = $request->file('fondo');
                $nuevo_nombre = 'fondo_' . $semana[0]->id_semana . '.' . $imagenFondo->getClientOriginalExtension();
                $imagenFondo->move(public_path('img\constancia\\'.$semana[0]->id_semana), $nuevo_nombre);
                $rutaFondo =  asset('img/constancia/'.$semana[0]->id_semana.'/'.$nuevo_nombre);
                
                //$constanciaActual->url_imagen_fondo = $$rutaFondo;
            }
            $constanciaActual->url_imagen_fondo = $rutaFondo;
            $constanciaActual->save();
            return \Response::json($constanciaActual);
        }else{
            $rutaFondo ="";
            if($request->hasFile('fondo')){
                $imagenFondo = $request->file('fondo');
                $nuevo_nombre = 'fondo_' . $semana[0]->id_semana . '.' . $imagenFondo->getClientOriginalExtension();
                $imagenFondo->move(public_path('img\constancia\\'.$semana[0]->id_semana), $nuevo_nombre);
                $rutaFondo =  asset('img/constancia/'.$semana[0]->id_semana.'/'.$nuevo_nombre);
                //$rutaFondo = public_path('img\constancia\\'.$semana[0]->id_semana.'\\'.$nuevo_nombre);
                //$constanciaActual->url_imagen_fondo = $$rutaFondo;
            }
            $constanciaNueva = new Constancia([
                'id_semana' => $semana[0]->id_semana,
                'cComponentes' => $request->cComponentes,
                'cHTML' => $request->cHTML,
                'cCSS' => $estilos,
                'url_imagen_fondo' => $rutaFondo,
            ]);
            $constanciaNueva->save();
            return \Response::json($constanciaNueva);
        }
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function guardarImagenes(Request $request){
        $semana = DB::select(DB::raw('SELECT semanas.id_semana'.
		' FROM semanas'.
        ' WHERE vigente = 1'));
        $pathDirectorio = public_path('img\\constancia');
        if(!is_dir($pathDirectorio)){
            //File::makeDirectory($pathDirectorio);
            mkdir($pathDirectorio);
            mkdir($pathDirectorio.'\\'.$semana[0]->id_semana);
        }else{
            if(!is_dir($pathDirectorio.'\\'.$semana[0]->id_semana))
                mkdir($pathDirectorio.'\\'.$semana[0]->id_semana);
        }
        $resultArray = [];
        if($request->hasFile('files')){
            $archivos = $request->file('files');
            foreach ($archivos as $k => $img) {
                $fileName = $img->getClientOriginalName();
                $tmpName = $img->getPathName();
                $fileSize = $img->getClientSize();
                $fileType = $img->getClientOriginalExtension();
                $fp = fopen($tmpName, 'r');
             	$content = fread($fp, filesize($tmpName));
                fclose($fp);
                
                /*
                $data = $img->getattribute('src');
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                */
                /*
                $data = base64_decode($content);
                $image_name= time().'.'.$img->getClientOriginalExtension();
                $path = public_path() .'/img/constancia/'.$semana[0]->id_semana.'/'.$image_name;
                
                file_put_contents($path, $data);*/
                //$img->removeattribute('src');
                //$img->setattribute('src', $path);
    
                $image_name= time().'.'.$img->getClientOriginalExtension();
                //$image_name2= time().'asdsad.'.$img->getClientOriginalExtension();
                
                
                //$img = str_replace('data:image/png;base64,', '', $img);
                //$img = str_replace(' ', '+', $img);
                
                //\File::put(storage_path(). '/' . $image_name, base64_decode($content));
                $path = public_path() .'\\img\\constancia\\'.$semana[0]->id_semana.'\\'.$image_name;
                //$path2 = public_path() .'\\img\\constancia\\'.$semana[0]->id_semana.'\\'.$image_name2;
                //$thumb_img = Image::make($img->getRealPath())->resize(100, 100);
                //$thumb_img->save($path2,100);

                $img->move(public_path('img/constancia\\'.$semana[0]->id_semana), $image_name);
                $ruta =  asset('img/constancia/'.$semana[0]->id_semana.'/'.$image_name);
                $resultArray [] = [
                    'name'=>$image_name,
                    'type'=>'image',
                    'src'=>$ruta,
                    'height'=>100,
                    'width'=>130
                ];
            }
        }
        return \Response::json(['data' => $resultArray], 200);
    }

    public function generatePDF($id)
    {
        
        $semanaquery = DB::select("SELECT semanas.id_semana, nombre
        FROM semanas 
        WHERE id_semana = ?",[$id]);
        
        $idAlumno = auth()->user()->id;
        $constancia = DB::select("SELECT id_semana FROM alumno_constancia WHERE 
        id_alumno = ? AND id_semana = ?;",[$idAlumno, $id]);
        
        if(COUNT($constancia)>0){
            $datosConstancia = DB::select("SELECT CONCAT(users.nombre, ' ', users.primer_apellido, ' ', 
            users.segundo_apellido) AS nombre_completo, trabajos.titulo, modalidades.nombre
            FROM users, trabajos, modalidades WHERE users.id = trabajos.id_alumno AND 
            modalidades.id_modalidad = trabajos.id_modalidad AND trabajos.id_semana = ?
            AND users.id = ?",[$id, $idAlumno]);
        }else{
            return abort(403);
        }

        /*
        $semana = DB::select(DB::raw('SELECT semanas.id_semana, '.
		' semanas.url_logo,vigente,semanas.nombre'.		
		' FROM semanas'.
        ' WHERE vigente = 1'));
        */
        $constancia = DB::select('SELECT constancias.cHTML, constancias.cCSS, constancias.url_imagen_fondo'.
		' FROM constancias'.
        ' WHERE id_semana = ?',[$semanaquery[0]->id_semana]);
        $titulo = "Constancia";
        $view = View::make('constancias.constanciapdf', compact('titulo','constancia'));
        

        //$contents = (string) $view;
        
        $dom = new \domdocument();
        $dom->loadHtml($view, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        
        //$body = $dom->getElementsByTagName('body')->item(0);
        

        $xpath = new DOMXpath($dom);
        $respuesta = $xpath->query('//div[contains(@class, "participante")]'); //instance of DOMNodeList
        
        foreach ($respuesta as $encontrado) 
            $encontrado->textContent = $datosConstancia[0]->nombre_completo;
        
        $respuesta = $xpath->query('//div[contains(@class, "evento")]'); //instance of DOMNodeList
        foreach ($respuesta as $encontrado) 
            $encontrado->textContent = $semanaquery[0]->nombre;

        $respuesta = $xpath->query('//div[contains(@class, "trabajo")]'); //instance of DOMNodeList
        foreach ($respuesta as $encontrado) 
            $encontrado->textContent = $datosConstancia[0]->titulo;

            $respuesta = $xpath->query('//div[contains(@class, "modalidad")]'); //instance of DOMNodeList
            foreach ($respuesta as $encontrado) 
                $encontrado->textContent = $datosConstancia[0]->nombre;
        /*
        $images = $dom->getelementsbytagname('img');
 
        $pathDirectorio = public_path('img\\noticias').'\\'.$noticia->id_noticia;
        //dd($pathDirectorio);
        if(count($images)>0){
            if(!File::isDirectory($pathDirectorio)){
                File::makeDirectory($pathDirectorio, 0777, true, true);
            }
        }
        //loop over img elements, decode their base64 src and save them to public folder,
        //and then replace base64 src with stored image URL.
        $ultimaImagen ="";
        foreach($images as $k => $img){
            $data = $img->getattribute('src');
            $ultimaImagen = $data;
            if (substr($data, 0, 5) == 'data:') {
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
    
                $data = base64_decode($data);
                $image_name= time().$k.'.png';
                $path = public_path() .'/img/noticias/'.$noticia->id_noticia.'/'. $image_name;
    
                //$path = $pathDirectorio. '/' . $image_name;
                
                file_put_contents($path, $data);
    
                $img->removeattribute('src');
                
                //$ultimaImagen = '/img/noticias/'.$image_name;

                $img->setattribute('src', '/img/noticias/'.$noticia->id_noticia.'/'.$image_name);
                $ultimaImagen = $pathDirectorio.$image_name;
            }
        }
        if($ultimaImagen == ""){
            $ultimaImagen = '/img/noticias/logo_noticias.png';
        }
        $detail = $dom->savehtml();

        $noticia->contenido = $detail;
        $noticia->url_imagen = $ultimaImagen;
        $noticia->save();

        $data = ['title' => 'Welcome to HDTuto.com'];
        */
        $constanciaPDF = $dom->savehtml();
        
        /*
        $pdf = new Dompdf();
        $customPaper = array(0,0,792,612);
        
        $pdf->set_option('DOMPDF_ENABLE_CSS_FLOAT',true);
        $pdf = PDF::loadHTML($constancia)->setPaper($customPaper,'landscape');
  
        return $pdf->stream('itsolutionstuff.pdf');
        */
        
        $dompdf = new Dompdf();
        $dompdf->setPaper(array(0,0,612.00,792.00),'landscape');
        
        $GLOBALS['bodyHeight'] = 612;
        $GLOBALS['altura'] = 792;
        $GLOBALS['hola'] = 1;
        
        $dompdf->setCallbacks(
          array(
            'myCallbacks' => array(
              'event' => 'end_frame', 'f' => function ($infos) {
                $frame = $infos["frame"];
                if (strtolower($frame->get_node()->nodeName) === "body") {
                    
                    $padding_box = $frame->get_padding_box();
                    if($GLOBALS['hola']>1){
                        
                        $GLOBALS['bodyHeight'] += $padding_box['h']-60;
                        $GLOBALS['altura'] += $padding_box['h']-57;
                    }
                    
                    $GLOBALS['hola']+=1;
                }
              }
            )
          )
        );
        
        $dompdf->loadHtml($constanciaPDF);
        
        $dompdf->render();
        
        unset($dompdf);
        
        $dom = new \domdocument();
        $dom->loadHtml($constanciaPDF, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $head = $dom->getelementsbytagname('head');
        
        $altura = $GLOBALS['altura']+24;
        $element = $dom->createElement('style', '#watermark {height:'.$altura.'px}');
        $head[0]->appendChild($element);
        
        $constanciaFinal = $dom->savehtml();
        
        //if($GLOBALS['bodyHeight']<612)
          //  $GLOBALS['bodyHeight'] = 612;
        
        
        $pdf = new Dompdf();
        //dd($GLOBALS['bodyHeight']);
        
        $pdf= PDF::loadHtml($constanciaFinal)->setPaper(array(0,0,$GLOBALS['bodyHeight'],792.00),'landscape');
        
        //$pdf->save('myfile.pdf');
        //dd($pdf);
        return $pdf->stream('Constancia.pdf');
        
        
    }

    public function altaConstancia(Request $request){
        
        $semanaquery = DB::select(DB::raw("SELECT semanas.id_semana FROM semanas WHERE vigente = 1;"));
        $semanaVigente = $semanaquery[0]->id_semana;
        $idAlumno = $request->id_alumno;
        $constancia = DB::select("SELECT id FROM alumno_constancia WHERE 
        id_alumno = ? AND id_semana = ?;",[$idAlumno, $semanaVigente]);
        
        $resultado="";
        if(COUNT($constancia)>0){
            $id_constancia = $constancia[0]->id;
            $resultado = DB::table('alumno_constancia')->where('id', '=', $id_constancia)->delete();
        }else{
            $resultado = DB::table('alumno_constancia')->insert(
                ['id_semana' => $semanaquery[0]->id_semana, 'id_alumno' => $idAlumno]
            );
        }

        return \Response::json($resultado);
        
    }

    public function verConstancias(){
        $id = auth()->user()->id;
        $semana = Semana::select('id_semana','nombre','desc_general','url_logo','url_convocatoria','id_sede','fecha_inicio',DB::raw("(DATE_FORMAT(fecha_inicio,'%Y-%m-%d'))as n") ,'fecha_fin')->where('vigente',1)->first();
        $instituciones = DB::select(DB::raw("
        SELECT instituciones.id, instituciones.nombre, instituciones.latitud, instituciones.longitud,
		 instituciones.siglas, instituciones.telefono, instituciones.direccion_web,
		 instituciones.url_logo, instituciones.ciudad, 
		 CONCAT(instituciones.calle,' #', instituciones.numero, ', col. ', instituciones.colonia , ', C.P.', instituciones.cp) AS domicilio,
		 (SELECT CONCAT(users.nombre,' ', users.primer_apellido, ' ', users.segundo_apellido) 
		 FROM users WHERE users.id_institucion = instituciones.id AND id IN (SELECT id_usuario FROM rol_usuario WHERE id_rol= 3)) AS coordinador_nombre,
		 (SELECT email 
		 FROM users WHERE users.id_institucion = instituciones.id AND id IN (SELECT id_usuario FROM rol_usuario WHERE id_rol= 3)) AS email
         FROM instituciones WHERE deleted_at IS NULL;
         "));
        $constancias = DB::select('SELECT alumno_constancia.id_semana, semanas.nombre FROM alumno_constancia, semanas WHERE semanas.id_semana = alumno_constancia.id_semana AND alumno_constancia.id_alumno = ?;', [$id]);
        return view('alumno.constancias',compact(['semana','instituciones','constancias']));   
    }
}
