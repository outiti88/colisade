<?php

use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;



Route::get('/', 'DashboardController@dash')->name('dashboard');

Route::get('/commandes/{id}/statut', 'CommandeController@changeStatut')->name('commandeStatut');

Route::patch('/commandes/{id}/statut', 'CommandeController@statutAdmin')->name('statut.admin');

Route::get('pdf/{id}','CommandeController@gen')->name('pdf.gen');

Route::get('/search', 'CommandeController@search')->name('commande.search');

Route::get('/commandes/filter', 'CommandeController@filter')->name('commande.filter');

Route::resource('/commandes','CommandeController')->except([
    'create', 'edit'
]);

Route::get('/profil', 'ProfilController@index')->name('profil.index');

Route::match(['put', 'patch'],'/profil/{user}', 'ProfilController@update')->name('profil.update');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/bonlivraison','BonLivraisonController')->only([
    'index', 'store'
]);

Route::get('/bonlivraison/{id}/pdf','BonLivraisonController@gen')->name('bon.gen');;

Route::resource('/facture','FactureController')->only([
    'index', 'store'
]);

Route::get('/facture/{id}/pdf','FactureController@gen')->name('facture.gen');;

Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:manage-users')->group(function(){
    Route::resource('/users','UsersController',['except' => ['show','create','store']]);

});