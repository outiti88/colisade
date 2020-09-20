<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
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

    
    public function dash(){

    /*    if(!Gate::denies('ramassage-commande')) {
            $factures = DB::table('factures')->where('numero','like','%'.$request->search.'%')->get();
            $clients = User::whereHas('roles', function($q){$q->where('name','client');})->get();
        }
        else{
            $factures = DB::table('factures')->where('user_id',Auth::user()->id)->where('numero','like','%'.$request->search.'%')->get();

        }*/

        //Statuts des commandes
        $c = DB::table('commandes')->where('statut','En cours')->where('deleted_at',NULL)->orderBy('created_at','DESC')->limit(1)->get()->first();
        $l = DB::table('commandes')->where('statut','livré')->where('deleted_at',NULL)->orderBy('created_at','DESC')->limit(1)->get()->first();
        $r = DB::table('commandes')->where('statut','like','retour%')->where('deleted_at',NULL)->orderBy('created_at','DESC')->limit(1)->get()->first();
        $e = DB::table('commandes')->where('statut','expidie')->where('deleted_at',NULL)->orderBy('created_at','DESC')->limit(1)->get()->first();

        $tab = 
            array(
                'en_cours' => array(
                    'nbr'=> DB::table('commandes')->where('statut','En cours')->where('deleted_at',NULL)->count(),
                    'date' => ($c === NULL) ? "" : $c->created_at
                ),
                'expidie' => array(
                    'nbr'=> DB::table('commandes')->where('statut','expidié')->where('deleted_at',NULL)->count(),
                    'date' => ($e=== NULL) ? "" : $e->created_at
                ),
                'livré' => array(
                    'nbr'=> DB::table('commandes')->where('statut','livré')->where('deleted_at',NULL)->count(),
                    'date' => ($l === NULL) ? "" : $l->created_at
                ),
                'retour' => array(
                    'nbr'=> DB::table('commandes')->where('statut','like','retour%')->where('deleted_at',NULL)->count(),
                    'date' => ($r === NULL) ? "" : $r->created_at
                )
                );


        //Chart commandes livré vs commandes retour
        $chart = 
                array(
                    'livre' => array(),
                    'retour' => array()
                );
            for ($i=1; $i <= 12 ; $i++) { 
                $chart['livre'][] = DB::table('commandes')->where('statut','livré')->whereMonth('created_at',($i))->sum('prix');
                $chart['retour'][] = DB::table('commandes')->where('statut','like','retour%')->whereMonth('created_at',($i))->sum('prix');
            }
       
           $livre=json_encode($chart['livre'],JSON_NUMERIC_CHECK);
           $retour=json_encode($chart['retour'],JSON_NUMERIC_CHECK);

        return view('dashboard' , ['tab'=>$tab , 'livre'=>$livre , 'retour'=>$retour]);
        
    }
}
