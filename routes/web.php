<?php

use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;



Route::get('/', 'DashboardController@dash')->name('dashboard');

Route::get('/commandes/{id}/statut', 'CommandeController@changeStatut')->name('commandeStatut')->middleware('can:valide');

Route::patch('/commandes/{id}/statut', 'CommandeController@statutAdmin')->name('statut.admin')->middleware('can:valide');

Route::get('/commandes/{id}/valide', 'CommandeController@retourStock')->name('commande.valideRetour')->middleware('can:edit-users');


Route::get('pdf/{id}/A6','CommandeController@gen')->name('pdf.gen')->middleware('can:valide');

Route::get('pdf/{id}/A8','CommandeController@genA8')->name('pdf.genA8')->middleware('can:valide');


Route::get('/search', 'CommandeController@search')->name('commande.search')->middleware('can:valide');

Route::get('/commandes/filter', 'CommandeController@filter')->name('commande.filter')->middleware('can:valide');

Route::get('/receptions/filter', 'ReceptionController@filter')->name('reception.filter')->middleware('can:gestion-stock');

Route::get('/stock/filter', 'ProduitController@filter')->name('stock.filter')->middleware('can:gestion-stock');



Route::post('/commandes/{id}/relance', 'RelanceController@relancer')->name('relance.relancer')->middleware('can:ramassage-commande');

Route::get('/user/new', 'Auth\RegisterController@nouveau')->name('user.nouveau');

Route::resource('/commandes','CommandeController')->except([
    'create', 'edit'
])->middleware('can:valide');

Route::resource('/ville','VilleController')->middleware('can:manage-users');

Route::resource('/produit','ProduitController')->except([
    'create', 'edit'
])->middleware('can:gestion-stock');

Route::resource('/reception','ReceptionController')->except([
    'create', 'edit'
])->middleware('can:gestion-stock');

Route::get('/reception/{id}/valide','ReceptionController@valide')->name('reception.valide')->middleware('can:manage-users');

Route::get('showFromNotify/{commande}/{notification}' , 'CommandeController@showFromNotify')->name('commandes.showFromNotify')->middleware('can:valide');

Route::get('showFromNotify/{reception}/{notification}' , 'ReceptionController@showFromNotify')->name('reception.showFromNotify')->middleware('can:valide');


Route::get('/profil', 'ProfilController@index')->name('profil.index')->middleware('can:valide');

Route::match(['put', 'patch'],'/profil/{user}', 'ProfilController@update')->name('profil.update')->middleware('can:valide');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/bonlivraison','BonLivraisonController')->only([
    'index', 'store'
])->middleware('can:client-admin');

Route::resource('/Relance','RelanceController')->only([
    'index', 'edit'
])->middleware('can:manage-users');

Route::get('/bonlivraison/{id}/infos','BonLivraisonController@infos')->name('bon.infos')->middleware('can:client-admin');

Route::get('/bonlivraison/{id}/pdf','BonLivraisonController@gen')->name('bon.gen')->middleware('can:client-admin');

Route::get('/bonlivraison/{id}/details','BonLivraisonController@search')->name('bon.search')->middleware('can:client-admin');

Route::resource('/facture','FactureController')->only([
    'index', 'store'
])->middleware('can:delete-commande');

Route::get('/facture/{id}/pdf','FactureController@gen')->name('facture.gen')->middleware('can:delete-commande');

Route::get('/facture/{id}/details','FactureController@search')->name('facture.search')->middleware('can:delete-commande');

Route::get('/facture/{id}/infos','FactureController@infos')->name('facture.infos')->middleware('can:delete-commande');

Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:manage-users')->group(function(){
    Route::resource('/users','UsersController',['except' => ['show','create','store']])->middleware('can:valide');
});

Route::get('/facture/{id}/send','EmailController@sendFacture')->name('email.facture')->middleware('can:manage-users');

Route::get('/inbox','NotificationController@index')->name('inbox.index')->middleware('can:valide');
Route::get('/{notifications}/show','NotificationController@show')->name('inbox.show')->middleware('can:valide');
Route::get('/{notifications}/delete','NotificationController@destroy')->name('inbox.destroy')->middleware('can:valide');

