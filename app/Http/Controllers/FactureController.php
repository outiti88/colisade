<?php

namespace App\Http\Controllers;

use App\Facture;

use App\BonLivraison;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FactureController extends Controller
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
            $factures = DB::table('factures')->orderBy('created_at', 'DESC')->get();
            $clients = User::whereHas('roles', function($q){$q->where('name','client');})->get();
        }
        else{
            $factures = DB::table('factures')->where('user_id',Auth::user()->id)->orderBy('created_at', 'DESC')->get();
        }

        foreach($factures as $facture){
            if(!empty(User::find($facture->user_id)))
            $users[] =  User::find($facture->user_id) ;
        }
        $total = $factures->count();
        //dd($users);
        return view('facture',['factures'=>$factures ,
                                        'total' => $total,
                                         'users'=> $users,
                                         'clients' => $clients]);
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = $request->date;
        $user = $request->client;
        if(!Gate::denies('ramassage-commande')) {
        $facNoExist = DB::table('factures')->where('user_id',$user)->whereDate('created_at',$date)->count();
        $nbrCmdLivre =  DB::table('commandes')->where('statut','Livré')->where('user_id',$user)->whereDate('created_at',$date)->count();
        $nbrCmd =  DB::table('commandes')->where('user_id',$user)->whereDate('created_at',$date)->count();
        
        if( ($facNoExist != 0) || ($nbrCmdLivre == 0) ){ //le bon de libraison existe déja ou ga3 les commandes ba9in expidié
            if($facNoExist != 0){
                $request->session()->flash('facNoExist');
            }
                else{
                    $request->session()->flash('nbrCmdLivre');
            }
        }
        else{
            $facture = new Facture();
            $facture->numero = 'FAC_'.date("mdis");
            $facture->colis = DB::table('commandes')->where('user_id',$user)->where('statut','<>','Livré')->whereDate('created_at',$date)->sum('colis');
            $facture->livre = $nbrCmdLivre;
            $facture->prix = DB::table('commandes')->where('user_id',$user)->where('statut','Livré')->whereDate('created_at',$date)->sum('prix');
            $facture->montant = DB::table('commandes')->where('user_id',$user)->where('statut','Livré')->whereDate('created_at',$date)->sum('montant');
            $facture->commande = $nbrCmd - $nbrCmdLivre; //nbr de commanddes non livrée
            $facture->user()->associate($user)->save();
            $request->session()->flash('ajoute');
        }

        }//rammsage-commande
        return redirect(route('facture.index'));
    }//fin fonction ajouter facture

 
}
