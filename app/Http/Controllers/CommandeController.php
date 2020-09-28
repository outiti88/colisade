<?php

namespace App\Http\Controllers;

use App\BonLivraison;
use App\Commande;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCommande;
use App\Notifications\newCommande;
use App\Notifications\statutChange;
use App\Statut;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\User;
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
        //dd(Auth::user()->id );
        $clients = User::whereHas('roles', function($q){$q->where('name','client');})->get();
        $users = [] ;
        if(!Gate::denies('ramassage-commande')) {
            //session administrateur donc on affiche tous les commandes
            $total = DB::table('commandes')->where('deleted_at',NULL)->count();
            $commandes= DB::table('commandes')->where('deleted_at',NULL)->orderBy('created_at', 'DESC')->paginate(10);

            //dd($clients[0]->id);
        }
        else{
            $commandes= DB::table('commandes')->where('deleted_at',NULL)->where('user_id',Auth::user()->id )->orderBy('created_at', 'DESC')->paginate(10);
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
                                    'clients' => $clients]);
    }


    public function filter(Request $request){
       
        $commandes = DB::table('commandes')->where('deleted_at',NULL);
        $clients = User::whereHas('roles', function($q){$q->where('name','client');})->get();

        $users = [];
        

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
            $commandes->where('ville','like','%'.$request->ville.'%');
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

        $total = $commandes->count() ;
        $commandes = $commandes->paginate(15);
        foreach($commandes as $commande){
            if(!empty(User::find($commande->user_id)))
            $users[] =  User::find($commande->user_id) ;
        }


        return view('commande.colis',['commandes' => $commandes, 
            'total'=>$total,
            'users'=> $users,
            'clients' => $clients

            ]);
    }



    public function search(Request $request ) {

        if(strcmp(substr($request->search,-strlen($request->search),4) , "FAC_") == 0){  
            $clients = [];  
            $users = []; 
            if(!Gate::denies('ramassage-commande')) {
                $factures = DB::table('factures')->where('numero','like','%'.$request->search.'%')->get();
                $clients = User::whereHas('roles', function($q){$q->where('name','client');})->get();
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

            if(!Gate::denies('ramassage-commande')) {
                $bonLivraisons = DB::table('bon_livraisons')->where('id',$id_bon)->get();
                //dd($bonLivraisons->count());
                $clients = User::whereHas('roles', function($q){$q->where('name','client');})->get();
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
                $ramasse = DB::table('commandes')->where('user_id',Auth::user()->id)->where('statut','<>','expidié')->whereDate('created_at',now())->count();
                $nonRammase = DB::table('commandes')->where('user_id',Auth::user()->id)->where('statut','expidié')->whereDate('created_at',now())->count();
        
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
            foreach($commandes as $commande){
                if(!empty(User::find($commande->user_id)))
                $users[] =  User::find($commande->user_id) ;
             
            }
            $clients = User::whereHas('roles', function($q){$q->where('name','client');})->get();  
            return view('commande.colis',['commandes' => $commandes, 
            'total'=>$total,
            'users'=> $users,
            'clients' => $clients]);
         
           
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

        $bon_livraison = DB::table('bon_livraisons')->whereDate('created_at',now())->where('user_id',Auth::user()->id)->count();
        dd(now(),$bon_livraison);
        if(gmdate("H")+1 <= 23 && gmdate("H")+1 >= 8 ){

            if($bon_livraison > 0){
                $request->session()->flash('bonLivraison');
                return redirect('/commandes');
            }



            $commande = new Commande() ;
            $statut = new Statut();
            
        $commande->telephone = $request->telephone;
        $commande->ville = $request->ville;
        $commande->adresse = $request->adresse;
        $commande->montant = $request->montant;
        $prixVille = ($request->ville==="tanger") ? 17 : 25 ;
        $prixPoids = (($request->poids==="normal") ? 0 : 9);
        $commande->prix = $prixVille + $prixPoids;
        $commande->statut = "expidié";
        $commande->colis = $request->colis;
        $commande->poids = $request->poids;
        $commande->nom = $request->nom;
        $commande->numero = substr(Auth::user()->name, - strlen(Auth::user()->name) , 3)."-".date("md-is");
        $commande->user()->associate(Auth::user())->save();
        //dd($commande->user());
        //$commande->save();
        $statut->commande_id = $commande->id;
        $statut->name = $commande->statut;
        $statut->save();
        $request->session()->flash('statut', $commande->id);


        //notification
            $user_notify = \App\User::find(1);
            $user_notify->notify(new newCommande( Auth::user() , $commande));
        }

        else{
            $request->session()->flash('avant18');
        }

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
        //return $commande;
        $statuts = DB::table('statuts')->where('commande_id',$commande->id)->get();
        //dd($commande);
        return view('commande.show', ['commande'=>$commande , 'statuts' => $statuts]);
    }



    public function content(Commande $commande){
        $content = '';
        for ($i=1; $i <= $commande->colis ; $i++) { 
            $content .= '
            <div class="container">
                        
                <h1 style="color:#E85F03">
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
                        <td>DECATHLON TANGER MEDINA(Tanger - 150620) - ECOM</td>
                    </tr>
                    </table>
                </div>
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
        
                    <img src="https://quickoo.ma/assets/img/logo.png" style="
                        WIDTH: 130PX;
                    "class="light-logo" alt="homepage" />
                    </div>
                    <div class="logo-text" style="position:absolute; left:80% ; top:480px">
        
                    <img src="https://api.qrserver.com/v1/create-qr-code/?color=E85F03&bgcolor=FFFFFF&data=https%3A%2F%2Fquickoo.ma%2F&qzone=1&margin=0&size=200x200&ecc=L" style="
                        WIDTH: 70%;
                    "class="light-logo" alt="homepage" />
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
                        border: 1px solid #e85f03;
                    }

                .container{
                    box-sizing: border-box;
                    width:100%
                    height:auto;
                    padding-top: 10px !important;
                }

                    .tableau{
                    padding-top:20px;
                    padding-bottom:5px;
                   
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
                    border: 1px solid #e85f03;
                    }

                    #customers tr:nth-child(even){
                        background-color: #f2f2f2;
                    }

                    #customers th {
                    padding-top: 12px;
                    padding-bottom: 12px;
                    
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

        if(Gate::denies('client-admin') || $commande->statut !== "expidié"){
            //dd( $commande->staut );
            $request->session()->flash('noupdate', $commande->numero);
            
        }

        else
            {
                $commande->telephone = $request->telephone;
                $commande->ville = $request->ville;
                $commande->adresse = $request->adresse;
                $commande->montant = $request->montant;
                $prixVille = ($request->ville ==="Tanger") ? 17 : 25 ;
                $prixPoids = (($request->poids==="normal") ? 0 : 9);
                $commande->prix = $prixVille + $prixPoids;
                $commande->colis = $request->colis;
                $commande->poids = $request->poids;
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
        //dd($commande);
        //$factureExist = DB::table('factures')->where('user_id',$commande->user_id )->whereDate('created_at',$commande->created_at)->count();

        if(Gate::denies('ramassage-commande') ){
            $request->session()->flash('noedit', $commande->numero);
            return redirect(route('commandes.index'));
        }
         $commande = Commande::findOrFail($id);
         $blExist = DB::table('bon_livraisons')->whereDate('created_at',$commande->created_at)->where('user_id',Auth::user()->id)->count();
        // dd($blExist);
        if($commande->statut === "expidié" && $blExist === 0)
        {
            $commande->statut= "En cours";
            $commande->save();
            $statut = new Statut();
            $statut->commande_id = $commande->id;
            $statut->name = $commande->statut;
            $statut->save();
            
            //notification
            $user_notify = \App\User::find($commande->user_id);
           $user_notify->notify(new statutChange($commande));
            //dd($test);
            $request->session()->flash('edit', $commande->numero);
        }
        else {
           
            if($commande->statut != "expidié"){
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
        if(Gate::denies('ramassage-commande') || $commande->statut === 'expidié'){
            $request->session()->flash('noedit', $commande->numero);
        }


        else{
            if($commande->statut === 'En cours'){
                $commande->statut= $request->statut;
                $commande->commentaire= $request->commentaire;
                $commande->save();
                $statut = new Statut();
                $statut->commande_id = $commande->id;
                $statut->name = $commande->statut;
                $statut->save();
                $request->session()->flash('edit', $commande->numero);
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
        if($commande->statut === "expidié") {

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
