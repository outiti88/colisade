<?php

namespace App\Http\Controllers;

use App\Commande;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCommande;


class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $commandes = Commande::all();
        return view('commande.colis',['commandes' => $commandes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommande $request)
    {


        $commande = new Commande() ;
        $commande->telephone = $request->telephone;
        $commande->ville = $request->ville;
        $commande->adresse = $request->adresse;
        $commande->montant = $request->montant;
        $commande->prix = 17 ;
        $commande->statut = "expidié";
        $commande->colis = $request->colis;
        $commande->poids = $request->poids;
        $commande->nom = $request->nom;
        $commande->numero = "dkt-".date("mdis");

        $commande->save();

        $request->session()->flash('statut', $commande->id);

        return redirect('/commandes');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function show(Commande $commande)
    {
        //return $commande;
        return view('commande.show', ['commande'=>$commande]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function edit(Commande $commande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCommande $request, Commande $commande)
    {
        $commande->telephone = $request->telephone;
        $commande->ville = $request->ville;
        $commande->adresse = $request->adresse;
        $commande->montant = $request->montant;
        $commande->prix = 17 ;
        $commande->colis = $request->colis;
        $commande->poids = $request->poids;
        $commande->nom = $request->nom;

        $commande->save();

        $request->session()->flash('statut', 'modifié');

        return redirect()->route('commandes.show',['commande' => $commande->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Commande $commande)
    {
        $numero = $commande->numero;
        \App\Commande::destroy($commande->id);
        $request->session()->flash('delete', $numero);

        return redirect('/commandes');
    }
}
