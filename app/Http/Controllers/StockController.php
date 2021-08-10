<?php

namespace App\Http\Controllers;

use App\Mouvement;
use App\Produit;
use Illuminate\Http\Request;

use App\Stock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class StockController extends Controller
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
        //
    }


      public function corriger(Request $request, $id){
       if(!Gate::denies('manage-users')){
            $stock = DB::table('stocks')->where('produit_id',$id)->first();
            $oldQte = $stock->qte;
            $newQte = $request->qte;
                    $stock = Stock::findOrFail($stock->id);
                    $stock->qte = $request->qte ;
                    $stock->save();
            $mouvement = new Mouvement();
            $mouvement->type = 'inventaire';
            $mouvement->avant = $oldQte;
            $mouvement->apres = $newQte;
            $mouvement->user_id = Auth::user()->id;
            $mouvement->produit_id = $id;
            $mouvement->save();


                    $request->session()->flash('corriger', $request->qte);

        }
        else{
            $request->session()->flash('noCorriger', $request->qte);
        }
        return back();
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
    public function store(Request $request)
    {
        //
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
