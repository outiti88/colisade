<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;


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

        if(!Gate::denies('nouveau')){
            return redirect()->route('home');            
        }

    /*    if(!Gate::denies('ramassage-commande')) {
            $factures = DB::table('factures')->where('numero','like','%'.$request->search.'%')->get();
            $clients = User::whereHas('roles', function($q){$q->where('name','client');})->get();
        }
        else{
            $factures = DB::table('factures')->where('user_id',Auth::user()->id)->where('numero','like','%'.$request->search.'%')->get();

        }*/
        $users = [];
        $c_total = DB::table('commandes')->where('statut','En cours')->where('deleted_at',NULL);
        $l_total = DB::table('commandes')->where('statut','livré')->where('deleted_at',NULL);
        $r_total = DB::table('commandes')->where('statut','like','retour%')->where('deleted_at',NULL);
        $e_total = DB::table('commandes')->where('statut','expidie')->where('deleted_at',NULL);

        if(Gate::denies('ramassage-commande')){
            $c_total = $c_total->where('user_id',Auth::user()->id);
            $l_total = $l_total->where('user_id',Auth::user()->id);
            $r_total = $r_total->where('user_id',Auth::user()->id);
            $e_total = $e_total->where('user_id',Auth::user()->id);

            $topCmd = DB::table('commandes')
                            ->select(DB::raw('nom , count(*) as cmd , sum(colis) as colis , sum(montant) as m'))
                            ->where('deleted_at',NULL)
                            ->where('user_id',Auth::user()->id)
                            ->where('statut','livré')
                            ->groupBy('nom')
                            ->orderBy('m', 'DESC')
                            ->take(4)->get();
        }

        else{
            $topCmd = DB::table('commandes')
            ->select(DB::raw('nom , user_id, count(*) as cmd , sum(colis) as colis , sum(montant) as m'))
            ->where('deleted_at',NULL)
            ->where('statut','livré')
            ->groupBy('nom', 'user_id')
            ->orderBy('m', 'DESC')
            ->take(4)->get();

            foreach($topCmd as $commande){
                if(!empty(User::find($commande->user_id)))
                $users[] =  User::find($commande->user_id) ;
            }
        }
        
        //dd($users);

        //Statuts des commandes
        $c= $c_total->orderBy('created_at','DESC')->limit(1)->get()->first();
        $l= $l_total->orderBy('created_at','DESC')->limit(1)->get()->first();
        $r= $r_total->orderBy('created_at','DESC')->limit(1)->get()->first();
        $e= $e_total->orderBy('created_at','DESC')->limit(1)->get()->first();

        $tab = 
            array(
                'en_cours' => array(
                    'nbr'=> $c_total->count(),
                    'date' => ($c === NULL) ? "" : $c->created_at
                ),
                'expidie' => array(
                    'nbr'=> $e_total->count(),
                    'date' => ($e=== NULL) ? "" : $e->created_at
                ),
                'livré' => array(
                    'nbr'=> $l_total->count(),
                    'date' => ($l === NULL) ? "" : $l->created_at
                ),
                'retour' => array(
                    'nbr'=> $r_total->count(),
                    'date' => ($r === NULL) ? "" : $r->created_at
                )
                );


        //Chart commandes livré vs commandes retour
        $chart = 
                array(
                    'livre' => array(),
                    'retour' => array()
                );
                if(Gate::denies('ramassage-commande')){
                    for ($i=1; $i <= 12 ; $i++) { 
                    
                        $chart['livre'][] = DB::table('commandes')->where('statut','livré')->where('deleted_at',NULL)->whereMonth('created_at',($i))->where('user_id',Auth::user()->id)->sum('montant');
                        $chart['retour'][] = DB::table('commandes')->where('statut','like','%retour%')->where('deleted_at',NULL)->whereMonth('created_at',($i))->where('user_id',Auth::user()->id)->sum('montant');
                    }
                }
                else{
                    for ($i=1; $i <= 12 ; $i++) { 
                        $chart['livre'][] = DB::table('commandes')->where('statut','livré')->where('deleted_at',NULL)->whereMonth('created_at',($i))->sum('prix');
                        $chart['retour'][] = DB::table('commandes')->where('statut','like','%retour%')->where('deleted_at',NULL)->whereMonth('created_at',($i))->sum('prix');
                    }
                }
            
           
            //dd($chart);
       
           $livre=json_encode($chart['livre'],JSON_NUMERIC_CHECK);
           $retour=json_encode($chart['retour'],JSON_NUMERIC_CHECK);

        return view('dashboard' , ['tab'=>$tab , 'livre'=>$livre , 'retour'=>$retour , 'topCmds' => $topCmd , 'users' => $users]);
        
    }
}
