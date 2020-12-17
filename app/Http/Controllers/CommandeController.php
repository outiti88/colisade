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
use App\Relance;
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
        $livreurs = User::whereHas('roles', function($q){$q->whereIn('name', ['livreur']);})->get();
        $nouveau =  User::whereHas('roles', function($q){$q->whereIn('name', ['nouveau']);})->where('deleted_at',NULL)->count();

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
            //dd("test");
            $total =DB::table('commandes')
            ->join('users', 'users.id', '=', 'commandes.user_id')
            ->select('commandes.*','users.image')
            ->where('commandes.deleted_at',NULL)->whereIn('commandes.statut', ['envoyée', 'Ramassée', 'Reçue'])
            ->where('users.ville',Auth::user()->ville)
            ->orWhere(function($query) {
                $query->where('commandes.ville',Auth::user()->ville)
                      ->whereNotIn('commandes.statut', ['envoyée','Ramassée','Recue']);
            })->count();

            $commandes= DB::table('commandes')
            ->join('users', 'users.id', '=', 'commandes.user_id')
            ->select('commandes.*','users.image')
            ->where('commandes.deleted_at',NULL)->whereIn('commandes.statut', ['envoyée', 'Ramassée', 'Reçue'])
            ->where('users.ville',Auth::user()->ville)
            ->orWhere(function($query) {
                $query->where('commandes.ville',Auth::user()->ville)
                      ->whereNotIn('commandes.statut', ['envoyée','Ramassée','Recue']);
            })->orderBy('commandes.updated_at', 'DESC')->paginate(10);

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
        return view('commande.colis',['nouveau'=>$nouveau,'commandes' => $commandes, 
                                    'total'=>$total,
                                    'users'=> $users,
                                    'clients' => $clients,
                                    'livreurs'=>$livreurs,
                                    'produits'=>$produits]);
    }


    public function filter(Request $request){
       
        $commandes = DB::table('commandes')->where('commandes.deleted_at',NULL);
        $clients = User::whereHas('roles', function($q){$q->whereIn('name', ['client', 'ecom']);})->get();
        $livreurs = User::whereHas('roles', function($q){$q->whereIn('name', ['livreur']);})->get();
        $nouveau =  User::whereHas('roles', function($q){$q->whereIn('name', ['nouveau']);})->where('deleted_at',NULL)->count();

        $users = [];
        $produits = [];

        if(!Gate::denies('ecom')){
            $produits = Produit::where('user_id',Auth::user()->id)->get();
            //dd($produits);
        }

        if(Gate::denies('ramassage-commande')) { //session client donc on cherche saulement dans ses propres commandes
            $commandes->where('user_id',Auth::user()->id );
            $clients = null;
            $livreurs = null;
        }

        if($request->filled('statut')){
            //dd("salut");
            if(!Gate::denies('livreur')){
                $Ramassage = array("envoyée", "Ramassée", "Reçue");
                if(in_array($request->statut,$Ramassage)){
                    $commandes->join('users', 'users.id', '=', 'commandes.user_id')
                    ->select('commandes.*','users.image')
                    ->where('users.ville',Auth::user()->ville);
                }
                else{
                    $commandes->where('commandes.ville',Auth::user()->ville);
                }
                $commandes->where('commandes.statut',$request->statut);
            }
            else{
                if($request->statut === 'en cours' )
                $commandes->whereIn('statut', array('Reporté', 'Relancée', 'Modifiée','en cours'));
                else
                $commandes->where('statut','like','%'.$request->statut.'%');
            }
            
           //dd($commandes->count());
        }

        if($request->filled('client')){
            $commandes->where('user_id',$request->client);
        }

        if($request->filled('livreur')){
            $livreur =  User::find($request->livreur);
            $commandes->where('ville',$livreur->ville);
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
            $commandes->whereDate('created_at','>=',$request->dateMin)
                ->orWhereDate('postponed_at','>=',$request->dateMin);
        }
        if($request->filled('dateMax')){
            $commandes->whereDate('created_at','<=',$request->dateMax)
                ->orWhereDate('postponed_at','<=',$request->dateMax);
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
        'nouveau'=>$nouveau,
            'total'=>$total,
            'users'=> $users,
            'clients' => $clients,
            'produits' => $produits,
            'livreurs'=>$livreurs

            ]);
    }



    public function search(Request $request ) {
        $nouveau =  User::whereHas('roles', function($q){$q->whereIn('name', ['nouveau']);})->where('deleted_at',NULL)->count();
        if(Gate::denies('livreur')){
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
                    return view('facture',['factures'=>$factures ,'nouveau'=>$nouveau,
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
                $ramasse = DB::table('commandes')->where('user_id',Auth::user()->id)->where('statut','Rammasée')->where('traiter','0')->count();
                $nonRammase = DB::table('commandes')->where('user_id',Auth::user()->id)->where('statut','envoyée')->where('traiter','0')->count();
        
                return view('bonLivraison',['bonLivraisons'=>$bonLivraisons ,'nouveau'=>$nouveau,
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
    }


        $users = [] ;
        $produits = [];
        if(!Gate::denies('manage-users')) {
            //session administrateur donc on affiche tous les commandes
            $total = DB::table('commandes')->where('numero','like','%'.$request->search.'%')->where('deleted_at',NULL)->count();
            $commandes= DB::table('commandes')->where('numero','like','%'.$request->search.'%')->where('deleted_at',NULL)->orderBy('created_at', 'DESC')->paginate(10);
            
        }
        elseif(!Gate::denies('livreur')){
            $Ramassage = array("envoyée", "Ramassée", "Reçue");
            $commande= DB::table('commandes')->where('numero',$request->search)->where('deleted_at',NULL)->first();
           // dd($commande->statut);
            if(in_array($commande->statut,$Ramassage)){
                $commandes =DB::table('commandes')->where('commandes.deleted_at',NULL)
                ->join('users', 'users.id', '=', 'commandes.user_id')
                ->select('commandes.*','users.image')
                ->where('users.ville',Auth::user()->ville)->where('numero',$request->search)
                ->orderBy('commandes.created_at', 'DESC')->paginate(10);

                $total = DB::table('commandes')->where('commandes.deleted_at',NULL)
                ->join('users', 'users.id', '=', 'commandes.user_id')
                ->select('commandes.*','users.image')
                ->where('users.ville',Auth::user()->ville)->where('numero',$request->search)
                ->count();
            }
            else{
                $commandes =DB::table('commandes')->where('commandes.deleted_at',NULL)
                ->where('commandes.ville',Auth::user()->ville)->where('numero',$request->search)
                ->orderBy('commandes.created_at', 'DESC')->paginate(10);

                $total =DB::table('commandes')->where('commandes.deleted_at',NULL)
                ->where('commandes.ville',Auth::user()->ville)->where('numero',$request->search)
                ->count();
            }


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
            $livreurs = User::whereHas('roles', function($q){$q->whereIn('name', ['livreur']);})->get();

            $clients = User::whereHas('roles', function($q){$q->whereIn('name', ['client', 'ecom']);})->get();  
            return view('commande.colis',['commandes' => $commandes, 'nouveau'=> $nouveau,
            'total'=>$total,
            'users'=> $users,
            'clients' => $clients,
            'produits' => $produits,
            'livreurs'=>$livreurs
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

            if($fournisseur->prix === 0){

                $ville= array(
                    "Martil" => "45,00 DH" ,
                        "M'diq" => "45,00 DH" ,
                        "Fnideq" => "45,00 DH" ,
                        "larache" => "45,00 DH" ,
                        "Ksar lkbir" => "50,00 DH" ,
                        "Ksar sghir" => "50,00 DH" ,
                        "Assilah" => "50,00 DH" ,
                        "Al Hoceima" => "50,00 DH" ,
                        "Bab bered" => "50,00 DH" ,
                        "Bab taza" => "50,00 DH" ,
                        "Dardara" => "50,00 DH" ,
                        "Akchour" => "50,00 DH" ,
                        "Tetouan" => "40,00 DH" ,
                        "Taza" => "40,00 DH" ,
                        "Casablanca" => "30,00 DH" ,
                        "Marrakech" => "40,00 DH" ,
                        "Fès" => "35,00 DH" ,
                        "Tiznit" => "45,00 DH" ,
                        "Taroudant" => "45,00 DH" ,
                        "Haouara" => "45,00 DH" ,
                        "Belfaa" => "45,00 DH" ,
                        "Massa" => "45,00 DH" ,
                        "Khmis Ait Amira" => "45,00 DH" ,
                        "Sidi Bibi" => "45,00 DH" ,
                        "Bikra" => "45,00 DH" ,
                        "Oulad Tayma" => "45,00 DH" ,
                        "El-Hajeb" => "40,00 DH" ,
                        "Boufakrane" => "45,00 DH" ,
                        "Sabaa Aiyoun" => "45,00 DH",
                        "Azrou" => "45,00 DH" ,
                        "El Hadj Kaddour" => "45,00 DH" ,
                        "Ifrane" => " 40,00 DH" ,
                        "Imouzar" => " 45,00 DH" ,
                        "Ain Leuh" => " 45,00 DH" ,
                        "Moulay Idriss Zerhoun" => " 45,00 DH" ,
                        "Ain karma" => " 45,00 DH" ,
                        "Ain Taoujdate" => " 45,00 DH" ,
                        "EL mhaya" => " 45,00 DH" ,
                        "Sidi Addi" => " 45,00 DH" ,
                        "Tiflet" => "45,00 DH " ,
                        "Tarfaya" => " 45,00 DH" ,
                        "Boujdour" => "45,00 DH " ,
                        "Es -semara" => "45,00 DH " ,
                        "Dakhla" => "45,00 DH " ,
                        "Sidi  Yahya El GHarb" => "45,00 DH " ,
                        "Sidi  Yahya des zaer" => "45,00 DH " ,
                        "Temara" => "30,00 DH " ,
                        "Sale" => "30,00 DH " ,
                        "Ain El Aouda" => " 30,00 DH" ,
                        "Sale EL-jadida" => "30,00 DH " ,
                        "Ain Atiq" => "45,00 DH" ,
                        "Tamsna" => "45,00 DH" ,
                        "Mers El kheir" => "45,00 DH" ,
                        "Bouknadal" => "45,00 DH" ,
                        "Skhirat" => "45,00 DH" ,
                        "Sidi Taibi" => "45,00 DH" ,
                        "Kenitra" => "40,00 DH" ,
                        "Sidi slimane" => "45,00 DH" ,
                        "Sidi kacem" => "45,00 DH" ,
                        "Berkan" => " 50,00 DH" ,
                        "Aklim" => "50,00 DH " ,
                        "Cafemor-chouihia" => " 50,00 DH" ,
                        "Saidia" => "50,00 DH " ,
                        "Ahfir" => "50,00 DH " ,
                        "Taourirt" => " 50,00 DH" ,
                        "Beni drar" => "50,00 DH" ,
                        "Bni Oukil" => "50,00 DH" ,
                        "Jerada" => "50,00 DH" ,
                        "Laayoune" => "50,00 DH" ,
                        "Ejdar" => "50,00 DH" ,
                        "Ihddaden" => "50,00 DH" ,
                        "Touima" => "50,00 DH" ,
                        "bouraj" => "50,00 DH" ,
                        "Bni Ensar" => "50,00 DH" ,
                        "Farkhana" => "50,00 DH" ,
                        "Beni chiker" => "50,00 DH" ,
                        "bouaarek" => "50,00 DH" ,
                        "selouane" => "50,00 DH" ,
                        "zghanghan" => "50,00 DH" ,
                        "Arekmane" => "50,00 DH" ,
                        "El Aroui" => "50,00 DH" ,
                        "Safi" => "40,00 DH" ,
                        "Essaouira" => "40,00 DH" ,
                        "Chichaoua" => "45,00 DH" ,
                        "Tamnsourt" => "45,00 DH" ,
                        "Oudaya (Marrakech)" => "45,00 DH" ,
                        "Douar Lahna" => "" ,
                        "Douar  Sidi Moussa" => "45,00 DH" ,
                        "Belaaguid" => "45,00 DH" ,
                        "Dar Tounssi" => "45,00 DH" ,
                        "Chouiter" => "45,00 DH" ,
                        "Sidi Zouine" => "45,00 DH" ,
                        "Tamesloht" => "45,00 DH" ,
                        "Ait Ourir" => "45,00 DH" ,
                        "Tahannaout" => "45,00 DH" ,
                        "Tit Melil" => "45,00 DH" ,
                        "Mediouna" => "45,00 DH" ,
                        "Bouskoura" => "45,00 DH" ,
                        "Mohammedia" => "40,00 DH" ,
                        "Echellalat" => "50,00 DH" ,
                        "Deroua" => "50,00 DH" ,
                        "Nouacer" => "50,00 DH" ,
                        "Dar bouaaza" => "50,00 DH" ,
                        "Tamaris" => "50,00 DH" ,
                        "Al rahma" => "45,00 DH" ,
                        "Ouad zem" => "50,00 DH" ,
                        "Boujniba" => "50,00 DH" ,
                        "Boulnouar" => "50,00 DH" ,
                        "Fini" => "50,00 DH" ,
                        "Beni Mellal" => "40,00 DH" ,
                        "Ouarzazate" => "50,00 DH" ,
                        "Tghsaline" => "45,00 DH" ,
                        "Ait Ishaq" => "45,00 DH" ,
                        "Lakbab" => "45,00 DH" ,
                        "lahri" => "45,00 DH" ,
                        "Mrirt" => "45,00 DH" ,
                        "Settat" => "40,00 DH" ,
                        "sidi bouzid" => "40,00 DH" ,
                        "Moulay abedellah" => "45,00 DH" ,
                        "sidi aabed (eljadida)" => "45,00 DH" ,
                        "azmour" => "45,00 DH" ,
                        "Bir jdid" => "45,00 DH" ,
                        "Msewar rassou" => "50,00 DH" ,
                        "Sidi Ismail" => "50,00 DH" ,
                        "Sidi Benour" => "50,00 DH" ,
                        "Khmis Zmamra" => "50,00 DH" ,
                        "Oulad  frej" => "50,00 DH" ,
                        "Chefchaouen" => "40,00 DH" ,
                        "Elbradiya" => "45,00 DH" ,
                        "Ihrem Laalam" => "45,00 DH" ,
                        "Elfkih ben saleh" => "45,00 DH" ,
                        "Souk essabt/ oulad nema" => "45,00 DH" ,
                        "Azilal" => "50,00DH" ,
                        "Ouaouizght" => "45,00DH" ,
                        "Khnifra" => "45,00 DH" ,
                        "Ben louidane" => "50,00 DH" ,
                        "Zauiyat Echikh" => "50,00 DH" ,
                        "Tadla" => "50,00 DH" ,
                        "Afourar" => "50,00 DH" ,
                        "Laayata" => "50,00 DH" ,
                        "Oulad  Youssef" => "50,00 DH" ,
                        "Adouz" => "50,00 DH" ,
                        "Sidi  Jaber" => "50,00 DH" ,
                        "Ooulad  Zidouh" => "50,00 DH" ,
                        "Lakssiba" => "50,00 DH" ,
                        "Beni  Aayat" => "50,00 DH" ,
                        "Oulad  Aayad" => "50,00 DH" ,
                        "Tagzirt" => "50,00 DH" ,
                        "Sidi Issa" => "50,00 DH" ,
                        "Oulad M'barek" => "50,00 DH" ,
                        "Oulad  Zam" => "50,00 DH" ,
                        "Agadir" => "40,00 DH" ,
                        "Oulad Ayach" => "50,00 DH" ,
                        "Foum Nsser" => "50,00 DH ",
                        "Tanougha" => "50,00 DH ",
                        "Taounate" => "50,00 DH ",
                        "Tahla" => " 45,00DH",
                        "Guercif" => " 45,00DH",
                        "Ouad  Amlil" => " 45,00DH",
                        "Essaouira" => " 40,00 DH",
                        "Berchid" => " 40,00 DH",
                        "Bouznika" => " 40,00 DH",
                        "Tanger" => " 40,00 DH",
                        "Guelmim" => " 50.00 DH",
                        "Tan Tan" => " 50.00 DH",
                        "Tan Tan plage" => " 50.00 DH",
                        "Sidi ifni" => " 50.00 DH",
                        "Ait lmour" => " 45.00DH",
                        "Souk Larbaa" => " 45.00DH",
                        "Rabat" => "25.00 DH ",
                        "Driouach" => "60,00 DH ",
                        "Errachidia" => " 50,00 DH",
                        "Khmiset" => " 50,00 DH",
                        "Ben Slimane" => " 50,00 DH",
                        "Ouazzane" => "45,00 DH ",
                        "Sefrou" => " 45,00 DH",
                        "Sidi benour" => " 50,00 DH",
                        "Had Hrara" => " 60,00 DH",
                        "Zrarda" => "45,00 DH ",
                        "Zoumi" => "50 ,00 DH ",
                        "Mokrissat" => "50 ,00 DH ",
                        "Souk ELaha" => "50 ,00 DH ",
                        "Ain Dorij" => "50 ,00 DH ",
                        "Sidi redouane" => "50 ,00 DH ",
                        "Massmouda" => " 50 ,00 DH", 
                        "Sidi Rahal" => " 45 ,00 DH",
                        "Had Soualem" => " 45 ,00 DH",
                        "Oujda" => "40 ,00 DH ",
                        "Sefrou" => " 45 ,00 DH",
                        "Oulad tayeb" => "40,00  DH ",
                        "Ain chekaf" => "40,00  DH ",
                        "Ain chegag" => " 50,00 DH",
                        "Bel ksir" => " 50,00 DH", 
                        "Meknès" => "40,00  DH ",
                        "Sidi Hrazem" => "50,00 DH ",
                        "Nador" => "40,00  DH ",
                            "Khouribga" => "40,00 DH"
                        
                );
                if(array_key_exists($request->ville,$ville)){
                    $commande->prix = $ville[$request->ville];
                }
                else{
                    return back();
                }
            }
            else{
                $commande->prix = $fournisseur->prix;
            }

            
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
        $commande->statut = "envoyée";
        $commande->colis = $request->colis;
        $commande->poids = '';
        $commande->nom = $request->nom;
        $commande->traiter = 0;
        $commande->facturer = 0;
        $commande->numero = substr($fournisseur->name, - strlen($fournisseur->name) , 3)."-".date("md-is");

        if(!Gate::denies('ecom')){
            if(!isset($request->produit)){
                //dd("salut");
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
        $nouveau =  User::whereHas('roles', function($q){$q->whereIn('name', ['nouveau']);})->where('deleted_at',NULL)->count();
        $etat = array("Injoignable", "Refusée", "Retour Complet");
        if((Gate::denies('client-admin') || $commande->statut !== "envoyée") && (Gate::denies('manage-users') || !in_array($commande->statut, $etat)) ){
            
            $modify = 0;
        }
        else $modify = 1;

        if(!Gate::denies('livreur')){
            if($commande->ville!== Auth::user()->ville)
            return redirect()->route('commandes.index');
        }

        if(Gate::denies('ramassage-commande')){
            if($commande->user_id !== Auth::user()->id)
            return redirect()->route('commandes.index');
        }
        
        $etat = array("Injoignable", "Refusée", "Retour Complet");

        
        //return $commande;
        //dd($produits);
        $statuts = DB::table('statuts')->where('commande_id',$commande->id)->get();
        foreach($statuts as $statut){
            $users[] =  User::find($statut->user_id) ;
        }
        $total = DB::table('relances')->where('commande_id',$commande->id)->count();
        $relances = DB::table('relances')->where('commande_id',$commande->id)->get();
        $Rpar = null;
        foreach($relances as $relance){
            $Rpar[] =  User::find($relance->user_id) ; //relancée par
        }

        if(!Gate::denies('gestion-stock')){
            $produits = [] ;
            $liaisons = DB::table('commande_produits')->where('commande_id',$commande->id)->get();
            foreach($liaisons as $produit){
            $produits[] = Produit::find($produit->produit_id);
        }
        return view('commande.show', ['commande'=>$commande , 'statuts' => $statuts , 'nouveau'=>$nouveau,
                                    'par' => $users,
                                    'produits' => $produits,
                                    'liaisons' => $liaisons,
                                    'relances' => $relances,
                                    'Rpar' => $Rpar,
                                    'Rtotal' => $total,
                                    'modify' => $modify
                                    ]);

        }   
        //dd($users);
        return view('commande.show', ['commande'=>$commande , 'statuts' => $statuts , 'nouveau'=>$nouveau,
                                    'par' => $users,
                                    'relances' => $relances,
                                    'Rpar' => $Rpar,
                                    'Rtotal' => $total,
                                    'modify' => $modify
                                    ]);
    }



    public function content(Commande $commande){
        $content = '';
        $user = DB::table('users')->find($commande->user_id);
        
        if($commande->montant == 0) $montant = "Payé par Carte bancaire";
        else $montant = ($commande->montant+$commande->prix) .' DH';

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
                        <td>Colisade Delivery</td>
                    </tr>
                    <tr>
                        <th>Site web:  </th>
                        <td>www.colisade.ma</td>
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
        <head> <meta charset="UTF-8">
            <title>Ticket de la commande: '.$commande->numero.'</title>

        </head>
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
            

       
        $pdf -> loadHTML($style.$content)->setPaper('A7');


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
        $etat = array("Injoignable", "Refusée", "Retour Complet");
        $ancienne = $commande->statut;
        if((Gate::denies('client-admin') || $commande->statut !== "envoyée") && (Gate::denies('manage-users') || !in_array($commande->statut, $etat)) ){
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


                if($commande->user()->first()->prix === 0){
                    $ville= array(
                        "Martil" => "45,00 DH" ,
                            "M'diq" => "45,00 DH" ,
                            "Fnideq" => "45,00 DH" ,
                            "larache" => "45,00 DH" ,
                            "Ksar lkbir" => "50,00 DH" ,
                            "Ksar sghir" => "50,00 DH" ,
                            "Assilah" => "50,00 DH" ,
                            "Al Hoceima" => "50,00 DH" ,
                            "Bab bered" => "50,00 DH" ,
                            "Bab taza" => "50,00 DH" ,
                            "Dardara" => "50,00 DH" ,
                            "Akchour" => "50,00 DH" ,
                            "Tetouan" => "40,00 DH" ,
                            "Taza" => "40,00 DH" ,
                            "Casablanca" => "30,00 DH" ,
                            "Marrakech" => "40,00 DH" ,
                            "Fès" => "35,00 DH" ,
                            "Tiznit" => "45,00 DH" ,
                            "Taroudant" => "45,00 DH" ,
                            "Haouara" => "45,00 DH" ,
                            "Belfaa" => "45,00 DH" ,
                            "Massa" => "45,00 DH" ,
                            "Khmis Ait Amira" => "45,00 DH" ,
                            "Sidi Bibi" => "45,00 DH" ,
                            "Bikra" => "45,00 DH" ,
                            "Oulad Tayma" => "45,00 DH" ,
                            "El-Hajeb" => "40,00 DH" ,
                            "Boufakrane" => "45,00 DH" ,
                            "Sabaa Aiyoun" => "45,00 DH",
                            "Azrou" => "45,00 DH" ,
                            "El Hadj Kaddour" => "45,00 DH" ,
                            "Ifrane" => " 40,00 DH" ,
                            "Imouzar" => " 45,00 DH" ,
                            "Ain Leuh" => " 45,00 DH" ,
                            "Moulay Idriss Zerhoun" => " 45,00 DH" ,
                            "Ain karma" => " 45,00 DH" ,
                            "Ain Taoujdate" => " 45,00 DH" ,
                            "EL mhaya" => " 45,00 DH" ,
                            "Sidi Addi" => " 45,00 DH" ,
                            "Tiflet" => "45,00 DH " ,
                            "Tarfaya" => " 45,00 DH" ,
                            "Boujdour" => "45,00 DH " ,
                            "Es -semara" => "45,00 DH " ,
                            "Dakhla" => "45,00 DH " ,
                            "Sidi  Yahya El GHarb" => "45,00 DH " ,
                            "Sidi  Yahya des zaer" => "45,00 DH " ,
                            "Temara" => "30,00 DH " ,
                            "Sale" => "30,00 DH " ,
                            "Ain El Aouda" => " 30,00 DH" ,
                            "Sale EL-jadida" => "30,00 DH " ,
                            "Ain Atiq" => "45,00 DH" ,
                            "Tamsna" => "45,00 DH" ,
                            "Mers El kheir" => "45,00 DH" ,
                            "Bouknadal" => "45,00 DH" ,
                            "Skhirat" => "45,00 DH" ,
                            "Sidi Taibi" => "45,00 DH" ,
                            "Kenitra" => "40,00 DH" ,
                            "Sidi slimane" => "45,00 DH" ,
                            "Sidi kacem" => "45,00 DH" ,
                            "Berkan" => " 50,00 DH" ,
                            "Aklim" => "50,00 DH " ,
                            "Cafemor-chouihia" => " 50,00 DH" ,
                            "Saidia" => "50,00 DH " ,
                            "Ahfir" => "50,00 DH " ,
                            "Taourirt" => " 50,00 DH" ,
                            "Beni drar" => "50,00 DH" ,
                            "Bni Oukil" => "50,00 DH" ,
                            "Jerada" => "50,00 DH" ,
                            "Laayoune" => "50,00 DH" ,
                            "Ejdar" => "50,00 DH" ,
                            "Ihddaden" => "50,00 DH" ,
                            "Touima" => "50,00 DH" ,
                            "bouraj" => "50,00 DH" ,
                            "Bni Ensar" => "50,00 DH" ,
                            "Farkhana" => "50,00 DH" ,
                            "Beni chiker" => "50,00 DH" ,
                            "bouaarek" => "50,00 DH" ,
                            "selouane" => "50,00 DH" ,
                            "zghanghan" => "50,00 DH" ,
                            "Arekmane" => "50,00 DH" ,
                            "El Aroui" => "50,00 DH" ,
                            "Safi" => "40,00 DH" ,
                            "Essaouira" => "40,00 DH" ,
                            "Chichaoua" => "45,00 DH" ,
                            "Tamnsourt" => "45,00 DH" ,
                            "Oudaya (Marrakech)" => "45,00 DH" ,
                            "Douar Lahna" => "" ,
                            "Douar  Sidi Moussa" => "45,00 DH" ,
                            "Belaaguid" => "45,00 DH" ,
                            "Dar Tounssi" => "45,00 DH" ,
                            "Chouiter" => "45,00 DH" ,
                            "Sidi Zouine" => "45,00 DH" ,
                            "Tamesloht" => "45,00 DH" ,
                            "Ait Ourir" => "45,00 DH" ,
                            "Tahannaout" => "45,00 DH" ,
                            "Tit Melil" => "45,00 DH" ,
                            "Mediouna" => "45,00 DH" ,
                            "Bouskoura" => "45,00 DH" ,
                            "Mohammedia" => "40,00 DH" ,
                            "Echellalat" => "50,00 DH" ,
                            "Deroua" => "50,00 DH" ,
                            "Nouacer" => "50,00 DH" ,
                            "Dar bouaaza" => "50,00 DH" ,
                            "Tamaris" => "50,00 DH" ,
                            "Al rahma" => "45,00 DH" ,
                            "Ouad zem" => "50,00 DH" ,
                            "Boujniba" => "50,00 DH" ,
                            "Boulnouar" => "50,00 DH" ,
                            "Fini" => "50,00 DH" ,
                            "Beni Mellal" => "40,00 DH" ,
                            "Ouarzazate" => "50,00 DH" ,
                            "Tghsaline" => "45,00 DH" ,
                            "Ait Ishaq" => "45,00 DH" ,
                            "Lakbab" => "45,00 DH" ,
                            "lahri" => "45,00 DH" ,
                            "Mrirt" => "45,00 DH" ,
                            "Settat" => "40,00 DH" ,
                            "sidi bouzid" => "40,00 DH" ,
                            "Moulay abedellah" => "45,00 DH" ,
                            "sidi aabed (eljadida)" => "45,00 DH" ,
                            "azmour" => "45,00 DH" ,
                            "Bir jdid" => "45,00 DH" ,
                            "Msewar rassou" => "50,00 DH" ,
                            "Sidi Ismail" => "50,00 DH" ,
                            "Sidi Benour" => "50,00 DH" ,
                            "Khmis Zmamra" => "50,00 DH" ,
                            "Oulad  frej" => "50,00 DH" ,
                            "Chefchaouen" => "40,00 DH" ,
                            "Elbradiya" => "45,00 DH" ,
                            "Ihrem Laalam" => "45,00 DH" ,
                            "Elfkih ben saleh" => "45,00 DH" ,
                            "Souk essabt/ oulad nema" => "45,00 DH" ,
                            "Azilal" => "50,00DH" ,
                            "Ouaouizght" => "45,00DH" ,
                            "Khnifra" => "45,00 DH" ,
                            "Ben louidane" => "50,00 DH" ,
                            "Zauiyat Echikh" => "50,00 DH" ,
                            "Tadla" => "50,00 DH" ,
                            "Afourar" => "50,00 DH" ,
                            "Laayata" => "50,00 DH" ,
                            "Oulad  Youssef" => "50,00 DH" ,
                            "Adouz" => "50,00 DH" ,
                            "Sidi  Jaber" => "50,00 DH" ,
                            "Ooulad  Zidouh" => "50,00 DH" ,
                            "Lakssiba" => "50,00 DH" ,
                            "Beni  Aayat" => "50,00 DH" ,
                            "Oulad  Aayad" => "50,00 DH" ,
                            "Tagzirt" => "50,00 DH" ,
                            "Sidi Issa" => "50,00 DH" ,
                            "Oulad M'barek" => "50,00 DH" ,
                            "Oulad  Zam" => "50,00 DH" ,
                            "Agadir" => "40,00 DH" ,
                            "Oulad Ayach" => "50,00 DH" ,
                            "Foum Nsser" => "50,00 DH ",
                            "Tanougha" => "50,00 DH ",
                            "Taounate" => "50,00 DH ",
                            "Tahla" => " 45,00DH",
                            "Guercif" => " 45,00DH",
                            "Ouad  Amlil" => " 45,00DH",
                            "Essaouira" => " 40,00 DH",
                            "Berchid" => " 40,00 DH",
                            "Bouznika" => " 40,00 DH",
                            "Tanger" => " 40,00 DH",
                            "Guelmim" => " 50.00 DH",
                            "Tan Tan" => " 50.00 DH",
                            "Tan Tan plage" => " 50.00 DH",
                            "Sidi ifni" => " 50.00 DH",
                            "Ait lmour" => " 45.00DH",
                            "Souk Larbaa" => " 45.00DH",
                            "Rabat" => "25.00 DH ",
                            "Driouach" => "60,00 DH ",
                            "Errachidia" => " 50,00 DH",
                            "Khmiset" => " 50,00 DH",
                            "Ben Slimane" => " 50,00 DH",
                            "Ouazzane" => "45,00 DH ",
                            "Sefrou" => " 45,00 DH",
                            "Sidi benour" => " 50,00 DH",
                            "Had Hrara" => " 60,00 DH",
                            "Zrarda" => "45,00 DH ",
                            "Zoumi" => "50 ,00 DH ",
                            "Mokrissat" => "50 ,00 DH ",
                            "Souk ELaha" => "50 ,00 DH ",
                            "Ain Dorij" => "50 ,00 DH ",
                            "Sidi redouane" => "50 ,00 DH ",
                            "Massmouda" => " 50 ,00 DH", 
                            "Sidi Rahal" => " 45 ,00 DH",
                            "Had Soualem" => " 45 ,00 DH",
                            "Oujda" => "40 ,00 DH ",
                            "Sefrou" => " 45 ,00 DH",
                            "Oulad tayeb" => "40,00  DH ",
                            "Ain chekaf" => "40,00  DH ",
                            "Ain chegag" => " 50,00 DH",
                            "Bel ksir" => " 50,00 DH", 
                            "Meknès" => "40,00  DH ",
                            "Sidi Hrazem" => "50,00 DH ",
                            "Nador" => "40,00  DH ",
                                "Khouribga" => "40,00 DH"
                            
                    );
                    if(array_key_exists($request->ville,$ville)){
                        $commande->prix = $ville[$request->ville];
                    }
                    else{
                        return back();
                    }
                }

                
                $commande->telephone = $request->telephone;
                $commande->ville = $request->ville;
                $commande->adresse = $request->adresse;
                $commande->secteur = $request->ville;
                //dd($request->secteur);
                
                
                $commande->colis = $request->colis;
                $commande->nom = $request->nom;
                
                if(!Gate::denies('manage-users') && in_array($ancienne, $etat)){
                    $commande->statut = "Modifiée";
                    $commande->relance =null;
                    $commande->save();
                    $statut = new Statut();
                    $statut->commande_id = $commande->id;
                    $statut->name = $commande->statut;
                    $statut->user()->associate(Auth::user())->save();
                }
                else $commande->save();
               
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
            // commande est envoyée + traiter = 0         
        // dd($blExist);
        
        if(($commande->statut === "envoyée" || $commande->statut === "Reçue" || $commande->statut === "Ramassée" || $commande->statut === "Expidiée") )
        {
            $user_ville = User::findOrFail($commande->user_id);
            if( $commande->traiter == 0){
                if ($commande->statut === "envoyée") {
                    $commande->statut= "Ramassée"; 
                }
                else{
                    $request->session()->flash('blNongenere', $commande->numero);
                    return back();
                }
            }
        else{
                if ($commande->statut === "Ramassée") {
                    if(!Gate::denies('livreur')) return back();
                    $commande->statut= "Reçue"; 
                }
    
                elseif ($commande->statut === "Reçue") {
                   // dd(!Gate::denies('livreur'));

                    if(!Gate::denies('livreur')) return back();
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

    public function retourStock($id){
        $commande = Commande::findOrFail($id);

        if($commande->statut === "Retour Complet" || $commande->statut === "Annulée" || $commande->statut === "Refusée"){
            $commande->statut = "Retour en stock";
            $statut = new Statut();
            $statut->commande_id = $commande->id;
            $statut->name = $commande->statut;
            //dd($user);
            $commande->relance = 0;
            $commande_produits = DB::table('commande_produits')->where('commande_id',$commande->id)->get();
            $statut->user()->associate(Auth::user())->save();
            $commande->save();
            foreach($commande_produits as $commande_produit){
            //dd($commande_produit);
            $stock = Stock::where('produit_id',$commande_produit->produit_id)->first();
            $stock->qte += $commande_produit->qte;
            $stock->save();
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
            if(($commande->statut === 'En cours' || $commande->statut === 'Modifiée' || $commande->statut === 'Relancée' || $commande->statut === 'Reporté') && $commande->traiter > 0){ //bach traiter commande khass tkoun en cours w bl dyalha kyn
                $commande->statut= $request->statut;
                $commande->commentaire= $request->commentaire;
                if($commande->statut === 'Reporté'){
                    if($request->filled('prevu_at')) $commande->postponed_at = $request->prevu_at;
                    else $request->prevu_at = now() ;
                }
                $statut = new Statut();
                $statut->commande_id = $commande->id;
                $statut->name = $commande->statut;
                $statut->user()->associate(Auth::user())->save();
                $request->session()->flash('edit', $commande->numero);

               
                $commande->save();
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


    public function relancer(Request $request, $id){
        if(!Gate::denies('ramassage-commande')) {
            $commande = Commande::findOrFail($id);
            $total = DB::table('relances')->where('commande_id',$commande->id)->count();
            if($total < 3){
                $relance = new Relance();
            $relance->commande_id = $commande->id;
            $relance->comment = $request->comment;
            $relance->user()->associate(Auth::user())->save();
            $request->session()->flash('relance', $commande->numero);

            }

        }

        return back();
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
            $etat = array("Injoignable", "Refusée", "Retour Complet");
        
            
        if($commande->statut === "envoyée" || (!Gate::denies('manage-users') && in_array($commande->statut, $etat)) ) {

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