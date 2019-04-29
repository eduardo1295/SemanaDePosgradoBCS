<?php

/*
|--------------------------------------------------------------------------
| Web Routes aaaaaaaa
|--------------------------------------------------------------------------
|
| HOLA HOLA is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
| prueba de que se sube algo
|
*/
Route::resourceVerbs([
    'create' => 'crear',
    'edit' => 'editar',
]);
Route::view('/crearNoticia','crearNoticia');




Route::get('admin/VerUsuarios', 'UserController@usuarios')->name('admin.usuarios');
Route::get('admin/listUsuarios', 'UserController@listUsuarios')->name('admin.listUsuarios');
Route::get('excel', 'UserController@cargaExcel')->name('excel');

Route::resource('admin', 'UserController')->middleware('auth:admin');


Route::get('institucion/VerInstituciones', 'InstitucionController@instituciones')->name('institucion.VerInstituciones');
Route::get('institcucion/listUsuarios', 'InstitucionController@listInstituciones')->name('institucion.listInstituciones');
Route::put('institucion/reactivar/{institucion}', 'InstitucionController@reactivar')->name('institucion.reactivar');

Route::resource('institucion', 'InstitucionController');

Route::get('admin/noticias/VerNoticias', 'NoticiaController@noticias')->name('noticia.VerNoticias');
Route::get('noticia/listNoticias', 'NoticiaController@listNoticias')->name('noticia.listNoticias');
Route::get('noticia/fetch_data', 'NoticiaController@fetch_data');
Route::put('noticia/reactivar/{noticia}', 'NoticiaController@reactivar')->name('noticia.reactivar');
Route::resource('noticia', 'NoticiaController');
Route::resource('semana', 'SemanaController');

Route::resource('/', 'SemanaController');




Route::get('/login/admin', 'Auth\LoginController@showAdminLoginForm')->name('esta');
Route::post('/login/admin', 'Auth\LoginController@adminLogin');

Route::get('logout', 'Auth\LoginController@logout');
Auth::routes();


Route::get('admin/carrusel/VerCarrusel', 'CarruselController@carrusel')->name('carrusel.VerCarrusel');
Route::get('carrusel/listCarrusel', 'CarruselController@listCarrusel')->name('carrusel.listCarrusel');
Route::put('carrusel/reactivar/{carrusel}', 'CarruselController@reactivar')->name('carrusel.reactivar');
Route::resource('carrusel', 'CarruselController');

/*
Route::get('/',['as'=> 'home',function (){
    return view('home',compact('hola'));
}]);

Route::get('/modalidades',['as'=> 'modalidades',function (){
    return view('modalidades');
}]);

Route::get('/programa',['as'=> 'programa',function ($id){
    return view('programa');
}]);
Route::get('/convocatoria',['as'=> 'convocatoria',function (){
    return view('convocatoria');
}]);

Route::get('/acceso',['as'=> 'manage',function (){
    return view('manage',compact('hola'));
}]);

Route::get('/soporte',['as'=> 'soporte',function (){
    //return view('soporte');
}]);

Route::get('/plantilla/{id?}',['as'=> 'hola',function($id = null){
    switch ($id) {
        case 1:
            return view('formularios.trabajo');    
            break;
        case 2:
            return view('formularios.programa');
            break;
        case 3:
            return view('formularios.modalidades');
            break;
        case 4:
            return view('formularios.noticia');
            break;
        case 5:
            return view('formularios.institucion');
            break;
        case 6:
            return view('formularios.usuario');       
            break;
        default:
            return abort(404);
            break;

    }
}]);
/*
Route::get('manage', function () {
    $hola = 1;
    return view('manage',compact('hola'));
});
*/
/*
Route::view('/login','login');
Route::view('/login2','login2');
Route::view('/registro2','registro2');
Route::view('/registro','registro');
Route::view('/modal','modal');
Route::view('/noticias','noticias');
Route::view('/unaNota','UnaNoticia');

Route::get('/',['as'=> 'home',function (){ return view('Maqueta1'); }]);

Route::get('/Maqueta1',['as'=> 'home',function (){ return view('Maqueta1'); }]);

Route::get('/Maqueta2',['as'=> 'a',function (){ return view('Maqueta2'); }]);

Route::get('/Maqueta3',['as'=> 'b',function (){ return view('Maqueta3'); }]);

Route::view('/crearNoticia','crearNoticia');
*/