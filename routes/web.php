<?php

/*
|--------------------------------------------------------------------------
| Web Routes aaaaaaaa
|--------------------------------------------------------------------------
|
| is where you can register web routes for your application. These
| routes are loaaaaqwqeqweaaaaaaaaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
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

// Contraseña primer cambio
Route::get('/usuario/contrasena', 'UserController@cambiarContrasena')->name('usuario.contrasena');
Route::post('/usuario/contrasenaGuardar', 'UserController@guardarContrasena')->name('usuario.guardarContrasena');

Route::post('usuario/editarPerfil/{id}', 'UserController@editarPerfil')->name('usuario.editarPerfil');

Route::resource('usuario', 'UserController')->middleware('auth:admin');

Route::get('admin/instituciones', 'InstitucionController@instituciones')->name('institucion.VerInstituciones');
Route::get('admin/institucion/listInstituciones', 'InstitucionController@listInstituciones')->name('institucion.listInstituciones');
Route::put('admin/institucion/reactivar/{institucion}', 'InstitucionController@reactivar')->name('institucion.reactivar');
Route::post('admin/institucion/suibirLogoConacyt', 'InstitucionController@suibirLogoConacyt')->name('institucion.suibirLogoConacyt');

Route::resource('institucion', 'InstitucionController')->except(['create','show']);

Route::post('noticias/vistaPrevia', 'NoticiaController@vistaPrevia')->name('noticia.vistaPrevia');
Route::get('admin/noticias', 'NoticiaController@noticias')->name('noticia.VerNoticias');
Route::get('admin/noticia/listNoticias', 'NoticiaController@listNoticias')->name('noticia.listNoticias');
Route::get('noticia/fetch_data', 'NoticiaController@fetch_data');
Route::put('admin/noticias/reactivar/{noticia}', 'NoticiaController@reactivar')->name('noticia.reactivar');
Route::resource('noticias', 'NoticiaController')->except(['create']);



Route::post('semanas/vistaPrevia', 'SemanaController@vistaPrevia')->name('semana.vistaPrevia');
Route::get('admin/semana/listSemanas', 'SemanaController@listSemanas')->name('semana.listSemanas');
Route::get('/convocatoria', 'SemanaController@verConvocatoria')->name('semana.verConvocatoria');

//Route::get('/admin', 'SemanaController@indexAdmin')->name('admin.indexadmin');


Route::get('/', 'SemanaController@index')->name('pag.inicio');
Route::get('/home', 'SemanaController@index');
Route::resource('semana', 'SemanaController')->except(['create','show']);


Route::get('admin/carruselImagenes', 'CarruselController@carrusel')->name('carrusel.VerCarrusel');
Route::get('carrusel/listCarrusel', 'CarruselController@listCarrusel')->name('carrusel.listCarrusel');
Route::put('admin/carrusel/reactivar/{carrusel}', 'CarruselController@reactivar')->name('carrusel.reactivar');
Route::resource('carrusel', 'CarruselController')->except(['create','show']);

Route::get('admin/coordinadores', 'CoordinadorController@coordinador')->name('coordinador.VerCoodinadores');
Route::get('coordinador/listCoordinador', 'CoordinadorController@listCoordinador')->name('coordinador.listCoordinador');
Route::put('admin/coordinador/reactivar/{coordinador}', 'CoordinadorController@reactivar')->name('coordinador.reactivar');

Route::resource('coordinador', 'CoordinadorController')->except(['show','create']);


Route::get('admin/directores', 'DirectorController@director')->name('director.VerDirectores');
Route::get('director/listDirector', 'DirectorController@listDirector')->name('director.listDirector');
Route::put('director/reactivar/{director}', 'DirectorController@reactivar')->name('director.reactivar');
Route::get('director/verAlumnos', 'DirectorController@revisarAlumnos')->name('director.revisarAlumnos');
Route::get('director/listAlumnos', 'DirectorController@listAlumnos')->name('director.listAlumnos');
/*Listo */
Route::resource('director', 'DirectorController')->except(['show','create']);


Route::get('admin/alumnos', 'AlumnoController@alumnos')->name('alumnos.VerAlumnos');
Route::get('alumno/listAlumnos', 'AlumnoController@listAlumnos')->name('alumno.listAlumnos');
Route::get('alumno/exportar', 'AlumnoController@exportarXLSAlumnos')->name('alumno.exportarXLSAlumnos');
Route::put('alumno/reactivar/{alumno}', 'AlumnoController@reactivar')->name('alumno.reactivar');
Route::get('alumno/generarGafete','AlumnoController@generarGafete')->name('alumno.generarGafete');
Route::get('alumno/programasLista/{programa}', 'AlumnoController@programasLista')->name('alumno.programasLista');

