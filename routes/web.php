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

Route::resource('/produit','ProduitController')->except([
    'create', 'edit'
])->middleware('can:gestion-stock');

Route::get('showFromNotify/{commande}/{notification}' , 'CommandeController@showFromNotify')->name('commandes.showFromNotify');

Route::get('/profil', 'ProfilController@index')->name('profil.index');

Route::match(['put', 'patch'],'/profil/{user}', 'ProfilController@update')->name('profil.update');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/bonlivraison','BonLivraisonController')->only([
    'index', 'store'
]);

Route::get('/bonlivraison/{id}/infos','BonLivraisonController@infos')->name('bon.infos');

Route::get('/bonlivraison/{id}/pdf','BonLivraisonController@gen')->name('bon.gen');

Route::get('/bonlivraison/{id}/details','BonLivraisonController@search')->name('bon.search');

Route::resource('/facture','FactureController')->only([
    'index', 'store'
]);

Route::get('/facture/{id}/pdf','FactureController@gen')->name('facture.gen');

Route::get('/facture/{id}/details','FactureController@search')->name('facture.search');

Route::get('/facture/{id}/infos','FactureController@infos')->name('facture.infos');

Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:manage-users')->group(function(){
    Route::resource('/users','UsersController',['except' => ['show','create','store']]);
});

Route::get('/facture/{id}/send','EmailController@sendFacture')->name('email.facture')->middleware('can:ramassage-commande');

Route::get('/inbox','NotificationController@index')->name('inbox.index');
Route::get('/{notifications}/show','NotificationController@show')->name('inbox.show');
Route::get('/{notifications}/delete','NotificationController@destroy')->name('inbox.destroy');