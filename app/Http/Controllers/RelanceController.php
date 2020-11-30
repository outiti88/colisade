<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelanceController extends Controller
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
        $all = DB::table('commandes')->where('commandes.deleted_at',NULL)->where('commandes.relance','>=','0')
            ->join('users', 'users.id', '=', 'commandes.user_id')
            ->select('commandes.*','users.*')
            ->whereNotNull('users.statut')
            ->orderBy('commandes.updated_at', 'DESC')->get();


        $vip =  DB::table('commandes')->where('commandes.deleted_at',NULL)->where('commandes.relance','0')
        ->join('users', 'users.id', '=', 'commandes.user_id')
        ->select('commandes.*','users.image')
        ->whereNotNull('users.statut')
        ->orderBy('commandes.updated_at', 'DESC')->get();
            
         //dd($vip);

        $relance1 = DB::table('commandes')->where('commandes.deleted_at',NULL)->where('commandes.relance','1')
        ->join('users', 'users.id', '=', 'commandes.user_id')
        ->select('commandes.*','users.image')
        ->whereNotNull('users.statut')
        ->orderBy('commandes.updated_at', 'DESC')->get();

        $relance2 = $relance1 = DB::table('commandes')->where('commandes.deleted_at',NULL)->where('commandes.relance','2')
        ->join('users', 'users.id', '=', 'commandes.user_id')
        ->select('commandes.*','users.*')
        ->whereNotNull('users.statut')
        ->orderBy('commandes.updated_at', 'DESC')->get();

        $relance3 = $relance1 = DB::table('commandes')->where('commandes.deleted_at',NULL)->where('commandes.relance','3')
        ->join('users', 'users.id', '=', 'commandes.user_id')
            ->select('commandes.*','users.*')
            ->whereNotNull('users.statut')
            ->orderBy('commandes.updated_at', 'DESC')->get();


        return view('relance',['all'=>$all,
                                'vip'=>$vip ,
                                'relance1' => $relance1,
                                'relance2'=> $relance2,
                                'relance3' => $relance3
                                ]);
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
