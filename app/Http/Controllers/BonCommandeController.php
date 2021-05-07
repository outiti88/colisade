<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BonCommandeController extends Controller
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
    public function index(Request $request)
    {
        $commandes = DB::table('commandes')->where('commandes.deleted_at', NULL)->whereIn('commandes.id', $request->btSelectItem);
        $this->gen($request->btSelectItem);
        //dd(count($request->btSelectItem));
    }

    public function commandes($request, $n, $i)
    {
        $ids = $request->btSelectItem;
        $date = date("j, n, Y");
        $commandes = DB::table('commandes')->where('commandes.deleted_at', NULL)->whereIn('commandes.id', $ids)->get();

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
                 </tr>
        ';
        foreach ($commandes as $index => $commande) {
            if (($index >= $i * 12) && ($index < 12 * ($i + 1))) { //les infromations de la table depe,d de la page actuelle

                if ($commande->statut === 'envoyée') {
                    $commande->prix = 0;
                }
                if ($commande->montant == 0) {
                    $montant = "Payée Par CB";
                } else {
                    $montant = $commande->montant;
                }
                $content .= '<tr>' . '
            <td>' . $commande->numero . '</td>
            <td>' . $commande->nom . '</td>
            <td>' . $commande->ville . '</td>
            <td>' . $commande->telephone . '</td>
            <td>' . $montant . '</td>
            ' . '</tr>';
            }
        }
        return $content . '</table>  </div>';
    }





    public function content($request, $n, $i)
    {
        $ids = $request->btSelectItem;
        //dd($request->livreur);
        $user = DB::table('users')->find($request->livreur);

        //les information du fournisseur (en-tete)
        $info_client = '
            <div class="info_client">
                <h1>' . $user->name . '</h1>
                <h3>ADRESSE : ' . $user->adresse . '</h3>
                <h3>TELEPHONE : ' . $user->telephone . '</h3>
                <h3>VILLE : ' . $user->ville . '</h3>
                <h3>ICE: ' . $user->description . '</h3>
            </div>
            <div class="date_num">
                <h2>' . date("j - n - Y") . '</h2>

            </div>
        ';
        // pied du bon d'achat (calcul du total)
        $total = '';


        $content = $this->commandes($request, $n, $i);
        $content = $info_client . $content;
        if ($n == ($i + 1)) { //le total seulement dans la derniere page (n est le nbr de page / i et la page actuelle)
            $content .= $total;
        }
        return $content;
    }






    public function gen(Request $request)
    {
        $ids = $request->btSelectItem;
        if ($ids == null) return back();

        if (!(count($ids) > 0)) return back();
        $commandes = DB::table('commandes')->where('commandes.deleted_at', NULL)->whereIn('commandes.id', $ids)->get();
        $pdf = \App::make('dompdf.wrapper');
        $style = '
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Bon de Commande</title>

            <style type="text/css">
            @page {
                margin: 0px;
            }

                body{
                    margin: 0px;
                    background-image: url("https://i.postimg.cc/8kqfkwJ1/Bon-de-livraison-PNG-1.png");
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
        $m = (count($ids) / 12);
        $n = (int)$m; // nombre de page
        if ($n != $m) {
            $n++;
        }
        //dd($n);
        $content = '';
        for ($i = 0; $i < $n; $i++) {
            $content .= $this->content($request, $n, $i);
        }

        $content = $style . $content . ' </body></html>';



        $pdf->loadHTML($content)->setPaper('A4');


        return $pdf->stream('BonDeCommande.pdf');
    }
}
