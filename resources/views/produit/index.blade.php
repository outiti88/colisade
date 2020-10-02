@extends('racine')

@section('title')
   Gestion de stock
@endsection

@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-5">
            <h4 class="page-title">Gestion de stock</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Quickoo</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Stock</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-7">
        <div class="row float-right d-flex ">
            <div class=m-r-5" style="margin-right: 10px;">
                <a  class="btn btn-warning text-white"  data-toggle="modal" data-target="#modalStockSearch"><i class="fa fa-search"></i></a>
            </div>
            @can('gestion-stock')
            <div class="m-r-5">
                <a  class="btn btn-danger text-white"  data-toggle="modal" data-target="#modalStockAdd"><i class="fa fa-plus-square"></i> Ajouter</a>
            </div>
            @endcan
        </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Gerer votre stock</h4>
                    <h6 class="card-subtitle">Nombre total de vos articles : <code>{{$total}} Articles</code> .</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" style="font-size: 0.85em;">
                        <thead>
                            <tr>
                                <th scope="col">Code produit</th>
                                <th scope="col">Nom du produit</th>
                                <th scope="col">Description</th>
                                <th scope="col">Poids</th>
                                <th scope="col">Prix</th>
                                <th scope="col">en stock</th>
                                <th scope="col">vendu</th>
                                <th scope="col">reception</th>
                                <th scope="col">Voir</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                           @forelse ($produits as $index => $produit)
                           <tr>
                            <th scope="row">{{$produit->numero}}</th>
                            <td>{{$produit->code}}</td>
                            <td>{{$produit->nom}}</td>
                            <td>{{$produit->description}}</td>
                            <td>{{$produit->poids}}</td>
                            <td>{{$produit->prix}} MAD</td>
                            <td>{{$produit->quantite}} MAD</td>
                            <td>{{$produit->vendu}}</td>
                            <td>>{{$produit->updated_at}} 
                                ({{\Carbon\Carbon::parse($produit->updated_at)->diffForHumans()}}) 
                            </td>
                           <td style="font-size: 1.5em"><a style="color: #e85f03" href="/produits/{{$produit->id}}">
                            <i class="mdi mdi-eye"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" style="text-align: center">Aucun produit enregistré!</td>
                        </tr>
                        
                           @endforelse
                         
                        </tbody>
                        
                    </table>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            {{$produits -> links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>





@endsection