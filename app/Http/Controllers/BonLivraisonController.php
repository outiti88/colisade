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

    public function commandes(BonLivraison $bonLivraison, $n , $i){
        $user = $bonLivraison->user_id;
        $date = $bonLivraison->created_at;
        $commandes = DB::table('commandes')->whereDate('created_at',$date)->where('user_id',$user)->where('statut','<>','expidié')->get();
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
                 </tr>
        ';
        foreach ($commandes as $index => $commande) {
            if(($index >= $i * 12) && ($index < 12*($i+1))) { //les infromations de la table depe,d de la page actuelle
                
            if ($commande->statut === 'expidié'){
                $commande->prix = 0;
            }
            $content .= '<tr>'.'
            <td>'.$commande->numero.'</td>
            <td>'.$commande->nom.'</td>
            <td>'.$commande->ville.'</td>
            <td>'.$commande->telephone.'</td>
            <td>'.$commande->montant.'</td>
            <td>'.$commande->prix.'</td>
            '.'</tr>' ;
        }
    }
        return $content .'</table>
        </div>'
       ;
    }



     //fonction qui renvoie le contenue du bon de livraison

    public function content(BonLivraison $bonLivraison, $n , $i){
        $user = $bonLivraison->user_id;
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
                <h3>BL_'.bin2hex(substr($user->name, - strlen($user->name) , 3)).$bonLivraison->id.'</h3>
                <h3>'.$bonLivraison->created_at.'</h3>

            </div>
        ';
        // pied du bon d'achat (calcul du total)
        $total = '
            <div class="total">
                <table id="customers">
                <tr>
                <td>Total brut : </td>
                <td>'.$bonLivraison->montant.'  MAD</td>
                </tr>
                <tr>
                <td>Frais de livraison : </td>
                <td>'.$bonLivraison->prix .'  MAD</td>
                </tr>
                <tr>
                <th>TOTAL NET : </th>
                <td>'.($bonLivraison->montant - $bonLivraison->prix) .'  MAD</td>
                </tr>
                </table>
            </div>
            ';

           
       $content = $this->commandes($bonLivraison, $n , $i);
        $content = $info_client.$content;
        if($n == ($i+1)){ //le total seulement dans la derniere page (n est le nbr de page / i et la page actuelle)
            $content .= $total ;
        }
       return $content ;
    }


    public function gen($id){
        
        $bonLivraison = BonLivraison::findOrFail($id);
        $user = $bonLivraison->user_id;
        $user = DB::table('users')->find($user);
        //dd($bonLivraison->id);
        $pdf = \App::make('dompdf.wrapper');
        $style =' 
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Bon_de_livraison_BL_'.bin2hex(substr($user->name, - strlen($user->name) , 3)).$bonLivraison->id.'</title>

            <style type="text/css">
            @page {
                margin: 0px;
            }
            
                body{
                    margin: 0px;
                    background-image: url("https://i.ibb.co/rxQVYqw/3446949.png");
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
        $m = (($bonLivraison->nonRammase  + $bonLivraison->commande )/ 12) ;
        $n = (int)$m; // nombre de page
        if($n != $m){$n++;}
        //dd($n);
        $content = '';
        for ($i=0; $i<$n ; $i++) { 
            $content .= $this->content($bonLivraison , $n , $i);
        }
        
        $content = $style.$content.' </body></html>' ;

        //dd($this->content($bonLivraison));
        $pdf -> loadHTML($content)->setPaper('A4');


        return $pdf->stream('Bon_de_livraison_BL_'.bin2hex(substr($user->name, - strlen($user->name) , 3)).$bonLivraison->id.'.pdf');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BonLivraison  $bonLivraison
     * @return \Illuminate\Http\Response
     */
    public function show(BonLivraison $bonLivraison)
    {
     
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
