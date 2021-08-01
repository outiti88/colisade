<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
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


    public function dash()
    {

        if (!Gate::denies('nouveau') || Gate::denies('valide')) {
            return redirect()->route('home');
        }
        if (Gate::denies('client-admin')) return redirect()->route('commandes.index');

        /*    if(!Gate::denies('ramassage-commande')) {
            $factures = DB::table('factures')->where('numero','like','%'.$request->search.'%')->get();
            $clients = User::whereHas('roles', function($q){$q->where('name','client');})->get();
        }
        else{
            $factures = DB::table('factures')->where('user_id',Auth::user()->id)->where('numero','like','%'.$request->search.'%')->get();

        }*/
        $users = [];

        $todayCmd = 0;
        $lastdayCmd = 0;
        $ca = 0;
        $caFacturer = 0;
        $cmd = 0;
        $caLastMounth = 0;
        $caNonfacturer = 0;
        $caPercent = 0;

        $commandeGesture = DB::table('commandes')->where('deleted_at', NULL);


        $nouveau =  User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['nouveau']);
        })->where('deleted_at', NULL)->count();

        //dd($nouveau);
        $c_total = DB::table('commandes')->whereIn('statut', ['En cours', 'Modifiée'])->where('deleted_at', NULL);
        $l_total = DB::table('commandes')->where('statut', 'livré')->where('deleted_at', NULL);
        $r_total = DB::table('commandes')->whereIn('statut', ['retour en stock', 'retour', 'Refusée', 'Annulée', 'Injoignable', 'Pas de Réponse'])->where('deleted_at', NULL);
        $e_total = DB::table('commandes')->where('statut', 'envoyée')->where('deleted_at', NULL);

        //fournisseur
        if (Gate::denies('ramassage-commande')) {

            //todays order
            $todayCmd = DB::table('commandes')->where('deleted_at', NULL)->whereDate('created_at', Carbon::now())->where('user_id', Auth::user()->id)->count();

            //last days order
            $lastdayCmd = DB::table('commandes')->where('deleted_at', NULL)->whereDate('created_at', Carbon::yesterday())->where('user_id', Auth::user()->id)->count();

            //Grands chiffres et pourcentage
            $commandeGesture = $commandeGesture
                ->select(DB::raw('sum(montant) as m , sum(prix) as p'))
                ->where('statut', 'Livré')->where('user_id', Auth::user()->id);

            //Ca total
            $ca = $commandeGesture->first()->m - $commandeGesture->first()->p;

            //Pourcentage mois dernier
            $commandeLastMounth =  DB::table('commandes')->where('deleted_at', NULL)
                ->select(DB::raw('sum(montant) as m , sum(prix) as p'))
                ->where('statut', 'Livré')->where('user_id', Auth::user()->id)->whereMonth('created_at', (date('m') - 1))->first();
            $caLastMounth = $commandeLastMounth->m - $commandeLastMounth->p;

            $commandeCurrentMounth =  DB::table('commandes')->where('deleted_at', NULL)
                ->select(DB::raw('sum(montant) as m , sum(prix) as p'))
                ->where('statut', 'Livré')->where('user_id', Auth::user()->id)->whereMonth('created_at', (date('m')))->first();
            $caCurrentMounth = $commandeCurrentMounth->m - $commandeCurrentMounth->p;

            if ($caLastMounth != 0)
                $caPercent = number_format((($caCurrentMounth - $caLastMounth) / $caLastMounth) * 100, 2, '.', '');


            //Ca facturer
            $commandeGesturef = $commandeGesture->where('facturer', '>', '0');
            $caFacturer = $commandeGesturef->first()->m - $commandeGesturef->first()->p;

            //montant non facturer
            $caNonfacturer = $ca - $caFacturer;






            //statistique des etats de commandes
            $c_total = $c_total->where('user_id', Auth::user()->id);
            $l_total = $l_total->where('user_id', Auth::user()->id);
            $r_total = $r_total->where('user_id', Auth::user()->id);
            $e_total = $e_total->where('user_id', Auth::user()->id);

            //top 5 des clients
            $topCmd = DB::table('commandes')
                ->select(DB::raw('nom , count(*) as cmd , sum(colis) as colis , sum(montant) as m'))
                ->where('deleted_at', NULL)
                ->where('user_id', Auth::user()->id)
                ->where('statut', 'livré')
                ->groupBy('telephone')
                ->orderBy('m', 'DESC')
                ->take(5)->get();


            $cmdRefuser = DB::table('commandes')->where('deleted_at', NULL)
                ->where('user_id', Auth::user()->id)
                ->select(DB::raw('count(numero) as m '))
                ->where('statut', 'Refusée')->first()->m;

            $cmdliv = DB::table('commandes')->where('deleted_at', NULL)
                ->where('user_id', Auth::user()->id)
                ->select(DB::raw('count(numero) as m '))
                ->first()->m;



            if ($cmdliv != 0)
                $cmdLivRefuser =  number_format(($cmdRefuser / $cmdliv) * 100, 2, '.', '');
            else $cmdLivRefuser = 0;
        }

        //Administrateur
        else {

            //todays order
            $todayCmd = DB::table('commandes')->where('deleted_at', NULL)->whereDate('created_at', Carbon::now())->count();

            //last days order
            $lastdayCmd = DB::table('commandes')->where('deleted_at', NULL)->whereDate('created_at', Carbon::yesterday())->count();

            //Grands chiffres et pourcentage
            $commandeGesture = DB::table('commandes')->where('deleted_at', NULL)
                ->select(DB::raw('sum(livreurPart) as m , sum(prix) as p'))
                ->where('statut', 'Livré');

            //Commandes Refusées
            $commandeRefuser = DB::table('commandes')->where('deleted_at', NULL)
                ->select(DB::raw('count(numero) as c ,sum(livreurPart) as p'))
                ->where('statut', 'Refusée')->first();

            //Ca total
            $ca = $commandeGesture->first()->p - $commandeGesture->first()->m + $commandeRefuser->c * 10 - $commandeRefuser->p;


            //Pourcentage mois dernier
            $commandeLastMounth =  DB::table('commandes')->where('deleted_at', NULL)
                ->select(DB::raw('sum(livreurPart) as m , sum(prix) as p'))
                ->where('statut', 'Livré')->whereMonth('created_at', (date('m') - 1))->first();
            $caLastMounth = $commandeLastMounth->p - $commandeLastMounth->m;


            $commandeCurrentMounth =  DB::table('commandes')->where('deleted_at', NULL)
                ->select(DB::raw('sum(livreurPart) as m , sum(prix) as p'))
                ->where('statut', 'Livré')->whereMonth('created_at', (date('m')))->first();
            $caCurrentMounth = $commandeCurrentMounth->p - $commandeCurrentMounth->m;


            if ($caLastMounth != 0)
                $caPercent = number_format((($caCurrentMounth - $caLastMounth) / $caLastMounth) * 100, 2, '.', '');

            //Chiffre d'affaire des commandes livrées
            $caFacturer  = DB::table('commandes')->where('deleted_at', NULL)
                ->select(DB::raw('sum(livreurPart) as m , sum(prix) as p'))
                ->where('statut', 'Livré')->first()->p;

            //part des livreurs (commandes livrées)
            $caNonfacturer = DB::table('commandes')->where('deleted_at', NULL)
                ->select(DB::raw('sum(livreurPart) as m , sum(prix) as p'))
                ->where('statut', 'Livré')->first()->m;

            $cmdRefuser = DB::table('commandes')->where('deleted_at', NULL)
                ->select(DB::raw('count(numero) as m , sum(livreurPart) as p'))
                ->where('statut', 'Refusée')->first();

            $cmdLivRefuser = $cmdRefuser->p;
            $cmdRefuser = $cmdRefuser->m * 10;




            //Top 5 Cilent final
            $topCmd = DB::table('commandes')
                ->select(DB::raw('nom , user_id, count(*) as cmd , sum(colis) as colis , sum(prix) as m'))
                ->where('deleted_at', NULL)
                ->where('statut', 'livré')
                ->groupBy('telephone', 'user_id')
                ->orderBy('m', 'DESC')
                ->take(5)->get();

            foreach ($topCmd as $commande) {
                if (!empty(User::withTrashed()->find($commande->user_id)))
                    $users[] =  User::withTrashed()->find($commande->user_id);
            }
        }

        //dd($users);

        //Statuts des commandes
        $c = $c_total->orderBy('created_at', 'DESC')->limit(1)->get()->first();
        $l = $l_total->orderBy('created_at', 'DESC')->limit(1)->get()->first();
        $r = $r_total->orderBy('created_at', 'DESC')->limit(1)->get()->first();
        $e = $e_total->orderBy('created_at', 'DESC')->limit(1)->get()->first();

        $tab =
            array(
                'en_cours' => array(
                    'nbr' => $c_total->count(),
                    'date' => ($c === NULL) ? "" : $c->created_at
                ),
                'expidie' => array(
                    'nbr' => $e_total->count(),
                    'date' => ($e === NULL) ? "" : $e->created_at
                ),
                'livré' => array(
                    'nbr' => $l_total->count(),
                    'date' => ($l === NULL) ? "" : $l->created_at
                ),
                'retour' => array(
                    'nbr' => $r_total->count(),
                    'date' => ($r === NULL) ? "" : $r->created_at
                )
            );


        //Chart commandes livré vs commandes retour
        $chart =
            array(
                'livre' => array(),
                'retour' => array()
            );
        if (Gate::denies('ramassage-commande')) {
            for ($i = 1; $i <= 12; $i++) {
                $getCmd = DB::table('commandes')->where('statut', 'livré')->where('deleted_at', NULL)->whereMonth('created_at', ($i))->where('user_id', Auth::user()->id);
                $chart['livre'][] = $getCmd->sum('montant') - $getCmd->sum('prix');
                $chart['retour'][] = DB::table('commandes')->whereIn('statut', ['retour en stock', 'retour', 'Refusée', 'Annulée', 'Injoignable', 'Pas de Réponse'])->where('deleted_at', NULL)->whereMonth('created_at', ($i))->where('user_id', Auth::user()->id)->sum('montant');
            }
        } else {
            for ($i = 1; $i <= 12; $i++) {
                $getCmd = DB::table('commandes')->where('statut', 'livré')->where('deleted_at', NULL)->whereMonth('created_at', ($i));
                $chart['livre'][] = $getCmd->sum('prix') - $getCmd->sum('livreurPart');
                $chart['retour'][] = DB::table('commandes')->whereIn('statut', ['retour en stock', 'retour', 'Refusée', 'Annulée', 'Injoignable', 'Pas de Réponse'])->where('deleted_at', NULL)->whereMonth('created_at', ($i))->sum('prix');
            }
        }


        //dd($chart);

        $livre = json_encode($chart['livre'], JSON_NUMERIC_CHECK);
        $retour = json_encode($chart['retour'], JSON_NUMERIC_CHECK);

        return view('dashboard', [
            'nouveau' => $nouveau, 'tab' => $tab,
            'livre' => $livre, 'retour' => $retour,
            'topCmds' => $topCmd, 'users' => $users,
            'ca' => $ca, 'caFacturer' => $caFacturer, 'caNonfacturer' => $caNonfacturer, 'caPercent' => $caPercent,
            'cmdLivRefuser' => $cmdLivRefuser, 'cmdRefuser' => $cmdRefuser,
            'todayCmd' => $todayCmd, 'lastdayCmd' => $lastdayCmd
        ]);
    }
}
