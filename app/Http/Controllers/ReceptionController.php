<?php

namespace App\Http\Controllers;

use App\Produit;
use App\Reception;
use App\ReceptionProduit;
use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\User;
use Illuminate\Support\Facades\Auth;


class ReceptionController extends Controller
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
        $users = [] ;
        $stock = [];
        $produits= null ;
        if(!Gate::denies('ramassage-commande')) {
            //session administrateur donc on affiche tous les commandes
            $total = DB::table('receptions')->count();
            $receptions= DB::table('receptions')->orderBy('created_at', 'DESC')->paginate(10);
            foreach($receptions as $reception){
                if(!empty(User::find($reception->user_id)))
                $users[] =  User::find($reception->user_id) ;
            }
            //dd($clients[0]->id);
        }
        else{
            $receptions= DB::table('receptions')->where('user_id',Auth::user()->id )->orderBy('created_at', 'DESC')->paginate(10);
            $total =DB::table('receptions')->where('user_id',Auth::user()->id )->count();
            $produits= DB::table('produits')->where('user_id',Auth::user()->id )->orderBy('created_at', 'DESC')->get();

        }
       

        return view('reception.index' , [
                                'produits' => $produits, 
                                'receptions' => $receptions, 
                                'total'=>$total,
                                'users'=>$users
                                   ]);
    }

 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Gate::denies('gestion-stock')){
            return redirect()->route('produit.index');
        }
        else{
            //dd("salut");
            $reception = new Reception();
            $reception->company = $request->company ;
            $reception->etat = 'Envoyé' ;
            $reception->prevu_at = $request->prevu_at ;
            $reception->reference =  "rec-".bin2hex(substr($reception->company, - strlen($reception->company) , 3)).date("mdis");
            $reception->qte = array_sum($request->qte) ;
            $reception->colis = count($request->produit);
            $reception->user()->associate(Auth::user())->save();

            foreach($request->produit as $index => $produit){

                $stock = DB::table('stocks')->where('produit_id',$produit)->first();
                $stock = Stock::find($stock->id);
                $stock->cmd = $request->qte[$index];
                $stock->save();
                $reception_produit = new ReceptionProduit();
                $reception_produit->reception_id = $reception->id ;
                $reception_produit->produit_id = $produit ;
                $reception_produit->qte = $request->qte[$index];
                $reception_produit->save();
            }


            return redirect()->route('reception.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
