<?php

namespace App\Http\Controllers;

use App\BonLivraison;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BonLivraisonController extends Controller
{
      /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = []; //tableau des clients existe dans la base de données
        $users = []; //les users qui seront affichés avec leur bon de livraison
        if(!Gate::denies('ramassage-commande')) {
            $bonLivraisons = DB::table('bon_livraisons')->orderBy('created_at', 'DESC')->get();
            $clients = User::whereHas('roles', function($q){$q->where('name','client');})->get();

        }
        else{
            $bonLivraisons = DB::table('bon_livraisons')->where('user_id',Auth::user()->id)->orderBy('created_at', 'DESC')->get();
        }

        foreach($bonLivraisons as $bonLivraison){
            if(!empty(User::find($bonLivraison->user_id)))
            $users[] =  User::find($bonLivraison->user_id) ;
        }
        $total = $bonLivraisons->count();
        //dd($users);
        return view('bonLivraison',['bonLivraisons'=>$bonLivraisons ,
                                        'total' => $total,
                                         'users'=> $users,
                                         'clients' => $clients]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Gate::denies('ramassage-commande')) {
            //dd($request->missing('price'));
            //admin
            $user = $request->client; //id de l'user choisi par l'admin
        }
        else{
            $user = Auth::user()->id ; //session du client
        }
        $date = now();
        $blNoExist = DB::table('bon_livraisons')->where('user_id',$user)->whereDate('created_at',$date)->count();
        $cmdExist =  DB::table('commandes')->where('statut','<>','expidié')->where('user_id',$user)->whereDate('created_at',now())->count();

        //dd($blNoExist , $cmdExist , $user);

        if( ($blNoExist != 0) || ($cmdExist == 0) ){ //le bon de libraison existe déja ou ga3 les commandes ba9in expidié
            if($blNoExist != 0){
                $request->session()->flash('blNoExist');
            }
                else{
                    $request->session()->flash('cmdExist');
            }
        }
        else{
            $bonLivraison = new BonLivraison();
            $bonLivraison->colis = DB::table('commandes')->where('user_id',$user)->where('statut','<>','expidié')->whereDate('created_at',$date)->sum('colis');
            $bonLivraison->commande = DB::table('commandes')->where('user_id',$user)->where('statut','<>','expidié')->whereDate('created_at',$date)->count();
            $bonLivraison->prix = DB::table('commandes')->where('user_id',$user)->where('statut','<>','expidié')->whereDate('created_at',$date)->sum('prix');
            $bonLivraison->montant = DB::table('commandes')->where('user_id',$user)->where('statut','<>','expidié')->whereDate('created_at',$date)->sum('montant');
            $bonLivraison->nonRammase = DB::table('commandes')->where('user_id',$user)->where('statut','expidié')->whereDate('created_at',$date)->count();
            $bonLivraison->user()->associate($user)->save();
            $request->session()->flash('ajoute');
        }

        return redirect(route('bonlivraison.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BonLivraison  $bonLivraison
     * @return \Illuminate\Http\Response
     */
    public function show(BonLivraison $bonLivraison)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BonLivraison  $bonLivraison
     * @return \Illuminate\Http\Response
     */
    public function edit(BonLivraison $bonLivraison)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BonLivraison  $bonLivraison
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BonLivraison $bonLivraison)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BonLivraison  $bonLivraison
     * @return \Illuminate\Http\Response
     */
    public function destroy(BonLivraison $bonLivraison)
    {
        //
    }
}