/*Listo */
Route::get('/alumno/ExportarAlumnos', 'AlumnoController@ExportarAlumnos')->name('alumno.ExportarAlumnos');
Route::post('/alumno/ImportarAlumnos', 'AlumnoController@ImportarAlumnos')->name('alumno.importar');

Route::resource('alumno', 'AlumnoController')->except(['show','create']);

Auth::routes(['verify' => true]);



Route::get('admin/programas', 'ProgramaController@programa')->name('programa.VerPrograma');
Route::get('programa/listPrograma', 'ProgramaController@listPrograma')->name('programa.listPrograma');
Route::put('programa/reactivar/{programa}', 'ProgramaController@reactivar')->name('programa.reactivar');
Route::get('programa/programaGeneral', 'ProgramaController@programaGeneral')->name('programa.ProgramaGeneral');
Route::post('programa/subirProgramaGeneral', 'ProgramaController@subirProgramaGeneral')->name('programa.subirProgramaGeneral');
Route::get('programa/mostrarProgramaGeneral', 'ProgramaController@mostrarProgramaGeneral')->name('programa.mostrarProgramaGeneral');
/*LISTO*/

Route::resource('programa', 'ProgramaController')->except(['create']);

Route::get('admin/modalidades', 'ModalidadController@modalidad')->name('modalidad.VerModalidad');
Route::get('modalidad/listModalidad', 'ModalidadController@listModalidad')->name('modalidad.listModalidad');
Route::put('admin/modalidad/reactivar/{modalidad}', 'ModalidadController@reactivar')->name('modalidad.reactivar');
Route::get('/modalidad/mostrarModalidad/{opcion}', 'ModalidadController@mostrarModalidad')->name('modalidad.mostrarModalidad');
/*LISTO*/
Route::resource('modalidad', 'ModalidadController')->except(['create','show']);


Route::get('/sesion/verPdf/{opcion}', 'SesionController@verPdf')->name('sesion.verPdf');
//Route::get('sesion/listModalidad', 'SesionController@listModalidad')->name('sesion.listModalidad');
Route::get('admin/sesiones', 'SesionController@sesiones')->name('sesion.VerSesiones');
Route::get('sesion/listSesiones', 'SesionController@listSesiones')->name('sesion.listSesiones');
Route::post('sesion/alumnosSeleccionados/{opcion}/{idSesion}', 'SesionController@alumnosSeleccionados')->name('sesion.alumnosSeleccionados');
Route::resource('sesion', 'SesionController');

Route::get('/subirTrabajo', 'TrabajoController@subirTrabajo')->name('trabajo.subirTrabajo');
Route::post('/revisionTrabajo', 'TrabajoController@revisionTrabajo')->name('trabajo.revisionTrabajo');

/*LISTO*/
Route::resource('trabajo', 'TrabajoController')->except(['create','edit','update','destroy']);


Route::get('admin/VistaLogin', 'VistaLoginController@vistaLogin')->name('vistaLogin.VerVistaLogin');
Route::get('admin/disenoColores', 'VistaLoginController@disenoColores')->name('vistaLogin.disenoColores');
Route::post('admin/cambiarColores', 'VistaLoginController@cambiarColores')->name('vistaLogin.cambiarColores');

/*LISTO*/
Route::resource('VistaLogin', 'VistaLoginController');


Route::get('/home', 'HomeController@index')->name('home');

Route::get('admin/locacion', 'LocacionController@locacion')->name('locacion.VerLocacion');
Route::get('locacion/listLocacion', 'LocacionController@listLocacion')->name('locacion.listLocacion');
/*LISTO*/
Route::resource('locacion', 'LocacionController')->except(['create','show']);


Route::get('/prueba', function(){
    /*
    $pdf = App::make('dompdf.wrapper');
    $pdf->loadHTML('<h1>Test</h1>');
    return $pdf->stream();*/
    return view('prueba');
});
Route::get('/qr', function(){
    /*
    $pdf = App::make('dompdf.wrapper');
    $pdf->loadHTML('<h1>Test</h1>');
    return $pdf->stream();*/
    return view('qr');
});





Route::post('constancia/guardarImagenes', 'ConstanciaController@guardarImagenes')->name('constancia.guardarImagenes');
Route::post('alumno/constanciaAlta','ConstanciaController@altaConstancia');
Route::get('verConstancia','ConstanciaController@verConstancias')->name('verConstancias');
Route::get('constancia/{id}','ConstanciaController@generatePDF')->name('generarpdf');

Route::resource('constancia', 'ConstanciaController');