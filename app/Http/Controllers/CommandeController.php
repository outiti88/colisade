<?php

namespace App\Http\Controllers;

use App\BonLivraison;
use App\Commande;
use App\CommandeProduit;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCommande;
use App\Notifications\newCommande;
use App\Notifications\statutChange;
use App\Produit;
use App\Statut;
use App\Stock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Nexmo\Laravel\Facade\Nexmo;

class CommandeController extends Controller
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
        //dd(auth()->user()->unreadNotifications );
        //dd(Auth::user()->id );
        $clients = User::whereHas('roles', function($q){$q->whereIn('name', ['client', 'ecom']);})->get();
        $users = [] ;
        $produits = [];

        if(!Gate::denies('ecom')){
            $produits_total = Produit::where('user_id',Auth::user()->id)->get();
            foreach($produits_total as $produit){
                $stock = DB::table('stocks')->where('produit_id',$produit->id)->get();
                if($stock[0]->qte > 0){
                    $produits[] = $produit; 
                }
            }
            //dd($produits);
        }

        if(!Gate::denies('manage-users')) {
            //session administrateur donc on affiche tous les commandes
            $total = DB::table('commandes')->where('deleted_at',NULL)->count();
            $commandes= DB::table('commandes')->where('deleted_at',NULL)->orderBy('updated_at', 'DESC')->paginate(10);

            //dd($clients[0]->id);
        }
        elseif(!Gate::denies('livreur')) {
            //session administrateur donc on affiche tous les commandes
            $total = DB::table('commandes')->where('deleted_at',NULL)->where('ville',Auth::user()->ville)->count();
            $commandes= DB::table('commandes')->where('deleted_at',NULL)->where('ville',Auth::user()->ville)->orderBy('updated_at', 'DESC')->paginate(10);

            //dd($clients[0]->id);
        }
        else{
            $commandes= DB::table('commandes')->where('deleted_at',NULL)->where('user_id',Auth::user()->id )->orderBy('updated_at', 'DESC')->paginate(10);
            $total =DB::table('commandes')->where('deleted_at',NULL)->where('user_id',Auth::user()->id )->count();
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
                                    'clients' => $clients,
                                    'produits'=>$produits]);
    }


    public function filter(Request $request){
       
        $commandes = DB::table('commandes')->where('deleted_at',NULL);
        $clients = User::whereHas('roles', function($q){$q->whereIn('name', ['client', 'ecom']);})->get();

        $users = [];
        $produits = [];

        if(!Gate::denies('ecom')){
            $produits = Produit::where('user_id',Auth::user()->id)->get();
            //dd($produits);
        }

        if(Gate::denies('ramassage-commande')) { //session client donc on cherche saulement dans ses propres commandes
            $commandes->where('user_id',Auth::user()->id );
            $clients = null;
        }

        if($request->filled('statut')){
            //dd("salut");
            $commandes->where('statut','like','%'.$request->statut.'%');
           //dd($commandes->count());
        }

        if($request->filled('client')){
            $commandes->where('user_id',$request->client);
        }
        
        if($request->filled('nom')){
            $commandes->where('nom','like','%'.$request->nom.'%');
        }
        if($request->filled('ville')){
            if(!Gate::denies('livreur')){
                $commandes->where('ville',Auth::user()->ville);
            }
            else{
                $commandes->where('ville','like','%'.$request->ville.'%');

            }
        }
        
        if($request->filled('dateMin')){
            $commandes->whereDate('created_at','>=',$request->dateMin);
        }
        if($request->filled('dateMax')){
            $commandes->whereDate('created_at','<=',$request->dateMax);
        }
        if($request->filled('prixMin') && $request->prixMin > 0){
            $commandes->where('montant','>=',$request->prixMin);
        }
        if($request->filled('prixMax') && $request->prixMax > 0){
            $commandes->where('montant','<=',$request->prixMax);
        }

        if($request->filled('bl')){
            $commandes->where('traiter','<>',0)->where('facturer',0);
        }

        if($request->filled('facturer')){
            $commandes->where('facturer','<>',0);
        }

        $total = $commandes->count() ;
        $commandes = $commandes->paginate(25);
        foreach($commandes as $commande){
            if(!empty(User::find($commande->user_id)))
            $users[] =  User::find($commande->user_id) ;
        }


        return view('commande.colis',['commandes' => $commandes, 
            'total'=>$total,
            'users'=> $users,
            'clients' => $clients,
            'produits' => $produits

            ]);
    }



    public function search(Request $request ) {

        if(strcmp(substr($request->search,-strlen($request->search),4) , "FAC_") == 0){  
            $clients = [];  
            $users = []; 
            if(!Gate::denies('manage-users')) {
                $factures = DB::table('factures')->where('numero','like','%'.$request->search.'%')->get();
                $clients = User::whereHas('roles', function($q){$q->whereIn('name', ['client', 'ecom']);})->get();
            }
            else{
                $factures = DB::table('factures')->where('user_id',Auth::user()->id)->where('numero','like','%'.$request->search.'%')->get();

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
                $request->session()->flash('search', $request->search);
                return redirect()->route('facture.index');
            }
       }


       if(strcmp(substr($request->search,-strlen($request->search),3) , "BL_") == 0){  
            $clients = [];  
            $id_bon = (int)substr($request->search,9);

            if(!Gate::denies('manage-users')) {
                $bonLivraisons = DB::table('bon_livraisons')->where('id',$id_bon)->get();
                //dd($bonLivraisons->count());
                $clients = User::whereHas('roles', function($q){$q->whereIn('name', ['client', 'ecom']);})->get();
            }
            else{
                $bonLivraisons = DB::table('bon_livraisons')->where('user_id',Auth::user()->id)->where('id',$id_bon)->get();

            }
            $total = $bonLivraisons->count();

            foreach($bonLivraisons as $bonLivraison){
                if(!empty(User::find($bonLivraison->user_id)))
                $users[] =  User::find($bonLivraison->user_id) ;
            }
            if($total > 0){
                $ramasse = DB::table('commandes')->where('user_id',Auth::user()->id)->where('statut','en cours')->where('traiter','0')->count();
                $nonRammase = DB::table('commandes')->where('user_id',Auth::user()->id)->where('statut','envoyée')->where('traiter','0')->count();
        
                return view('bonLivraison',['bonLivraisons'=>$bonLivraisons ,
                                        'total' => $total,
                                         'users'=> $users,
                                         'clients' => $clients,
                                         'ramasse' => $ramasse,
                                        'nonRamasse' => $nonRammase]);
            }
            else{
                $request->session()->flash('search', $request->search);
                return redirect()->route('bonlivraison.index');
            }
       }


        $users = [] ;
        $produits = [];
        if(!Gate::denies('ramassage-commande')) {
            //session administrateur donc on affiche tous les commandes
            $total = DB::table('commandes')->where('numero','like','%'.$request->search.'%')->where('deleted_at',NULL)->count();
            $commandes= DB::table('commandes')->where('numero','like','%'.$request->search.'%')->where('deleted_at',NULL)->orderBy('created_at', 'DESC')->paginate(10);
            
        }
        else{
            $commandes= DB::table('commandes')->where('numero','like','%'.$request->search.'%')->where('deleted_at',NULL)->where('user_id',Auth::user()->id )->orderBy('created_at', 'DESC')->paginate(10);
            $total =DB::table('commandes')->where('numero','like','%'.$request->search.'%')->where('deleted_at',NULL)->where('user_id',Auth::user()->id )->count();
        }

        if($total == 0) { //recherche par statut
            if(!Gate::denies('ramassage-commande')) {
                //session administrateur donc on affiche tous les commandes
                $total = DB::table('commandes')->where('statut','like','%'.$request->search.'%')->where('deleted_at',NULL)->count();
                $commandes= DB::table('commandes')->where('statut','like','%'.$request->search.'%')->where('deleted_at',NULL)->orderBy('created_at', 'DESC')->paginate(10);
                
            }
            else{
                $commandes= DB::table('commandes')->where('statut','like','%'.$request->search.'%')->where('deleted_at',NULL)->where('user_id',Auth::user()->id )->orderBy('created_at', 'DESC')->paginate(10);
                $total =DB::table('commandes')->where('statut','like','%'.$request->search.'%')->where('deleted_at',NULL)->where('user_id',Auth::user()->id )->count();
            }
        }
        //dd($commandes);
        if($total > 0 ){
            

            if(!Gate::denies('ecom')){
                $produits = Produit::where('user_id',Auth::user()->id)->get();
                //dd($produits);
            }
            foreach($commandes as $commande){
                if(!empty(User::find($commande->user_id)))
                $users[] =  User::find($commande->user_id) ;
             
            }
            $clients = User::whereHas('roles', function($q){$q->whereIn('name', ['client', 'ecom']);})->get();  
            return view('commande.colis',['commandes' => $commandes, 
            'total'=>$total,
            'users'=> $users,
            'clients' => $clients,
            'produits' => $produits
            ]);
         
           
        }
        else {
            $request->session()->flash('search', $request->search);
            return redirect()->route('commandes.index');
        }
        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommande $request)
    {
        //dd(!(gmdate("H")+1 <= 18));
        //dd(Auth::user()->id );

        //dd(now(),$bon_livraison);

           
            if(!Gate::denies('manage-users')){
                if(isset($request->client)){
                    $fournisseur = User::find($request->client);
                }
                else{
                    return redirect('/commandes');
                }
                
            }
            else{
                $fournisseur = Auth::user() ;
            }

            

            $commande = new Commande() ;
            $statut = new Statut();
            
        if($request->mode == "cd" && Gate::denies('ecom')){
            $commande->montant = $request->montant;
        }
        else{
            $commande->montant = 0;
        }
        $commande->telephone = $request->telephone;
        $commande->ville = $request->ville;
        $commande->secteur = ($request->secteur) ? $request->secteur : $request->ville;
        $commande->adresse = $request->adresse;

        $HorsTanger = array("Cap spartel","Du Golf","manar","Aviation","Mghogha","Zone Industrielle Mghogha","Achakar");
        $prixVille = (in_array($request->secteur,$HorsTanger)) ? 25 : 17 ;
        $commande->prix = $prixVille ;
        $commande->prix = ($commande->prix == 43 ) ? 45 : $commande->prix ;
        if($request->ville != 0 ) $commande->prix += 20 ;
        $commande->statut = "envoyée";
        $commande->colis = $request->colis;
        $commande->poids = '';
        $commande->nom = $request->nom;
        $commande->traiter = 0;
        $commande->facturer = 0;
        $commande->numero = substr($fournisseur->name, - strlen($fournisseur->name) , 3)."-".date("md-is");

        if(!Gate::denies('ecom')){
            if(!isset($request->produit)){
                $request->session()->flash('produit_required');
                    return redirect('/commandes');

            }
            foreach ($request->produit as $index => $IdProduit){
                $produit = Produit::find($IdProduit);
                $prixProduit = $produit->prix * $request->qte[$index];

                $commande->montant += $prixProduit;

                $stock = Stock::where('produit_id',$IdProduit)->first();
                //verification du stock
                if($stock->qte >= $request->qte[$index]){
                    $stock->qte -= $request->qte[$index];
                    $stock->save();
                }
                else{
                    $request->session()->flash('stock_insuf', $produit->libelle);
                    return redirect('/commandes');

                }
                
            }
        }
        $commande->user()->associate($fournisseur)->save();

        if(!Gate::denies('ecom')){
            foreach ($request->produit as $index => $produit){

                $produit_commande = new CommandeProduit();
                $produit_commande->commande_id = $commande->id;
                $produit_commande->produit_id = $produit;
                $produit_commande->qte =  $request->qte[$index];
                $produit_commande->save();
            }
        }
        
        //dd($commande->user());
        //$commande->save();
        $statut->commande_id = $commande->id;
        $statut->name = $commande->statut;

        
        $statut->user()->associate(Auth::user())->save();
        $request->session()->flash('statut', $commande->id);


        //notification
            $user_notify = \App\User::find(1);
            $user_notify->notify(new newCommande( $fournisseur , $commande));
       

        return redirect('/commandes');
    }
    

    public function showFromNotify(Commande $commande , DatabaseNotification $notification){

        $notification->markAsRead();

        return redirect()->route('commandes.show', $commande->id);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function show(Commande $commande)
    {

        if(Gate::denies('ramassage-commande')){
            if($commande->user_id !== Auth::user()->id)
            return redirect()->route('commandes.index');
        }
        
        if($commande->statut == 'Livré'){
            $timestamp1 = strtotime($commande->created_at);
            $timestamp2 = strtotime($commande->updated_at);
            $hour = abs($timestamp2 - $timestamp1)/(3600);
            $minute = ($hour - (int)$hour ) * 60 ;
            $seconde = ($minute - (int)$minute ) * 60 ;
            //dd((int)$hour , (int)$minute ,(int)$seconde);
        }
       
        //return $commande;
        //dd($produits);
        $statuts = DB::table('statuts')->where('commande_id',$commande->id)->get();
        foreach($statuts as $statut){
            $users[] =  User::find($statut->user_id) ;

        }
        if(!Gate::denies('gestion-stock')){
            $produits = [] ;
            $liaisons = DB::table('commande_produits')->where('commande_id',$commande->id)->get();
            foreach($liaisons as $produit){
            $produits[] = Produit::find($produit->produit_id);
        }
        return view('commande.show', ['commande'=>$commande , 'statuts' => $statuts , 
                                    'par' => $users,
                                    'produits' => $produits,
                                    'liaisons' => $liaisons
                                    ]);

        }   
        //dd($users);
        return view('commande.show', ['commande'=>$commande , 'statuts' => $statuts , 
                                    'par' => $users
                                    ]);
    }



    public function content(Commande $commande){
        $content = '';
        $user = DB::table('users')->find($commande->user_id);
        
        if($commande->montant == 0) $montant = "Payé par Carte bancaire";
        else $montant = ($commande->montant+$commande->prix) .' Mad';

        for ($i=1; $i <= $commande->colis ; $i++) { 
            $content .= '
            <div class="container">
                        
                <h1 style="color:#f7941e">
                    Ticket de Commande
                </h1>
                <div class="tableau">
                                        
                    <table id="customers">
                    <tr>
                        <th>Commande Numero: </th>
                        <td>' .$commande->numero.'</td>
                    </tr>
                    <tr>
                        <th>Entreprise:  </th>
                        <td>'.$user->name.'</td>
                    </tr>
                    </table>
                </div>
                <h2>Montant Total :'. $montant .' </h2>
                <div class="tableau">
                    <table id="customers">
                        <tr>
                            <th>
                                Nom & Prénom:
                            </th>
                            <td>
                                '.$commande->nom.'
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Ville:
                            </th>
                            <td>
                                '.$commande->ville.'
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Adresse:
                            </th>
                            <td>
                                '.$commande->adresse.'
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Téléphone:
                            </th>
                            <td>
                                '.$commande->telephone.'
                            </td>
                        </tr>
                    </table>
                    </div>
                    <div class="tableau">
                                        
                    <table id="customers">
                    <tr>
                        <th>Livreur: </th>
                        <td>Quickoo Delivery</td>
                    </tr>
                    <tr>
                        <th>Site web:  </th>
                        <td>www.quickoo.ma</td>
                    </tr>
                    </table>
                </div>
                <h2>colis: '.$i.'/'.$commande->colis.' </h2>
                <div style="display:flex ; justify-content: space-around; padding-bottom:20px">
                    <div class="logo-text" style="padding-top:20px" >
        
                    <img src="https://i.ibb.co/NWQgqxd/logo-light-text.png" style="
                        WIDTH: 130PX;
                    "class="light-logo" alt="homepage" />
                    </div>
                    <div class="logo-text" style="position:absolute; left:80% ; top:480px">
        
                    <img src="https://api.qrserver.com/v1/create-qr-code/?color=E85F03&bgcolor=FFFFFF&data=https%3A%2F%2Fquickoo.ma%2F&qzone=1&margin=0&size=200x200&ecc=L" style="
                        WIDTH: 70%;
                    "class="light-logo"/>
                    </div>
                </div>
            </div>
            
            ' ; }
            
            
        return $content;

    }

    public function gen($id){

        $commande = Commande::findOrFail($id);
        $pdf = \App::make('dompdf.wrapper');
        $style = '
            <style>
                    *{
                        
                        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                        font-size : 10px;
                        padding:2px;
                        margin:0;
                    }
                    h2{
                        text-align : center;
                        font-size: 1.5em;
                        border: 1px solid #f7941e;
                    }

                .container{
                    box-sizing: border-box;
                    width:100%
                    height:auto;
                    padding-top: 10px !important;
                }

                    .tableau{
                    padding-top:20px;
                   
                    width:100%;
                }
                

                    #customers {
                    text-align:center;
                    border-collapse: collapse;
                    width: 100%;
                    }

                    h1{
                        text-align : center;
                        font-size: 2em;
                    }

                    #customers td, #customers th {
                    border: 1px solid #f7941e;
                    }

                    #customers tr:nth-child(even){
                        background-color: #f2f2f2;
                    }

                    #customers th {
                    padding-top: 12px;
                    padding-bottom: 10px;
                    
                    color: black;
                    }
                </style>';

        $content = $this->content($commande);
            

        for ($i=1; $i <=$commande->colis ; $i++) { 
            # code...
        }
        $pdf -> loadHTML($style.$content)->setPaper('A6');


        return $pdf->stream();
        //dd($commande) ;
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
        if(Gate::denies('ramassage-commande')){
            if($commande->user_id !== Auth::user()->id)
            return redirect()->route('commandes.index');
        }

        if(Gate::denies('client-admin') || $commande->statut !== "envoyée"){
            //dd( $commande->staut );
            $request->session()->flash('noupdate', $commande->numero);
        }
        else
            {
                if(Gate::denies('ecom') ){
                    if($request->mode == "cd"){
                        $commande->montant = $request->montant;
                    }
                    else{
                        $commande->montant = 0;
                    }
                }
                

              
                
                $commande->telephone = $request->telephone;
                $commande->ville = $request->ville;
                $commande->adresse = $request->adresse;
                $commande->secteur = $request->secteur;
                //dd($request->secteur);
                $HorsTanger = array("Cap spartel","Du Golf","manar","Aviation","Mghogha","Zone Industrielle Mghogha","Achakar");
                $prixVille = (in_array($request->secteur,$HorsTanger)) ? 25 : 17 ;
                $commande->prix = $prixVille ;
                $commande->prix = ($commande->prix == 43 ) ? 45 : $commande->prix ;
                
                $commande->colis = $request->colis;
                $commande->nom = $request->nom;
                $commande->save();
               
                $request->session()->flash('statut', 'modifié');
            }
        return redirect()->route('commandes.show',['commande' => $commande->id]);
    }

  
    public function changeStatut(Request $request, $id)
    { //changement de statut du expidé à en cours
        //dd(!Gate::denies('ramassage-commande'));
        $commande = Commande::findOrFail($id);
        //$factureExist = DB::table('factures')->where('user_id',$commande->user_id )->whereDate('created_at',$commande->created_at)->count();

        if(Gate::denies('ramassage-commande') ){
            $request->session()->flash('noedit', $commande->numero);
            return redirect(route('commandes.index'));
        }
         //pour traiter la commande à ramassée , faut verifier deux conditons:
            // commande est envoyéee + traiter = 0         
        // dd($blExist);
        
        if(($commande->statut === "envoyée" || $commande->statut === "Ramassée" || $commande->statut === "Expidiée") && $commande->traiter == 0)
        {
            $user_ville = User::findOrFail($commande->user_id);
            
            if ($commande->statut === "Ramassée") {
                $commande->statut= "Expidiée"; 
            }
            
            elseif ($commande->statut === "Expidiée") {
                $commande->statut= "En cours"; 
            }
            else {
                if ($user_ville->ville == $commande->ville || $commande->ville == "Rabat") {
                    $commande->statut= "En cours"; 
                } else {
                    $commande->statut = "Ramassée";
                }
            }
            
            
            
            
            $commande->save();
            $statut = new Statut();
            $statut->commande_id = $commande->id;
            $statut->name = $commande->statut;
            $statut->user()->associate(Auth::user())->save();
            
            //notification
            $user_notify = \App\User::find($commande->user_id);
            $user_notify->notify(new statutChange($commande));
            //dd($test);
            $request->session()->flash('edit', $commande->numero);
        }
        else {
           
            if($commande->statut != "envoyée"){
                $request->session()->flash('nonExpidie', $commande->numero);
            }
            else{
                $request->session()->flash('blgenere', $commande->numero);
            }
        } 

        return back();
    }

    public function statutAdmin(Request $request, $id)
    {
        
        $commande = Commande::findOrFail($id);

        $user = User::find($commande->user_id);
       // dd($date_bl);
        if(Gate::denies('ramassage-commande') || $commande->statut === 'envoyée'){
            $request->session()->flash('noedit', $commande->numero);
        }


        else{
            if($commande->statut === 'En cours' && $commande->traiter > 0){ //bach traiter commande khass tkoun en cours w bl dyalha kyn
                $commande->statut= $request->statut;
                $commande->commentaire= $request->commentaire;
                $commande->save();
                $statut = new Statut();
                $statut->commande_id = $commande->id;
                $statut->name = $commande->statut;
                $statut->user()->associate(Auth::user())->save();
                $request->session()->flash('edit', $commande->numero);

                if($statut->name != "Livré"){
                    $commande_produits = DB::table('commande_produits')->where('commande_id',$commande->id)->get();
                    foreach($commande_produits as $commande_produit){
                    //dd($commande_produit);
                    $stock = Stock::where('produit_id',$commande_produit->produit_id)->first();
                    $stock->qte += $commande_produit->qte;

                    $stock->save();
                }
                }
                
            }
            else{
                
                $request->session()->flash('nonEncours', $commande->numero);
            }
            
            

            //dd('212'.substr($commande->telephone,1));
           /* Nexmo::message()->send([
                'to'   => '212'.substr('0649440905',1),
                'from' => 'Quickoo',
                'text' => 'Bonjour '.$commande->nom.' Votre Commande '.$user->name.' à été bien livré.'
            ]);*/
        }
        

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
        if(Gate::denies('delete-commande')){
            //dd('salut');
            $request->session()->flash('nodelete', $commande->numero);
            return redirect()->route('commandes.show',['commande' => $commande->id]);
                }
        if($commande->statut === "envoyée") {

            $numero = $commande->numero;
            $statut = DB::table('statuts')->where('commande_id',$commande->id)->get()->first()  ;
            //dd($statut->id);
            \App\Statut::destroy($statut->id);
            \App\Commande::destroy($commande->id);
            
            $request->session()->flash('delete', $numero);
            return redirect('/commandes');
        }
        else {
            //dd($commande->statut);
            $request->session()->flash('nodelete', $commande->numero);
            return redirect()->route('commandes.show',['commande' => $commande->id]);
        }
        
    }
}
