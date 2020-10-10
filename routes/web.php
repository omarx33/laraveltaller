<?php

use Illuminate\Support\Facades\Route;
use PhpParser\Node\Stmt\Return_;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();




Route::get('/', 'HomeController@index')->name('home');


// Mantenimientos
Route::prefix('mantenimiento')->group(function () {
    Route::resource('empleados', 'EmpleadoController');
});



Route::prefix('test')->group(function () {

    Route::resource('alias', 'VistaNueva');// se asocia al nombre del controlador(VistaNueva) creado al prefijo(alias)
});


