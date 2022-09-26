<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GestionController;
use App\Http\Controllers\CommandesController;
use App\Http\Controllers\Auth\AuthController;

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

Route::get('/', [Controller::class, 'index'])->name('home');

Route::namespace('App\Http\Controllers\Auth')->group(function () {
    Route::get('/connexion','AuthController@connexion')->name('login');
    Route::post('/connexion','AuthController@process_connexion');
    Route::get('/inscription','AuthController@inscription')->name('inscription');
    Route::post('/inscription','AuthController@process_inscription');
    Route::get('/deconnexion','AuthController@deconnexion')->name('deconnexion');
});

Route::get('/modifierprofil', [Controller::class, 'modifierprofil'])->name('modifierprofil')->middleware('auth');
Route::post('/modifierprofil', [Controller::class, 'process_modifierprofil'])->middleware('auth');

Route::get('/commandes', [CommandesController::class, 'commandes'])->name('commandes')->middleware('auth');
Route::get('/voircommande/{id}', [CommandesController::class, 'voircommande'])->name('voircommande')->middleware('auth');
Route::get('/majcommande/{id}', [CommandesController::class, 'majcommande'])->name('majcommande')->middleware('auth');

Route::get('/gestionpizzas', [GestionController::class, 'gestionpizzas'])->name('gestionpizzas')->middleware('auth');
Route::get('/ajouterpizza', [GestionController::class, 'ajouterpizza'])->name('ajouterpizza')->middleware('auth');
Route::post('/ajouterpizza', [GestionController::class, 'process_ajouterpizza'])->middleware('auth');
Route::get('/modifierpizza/{id}', [GestionController::class, 'modifierpizza'])->name('modifierpizza')->middleware('auth');
Route::post('/modifierpizza/{id}', [GestionController::class, 'process_modifierpizza'])->middleware('auth');

Route::get('/gestionutilisateurs', [GestionController::class, 'gestionutilisateurs'])->name('gestionutilisateurs')->middleware('auth');
Route::get('/modifierutilisateur/{id}', [GestionController::class, 'modifierutilisateur'])->name('modifierutilisateur')->middleware('auth');
Route::post('/modifierutilisateur/{id}', [GestionController::class, 'process_modifierutilisateur'])->middleware('auth');
Route::get('/supprimerutilisateur/{id}', [GestionController::class, 'supprimerutilisateur'])->name('supprimerutilisateur')->middleware('auth');