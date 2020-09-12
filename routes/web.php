<?php

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

Route::get('/', 'DashboardController@dash')->name('dashboard');
//Route::get('/colis', 'CommandeController@index')->name('colis');



Route::get('/commandes/{id}/statut', 'CommandeController@changeStatut')->name('commandeStatut');

Route::patch('/commandes/{id}/statut', 'CommandeController@statutAdmin')->name('statut.admin');

Route::get('pdf/{id}','CommandeController@gen')->name('pdf.gen');


Route::resource('/commandes','CommandeController');


Route::get('/login', function () {
    return view('login/login');
});


Route::get('/profil', function () {
    return view(' profil');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
