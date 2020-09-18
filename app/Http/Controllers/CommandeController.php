<?php

namespace App\Http\Controllers;

use App\Commande;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCommande;
use App\Statut;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\User; 
use Illuminate\Support\Facades\Auth;

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
        $users = [] ;
        if(!Gate::denies('ramassage-commande')) {
            //session administrateur donc on affiche tous les commandes
            $total = DB::table('commandes')->where('deleted_at',NULL)->count();
            $commandes= DB::table('commandes')->where('deleted_at',NULL)->orderBy('created_at', 'DESC')->paginate(5);
            
        }
        else{
            $commandes= DB::table('commandes')->where('deleted_at',NULL)->where('user_id',Auth::user()->id )->orderBy('created_at', 'DESC')->paginate(5);
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
                                    'users'=> $users]);
    }


    public function filter(Request $request){
        $commandes = DB::table('commandes')->where('deleted_at',NULL);
        $users = [];

        if(Gate::denies('ramassage-commande')) { //session client donc on cherche saulement dans ses propres commandes
            $commandes->where('user_id',Auth::user()->id );
        }

        if($request->filled('statut')){
            //dd("salut");
            $commandes->where('statut','like','%'.$request->statut.'%');
           //dd($commandes->count());
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
            'users'=> $users]);
    }



    public function search(Request $request ) {

       // dd($request->filled('search'));
        $users = [] ;
        if(!Gate::denies('ramassage-commande')) {
            //session administrateur donc on affiche tous les commandes
            $total = DB::table('commandes')->where('numero','like','%'.$request->search.'%')->where('deleted_at',NULL)->count();
            $commandes= DB::table('commandes')->where('numero','like','%'.$request->search.'%')->where('deleted_at',NULL)->orderBy('created_at', 'DESC')->paginate(5);
            
        }
        else{
            $commandes= DB::table('commandes')->where('numero','like','%'.$request->search.'%')->where('deleted_at',NULL)->where('user_id',Auth::user()->id )->orderBy('created_at', 'DESC')->paginate(5);
            $total =DB::table('commandes')->where('numero','like','%'.$request->search.'%')->where('deleted_at',NULL)->where('user_id',Auth::user()->id )->count();
        }

        if($total == 0) { //recherche par statut
            if(!Gate::denies('ramassage-commande')) {
                //session administrateur donc on affiche tous les commandes
                $total = DB::table('commandes')->where('statut','like','%'.$request->search.'%')->where('deleted_at',NULL)->count();
                $commandes= DB::table('commandes')->where('statut','like','%'.$request->search.'%')->where('deleted_at',NULL)->orderBy('created_at', 'DESC')->paginate(5);
                
            }
            else{
                $commandes= DB::table('commandes')->where('statut','like','%'.$request->search.'%')->where('deleted_at',NULL)->where('user_id',Auth::user()->id )->orderBy('created_at', 'DESC')->paginate(5);
                $total =DB::table('commandes')->where('statut','like','%'.$request->search.'%')->where('deleted_at',NULL)->where('user_id',Auth::user()->id )->count();
            }
        }
        //dd($commandes);
        if($total > 0 ){
            foreach($commandes as $commande){
                if(!empty(User::find($commande->user_id)))
                $users[] =  User::find($commande->user_id) ;
             
            }
               
            return view('commande.colis',['commandes' => $commandes, 
            'total'=>$total,
            'users'=> $users]);
         
           
        }
        else {
            $request->session()->flash('search', $request->search);
            return redirect()->route('commandes.index');
        }
        
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
        //dd(!(gmdate("H")+1 <= 18));
        //dd(Auth::user()->id );
        if(gmdate("H")+1 <= 18 ){
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
        }

        else{
            $request->session()->flash('avant18');
        }

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
                $prixVille = ($request->ville==="tanger") ? 17 : 25 ;
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
        
        if(Gate::denies('ramassage-commande')){
            //dd(true);
            $request->session()->flash('noedit', $commande->numero);
            return redirect(route('commandes.index'));
        }

        if($commande->statut === "expidié")
        {
            $commande->statut= "En cours";
            $commande->save();
            $statut = new Statut();
            $statut->commande_id = $commande->id;
            $statut->name = $commande->statut;
            $statut->save();
            $request->session()->flash('edit', $commande->numero);
        }
        else $request->session()->flash('noedit', $commande->numero);

        return redirect('/commandes');
    }

    public function statutAdmin(Request $request, $id)
    {
        
        $commande = Commande::findOrFail($id);

        if(Gate::denies('ramassage-commande') || $commande->statut === 'expidié'){
            
            $request->session()->flash('noedit', $commande->numero);
            return redirect()->route('commandes.show',['commande' => $commande->id]);        }


        if($commande->statut === "éxpidié") {
            $request->session()->flash('noedit', $commande->numero);
           
        }
        else{
            
            $commande->statut= $request->statut;
            $commande->commentaire= $request->commentaire;
            $commande->save();
            $statut = new Statut();
            $statut->commande_id = $commande->id;
            $statut->name = $commande->statut;
            $statut->save();
            $request->session()->flash('edit', $commande->numero);
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
