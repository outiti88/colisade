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
            $clients = User::whereHas('roles', function($q){$q->whereIn('name', ['client', 'ecom']);})->get();        }
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
        $user = $request->client;
        if(!Gate::denies('ramassage-commande')) {
        $nbrCmdLivre =  DB::table('commandes')->where('statut','Livré')->where('user_id',$user)->where('facturer','0')->count();
        $nbrCmdRamasse =  DB::table('commandes')->where('statut','En cours')->where('user_id',$user)->where('facturer','0')->count();

        if($nbrCmdLivre == 0){ 
           
                $request->session()->flash('nbrCmdRamasse' , $nbrCmdRamasse);
            
        }
        else{
            $facture = new Facture();
            $facture->numero = 'FAC_'.date("mdis");
            $facture->colis = DB::table('commandes')->where('user_id',$user)->whereIn('statut', ['Reporté', 'Retour Complet', 'Retour Partiel'])->where('facturer','0')->sum('colis');
            $facture->livre = $nbrCmdLivre;
            $facture->prix = DB::table('commandes')->where('user_id',$user)->where('statut','Livré')->where('facturer','0')->sum('prix');
            $facture->montant = DB::table('commandes')->where('user_id',$user)->where('statut','Livré')->where('facturer','0')->sum('montant');
            $facture->commande = DB::table('commandes')->where('user_id',$user)->whereIn('statut', ['Reporté', 'Retour Complet', 'Retour Partiel'])->where('facturer','0')->count(); //nbr de commanddes non livrée
            $facture->user()->associate($user)->save();
            $affected = DB::table('commandes')->whereIn('statut', ['Livré','Reporté', 'Retour Complet', 'Retour Partiel'])->where('facturer', '=', '0')->update(array('facturer' => $facture->id));

            $request->session()->flash('ajoute');
        }

        }//rammsage-commande
        return redirect(route('facture.index'));
    }//fin fonction ajouter facture



    public function commandes(Facture $facture, $n , $i){
        $user = $facture->user_id;
        $commandes = DB::table('commandes')->where('user_id',$user)->where('statut','livré')->where('facturer',$facture->id)->get();
        $content = 
        '
        <div class="invoice">
             <table id="customers">
                 <tr>
                 <th>Numéro</th>
                 <th>Destinataire</th>
                 <th>Ville</th>
                 <th>Téléphone</th>
                 <th>Montant</th>
                 <th>Prix de livraison</th>
                 <th>Date de livraison</th>
                 </tr>
        ';
        foreach ($commandes as $index => $commande) {

            if(($index >= $i * 12) && ($index < 12*($i+1))) { //les infromations de la table depe,d de la page actuelle
            $statut = DB::table('statuts')->where('commande_id',$commande->id)->where('name','livré')->get()->first();
                
            $content .= '<tr>'.'
            <td>'.$commande->numero.'</td>
            <td>'.$commande->nom.'</td>
            <td>'.$commande->ville.'</td>
            <td>'.$commande->telephone.'</td>
            <td>'.$commande->montant.'</td>
            <td>'.$commande->prix.'</td>
            <td>'.$statut->created_at.'</td>
            '.'</tr>' ;
                }
            }
        return $content .'</table>  </div>';
       
    }

     //fonction qui renvoie le contenue du bon de livraison

    public function content(Facture $facture, $n , $i){
        $user = $facture->user_id;
        $user = DB::table('users')->find($user);
        
        //les information du fournisseur (en-tete)
        $info_client = '
            <div class="info_client">
                <h1>'.$user->name.'</h1>
                <h3>ADRESSE : '.$user->adresse.'</h3>
                <h3>TELEPHONE : '.$user->telephone.'</h3>
                <h3>VILLE : '.$user->ville.'</h3>
            </div>
            <div class="date_num">
                <h3>'.$facture->numero.'</h3>
                <h3>'.$facture->created_at.'</h3>

            </div>
        ';
        // pied du bon d'achat (calcul du total)
        $total = '
            <div class="total">
                <table id="customers">
                <tr>
                <td>Total brut : </td>
                <td>'.$facture->montant.'  MAD</td>
                </tr>
                <tr>
                <td>Frais de livraison : </td>
                <td>'.$facture->prix .'  MAD</td>
                </tr>
                <tr>
                <th>TOTAL NET : </th>
                <td>'.($facture->montant - $facture->prix) .'  MAD</td>
                </tr>
                </table>
            </div>
            ';

           
       $content = $this->commandes($facture, $n , $i);
        $content = $info_client.$content;
        if($n == ($i+1)){ //le total seulement dans la derniere page (n est le nbr de page / i et la page actuelle)
            $content .= $total ;
        }
       return $content ;
    }


    public function gen($id){
        
        $facture = Facture::findOrFail($id);
        $user = $facture->user_id;

        if($user !== Auth::user()->id && Gate::denies('ramassage-commande')){
            return redirect()->route('facture.index');
        }
        $user = DB::table('users')->find($user);
        //dd($facture->id);
        $pdf = \App::make('dompdf.wrapper');

        $style =' 
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Facture_'.$facture->numero.'</title>

            <style type="text/css">
            @page {
                margin: 0px;
            }
            
                body{
                    margin: 0px;
                    background-image: url("https://i.ibb.co/4WmzVtW/facture.png");
                    width: 790px;
                    height: auto;
                    background-position: center;
                    background-repeat: repeat;
                    padding-bottom : 200px;
                    background-size: 100% 1070px;
                    background-size: cover;
                    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                    font-size: 0.75em;
                }
                .info_client{
                    position:relative;
                    left:45px;
                    top:190px;
                }
                .date_num{
                    position:relative;
                    left:640px;
                    top:155px;
                }
                .total{
                    position:relative;
                    left:200px;
                    top:15px;
                }
                .invoice {
                   margin : 8px;
                    position: relative;
                    min-height: auto;
                    
                }
                #customers {
                    border-collapse: collapse;
                    width: 100%;
                    position: relative;
                    top: 170px;
                    }

                    #customers td, #customers th {
                    border: 1px solid #ddd;
                    padding: 8px;
                    }

                    #customers tr:nth-child(even){background-color: #f2f2f2;}

                    #customers th {
                    padding-top: 12px;
                    padding-bottom: 12px;
                    text-align: left;
                    background-color: #e85f03;
                    color: white;
                    }
                </style>
            
            </head>
            <body>
        ';
        $m = (($facture->livre )/ 12) ;
        $n = (int)$m; // nombre de page
        if($n != $m){$n++;}
        //dd($n);
        $content = '';
        for ($i=0; $i<$n ; $i++) { 
            $content .= $this->content($facture , $n , $i);
        }
        
        $content = $style.$content.' </body></html>' ;

        //dd($this->content($facture));
        $pdf -> loadHTML($content)->setPaper('A4');


        return $pdf->stream('Facture_'.$facture->numero.'pdf');
    }

 
    public function search($id){
        //dd(Auth::user()->id );
        $clients = User::whereHas('roles', function($q){$q->whereIn('name', ['client', 'ecom']);})->get();
        $users = [] ;
        if(!Gate::denies('ramassage-commande')) {
            //session administrateur donc on affiche tous les commandes
            $total = DB::table('commandes')->where('deleted_at',NULL)->where('facturer',$id)->count();
            $commandes= DB::table('commandes')->where('deleted_at',NULL)->where('facturer',$id)->orderBy('created_at', 'DESC')->paginate(10);

            //dd($clients[0]->id);
        }
        else{
            $commandes= DB::table('commandes')->where('deleted_at',NULL)->where('facturer',$id)->where('user_id',Auth::user()->id )->orderBy('created_at', 'DESC')->paginate(10);
            $total =DB::table('commandes')->where('deleted_at',NULL)->where('facturer',$id)->where('user_id',Auth::user()->id )->count();
           //dd("salut");
        }

      
            foreach($commandes as $commande){
                if(!empty(User::find($commande->user_id)))
                $users[] =  User::find($commande->user_id) ;
            }
        //$commandes = Commande::all()->paginate(3) ;
        return view('commande.colis',['commandes' => $commandes, 
                                    'total'=>$total,
                                    'users'=> $users,
                                    'clients' => $clients]);
   }

   public function infos($id){
        $clients = [];  
        $users = []; 
        if(!Gate::denies('ramassage-commande')) {
            $factures = DB::table('factures')->where('id',$id)->get();
            $clients = User::whereHas('roles', function($q){$q->whereIn('name', ['client', 'ecom']);})->get();
        }
        else{
            $factures = DB::table('factures')->where('user_id',Auth::user()->id)->where('id',$id)->get();

        }
        $total = $factures->count();

        foreach($factures as $facture){
            if(!empty(User::find($facture->user_id)))
            $users[] =  User::find($facture->user_id) ;
        }
        if($total > 0){
            //dd($factures);
            return view('facture',['factures'=>$factures ,
                                    'total' => $total,
                                    'users'=> $users,
                                    'clients' => $clients]);
        }
        else{
            return redirect()->route('facture.index');
        }
   }

}
