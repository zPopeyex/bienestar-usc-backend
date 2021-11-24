<?php

use App\Http\Controllers\MateriasController;
use App\Http\Controllers\MatriculaController;
use Illuminate\Support\Facades\Route;

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

Route::resource("materias", MateriasController::class);
Route::resource("matriculas", MatriculaController::class);




/*

Route::group(['middleware' => 'cors'], function(){
    //rutes
});


*/
