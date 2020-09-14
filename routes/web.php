<?php

use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', 'DashboardController@dash')->name('dashboard');

Route::get('/commandes/{id}/statut', 'CommandeController@changeStatut')->name('commandeStatut');

Route::patch('/commandes/{id}/statut', 'CommandeController@statutAdmin')->name('statut.admin');

Route::get('pdf/{id}','CommandeController@gen')->name('pdf.gen');

Route::resource('/commandes','CommandeController');

Route::get('/profil', 'ProfilController@index')->name('profil.index');

Route::match(['put', 'patch'],'/profil/{user}', 'ProfilController@update')->name('profil.update');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:manage-users')->group(function(){
    Route::resource('/users','UsersController',['except' => ['show','create','store']]);


});






