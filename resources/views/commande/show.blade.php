@extends('racine')

@section('title')
N: {{$commande->numero}}
@endsection


@section('style')
    <style>
        .emp-profile{
            padding: 3%;
            margin-top: 3%;
            margin-bottom: 3%;
            border-radius: 0.5rem;
            background: #fff;

        }
        .profile-img{
            text-align: center;
        }
        .profile-img img{
            width: 70%;
            height: 100%;
        }
        .profile-img .file {
            position: relative;
            overflow: hidden;
            margin-top: -20%;
            width: 70%;
            border: none;
            border-radius: 0;
            font-size: 1em;
            background: #212529b8;
        }
        .profile-img .file input {
            position: absolute;
            opacity: 0;
            right: 0;
            top: 0;
        }
        .profile-head h5{
            color: #333;
        }
        .profile-head h6{
            color: #e85f03;
        }
        .profile-edit-btn{
            border: none;
            border-radius: 1.5rem;
            width: 70%;
            padding: 2%;
            font-weight: 600;
            color: #6c757d;
            cursor: pointer;
        }
        .proile-rating{
            font-size: 0.75em;
            color: #818182;
            margin-top: 5%;
        }
        .proile-rating span{
            color: #495057;
            font-size: 0.75em;
            font-weight: 600;
        }
        .profile-head .nav-tabs{
            margin-bottom:5%;
        }
        .profile-head .nav-tabs .nav-link{
            font-weight:600;
            border: none;
        }
        .profile-head .nav-tabs .nav-link.active{
            border: none;
            border-bottom:2px solid #e85f03;
        }
        .profile-work{
            padding: 14%;
            margin-top: -15%;
        }
        .profile-work p{
            font-size: 0.75em;
            color: #818182;
            font-weight: 600;
            margin-top: 10%;
        }
        .profile-work a{
            text-decoration: none;
            color: #495057;
            font-weight: 600;
            font-size: 0.75em;
        }
        .profile-work ul{
            list-style: none;
        }
        .profile-tab label{
            font-weight: 600;
        }
        .profile-tab p{
            font-weight: 600;
            color: #e85f03;
        }
        a {
            color: #e85f03;
        }
        a:hover {
            color: #e85f03;
        }

        .show .row{
            border-bottom-color: #cacaca;
            border-bottom-style: solid;
            border-bottom-width: 2px;
            padding-top: 10px;
        }
    </style>
@endsection






@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-6">
            <h4 class="page-title">Gestion des Colis</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Quickoo</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="/commandes">Colis</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$commande->numero}}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-6">
            <div class="row float-right">
                    @can('client')
                    <a  class="btn btn-danger text-white m-r-5" data-toggle="modal" data-target="#modalSubscriptionForm"><i class="fa fa-plus-square"></i></a>
                    @endcan
                    @can('ramassage-commande')
                    @if ($commande->statut === "En cours" && $commande->traiter != 0)
                    <a  class="btn btn-warning text-white m-r-5" data-toggle="modal" data-target="#modalSubscriptionFormStatut"><i class="fas fa-edit"></i></a>
                    @endif
                    @endcan
                    @can('delete-commande')
                    @if ($commande->statut === "expidié")
                    <a  class="btn btn-warning text-white m-r-5" data-toggle="modal" data-target="#modalSubscriptionFormEdit"><i class="fas fa-edit"></i></a>
                     
                    
                    
                    <a class="btn btn-primary text-white m-r-5" data-toggle="modal" data-target="#modalSubscriptionFormDelete"><i class="fas fa-trash-alt"></i></a>

                                <div class="modal fade" id="modalSubscriptionFormDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Êtes-vous sûr de vouloir supprimer cette commande ?</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                            <h5>
                                                Commande numero: {{$commande->numero}}
                                            </h5>
                                            <p class="proile-rating">Date : {{date_format($commande->created_at,"Y/m/d")}}<span> {{date_format($commande->created_at,"H:i:s")}}</span></p>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                Cliquez sur <b>Ok</b> pour confirmer ou <b>fermer</b> pour annuler la suppression

                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                          </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                          <form method="POST" action="{{ route('commandes.destroy',['commande'=> $commande->id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-primary text-white m-r-5">Ok</button>                                        </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                    
                    @endif
                    
                    @endcan



            </div>
        </div>
        
    </div>
</div>
<div class="container-fluid">
    <div class="container emp-profile">
       
        <div class="row">
           
            @if (session()->has('statut'))
            <div class="alert alert-dismissible alert-success col-12">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Succés !</strong> La commande à été bien Modifiée </a>.
              </div>
            @endif
            @if (session()->has('edit'))
        <div class="alert alert-dismissible alert-info col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Succés !</strong> Le statut de la commande numero {{session()->get('edit')}} à été bien edité !
          </div>
        @endif
        @if (session()->has('noedit'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Attention !</strong>vous ne pouvez pas changer le statut de La commande numero {{session()->get('noedit')}}
          </div>
        @endif
        @if (session()->has('nodelete'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Attention !</strong>vous ne pouvez pas supprimer La commande numero {{session()->get('nodelete')}}
          </div>
        @endif
        @if (session()->has('noupdate'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Attention !</strong>vous ne pouvez pas modifier La commande numero {{session()->get('noupdate')}} <br>
                vous pouvez modifier que les commandes qui ont le statut <b>EXPIDIE</b>
        </div>
        @endif
        @if (session()->has('nonEncours'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Attention !</strong>vous ne pouvez pas changer le statut de La commande numero {{session()->get('nonEncours')}} <br>
                vous pouvez modifier que les statuts des commandes qui ont le statut <b>En Cours</b>
        </div>
        @endif

            <div class="col-md-10">
                <div class="profile-head">
                            <h5>
                                Commande numero: <span style="color: #e85f03">{{$commande->numero}}</span>
                                <a  style="color: white" 
                                    class="badge badge-pill 
                                    @switch($commande->statut)
                                    @case("expidié")
                                    badge-warning"
                                    @can('ramassage-commande')
                                    title="Rammaser la commande" 
                                     href="{{ route('commandeStatut',['id'=> $commande->id]) }}"
                                    @endcan
                                        @break
                                    @case("En cours")
                                    badge-info"
                                        @if ($commande->traiter > 0)
                                        title="Voir le bon de livraison" 
                                        href="{{route('bon.gen',$commande->traiter)}}"
                                        target="_blank"
                                        @else
                                        title="Générer le bon de livraison" 
                                        href="{{route('bonlivraison.index')}}"
                                        @endif
                                        
                                        @break
                                    @case("Livré")
                                    badge-success"
                                    @if ($commande->facturer > 0)
                                        title="Voir la facture" 
                                        href="{{route('facture.gen',$commande->facturer)}}"
                                        target="_blank"
                                        @else
                                        title="Générer la facture" 
                                        href="{{route('facture.index')}}"
                                        @endif
                                        @break
                                    @default
                                    badge-danger"
                                @endswitch
                                    
                                     > 
                                     <span style="font-size: 1.25em">{{$commande->statut}}</span> 
                                </a>
                            </h5>
                           
                           
                            <p class="proile-rating">Date d'ajout : {{date_format($commande->created_at,"Y/m/d")}}<span> {{date_format($commande->created_at,"H:i:s")}}</span></p>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Informations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Historique</a>
                        </li>
                        @can('gestion-stock')
                        <li class="nav-item">
                            <a class="nav-link" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="false">Details</a>
                        </li>
                        @endcan
                        
                    </ul>
                </div>
            </div>
            <div class="col-md-2">
                <a target="_blank" class="btn btn-info text-white m-r-5" href="{{ route('pdf.gen',['id'=> $commande->id]) }}""><i class="fas fa-print"></i> imprimer</a>
            </div>
        </div>
        <div class="row">
          
            <div class="col-md-12">
                <div class="tab-content profile-tab" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Nom du destinataire : </label>
                                    </div>
                                    <div class="col-md-6">
                                        <p style="text-transform: uppercase">{{$commande->nom}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Téléphone :</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$commande->telephone}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Adresse :</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$commande->adresse}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Ville :</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$commande->ville}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Secteur :</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$commande->secteur}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Type de poids :</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$commande->poids}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Montant :</label>
                                    </div>
                                    <div class="col-md-6">
                                        @if ($commande->montant > 0)
                                        <p>{{$commande->montant}} MAD</p>
                                        @else
                                        <p> <i class="far fa-credit-card"></i> CARD PAYMENT
                                        </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Prix de livraison :</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$commande->prix}} MAD</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Nombre de colis :</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$commande->colis}}</p>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Statut de la commande :</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$commande->statut}} ({{$commande->updated_at->diffForHumans()}})</p>
                                        <p class="proile-rating">Date : {{date_format($commande->updated_at,"Y/m/d")}}<span> {{date_format($commande->updated_at,"H:i:s")}}</span></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>La date d'ajout :</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{date_format($commande->created_at,"Y/m/d H:i:s")}}</p>
                                        <p class="proile-rating">il y'a: {{$commande->created_at->diffForHumans()}}</p>
                                    </div>
                                </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>STATUT</label>
                                    </div>
                                    <div class="col-md-4">
                                        <p>DATE</p>
                                    </div>
                                    @can('ramassage-commande')
                                    <div class="col-md-4">
                                        <p>PAR</p>
                                    </div>
                                    @endcan
                                </div>
                                @foreach ($statuts as $index => $statut)
                                <div class="row">
                                    <div class="col-md-4">
                                    <label>
                                        <a  style="color: white" 
                                    class="badge badge-pill 
                                    @switch($statut->name)
                                    @case("expidié")
                                    badge-warning"
                                    @can('ramassage-commande')
                                    title="Rammaser la commande" 
                                     href="{{ route('commandeStatut',['id'=> $commande->id]) }}"
                                    @endcan
                                        @break
                                    @case("En cours")
                                    badge-info"
                                        @if ($commande->traiter > 0)
                                        title="Voir le bon de livraison" 
                                        href="{{route('bon.infos',$commande->traiter)}}"
                                        @else
                                        title="Générer le bon de livraison" 
                                        href="{{route('bonlivraison.index')}}"
                                        @endif
                                        
                                        @break
                                    @case("Livré")
                                    badge-success"
                                    @if ($commande->facturer > 0)
                                        title="Voir la facture" 
                                        href="{{route('facture.infos',$commande->facturer)}}"
                                        @else
                                        title="Générer la facture" 
                                        href="{{route('facture.index')}}"
                                        @endif
                                        @break
                                    @default
                                    badge-danger"
                                @endswitch
                                    
                                     > 
                                     <span style="font-size: 1.25em">{{$statut->name}}</span> 
                                </a>
                                    </label>
                                    </div>
                                    <div class="col-md-4">
                                        <p>{{$statut->created_at}}</p>
                                    </div>
                                    @can('ramassage-commande')
                                    <div class="col-md-4">
                                        <p>{{$par[$index]->name}}</p>
                                    </div>
                                    @endcan
                                </div>
                                @endforeach
                                
                              
                                
                        <div class="row">
                            <div class="col-md-12">
                                <label>Commentaire</label><br/>
                                @if ($commande->commentaire)
                                    <p>{{$commande->commentaire}}</p>
                                @else
                                    <p>Sans Commentaire</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @can('gestion-stock')
                    <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
                        @foreach ($produits as $index => $produit)
                            <div class="row">
                                <div class="col-md-4">
                                    <a href="/produit/{{$produit->id}}" title="{{$produit->libelle}}" class=" text-muted waves-effect waves-dark pro-pic">
                                        <img src="/uploads/produit/{{$produit->photo}}" alt="user" class="rounded-circle" width="31">
                                    </a>
                                    <label>{{$produit->libelle}}</label>
                                </div>
                                <div class="col-md-4">
                                    <p style="text-transform: uppercase">Ref: {{$produit->reference}}</p>
                                </div>
                                <div class="col-md-4">
                                    <p style="text-transform: uppercase">QTE: {{$liaisons[$index]->qte}}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endcan
                </div>
            </div>
        </div>
               
</div>
</div>
   
@can('delete-commande')
@if ($commande->statut === "expidié")
<div class="container my-4">    
    <div class="modal fade" id="modalSubscriptionFormEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header text-center">
                          <h4 class="modal-title w-100 font-weight-bold">Modifier la Commande</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body mx-3">
                            <form class="form-horizontal form-material" method="POST" action="{{route('commandes.update',['commande' => $commande])}}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label class="col-md-12">Nom et Prénom du destinataire :</label>
                                    <div class="col-md-12">
                                        <input  value="{{ old('nom',$commande->nom) }}" name="nom" type="text" placeholder="Nom & Prénom" class="form-control form-control-line">
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="example-email" class="col-md-12">Nombre de Colis :</label>
                                        <div class="col-md-12">
                                            <input  value="{{ old('colis',$commande->colis) }}" type="number" class="form-control form-control-line" name="colis" id="example-email">
                                        </div>
                                    </div>
    
    
                                    <fieldset class="form-group col-md-4">
                                        <div class="row">
                                          <legend class="col-form-label  pt-0">Poids :</legend>
                                          <div class="col-sm-12">
                                            <div class="form-check">
                                              <input   class="form-check-input" type="radio" name="poids" id="normal" value="normal" {{ ($commande->poids=="normal")? "checked" : "" }}>
                                              <label class="form-check-label" for="normal">
                                                P. Normal
                                              </label>
                                            </div>
                                            <div class="form-check">
                                              <input   class="form-check-input" type="radio" name="poids" id="voluminaux" value="voluminaux" {{ ($commande->poids=="voluminaux")? "checked" : "" }}>
                                              <label class="form-check-label" for="voluminaux">
                                                P. Volumineux
                                              </label>
                                            </div>
                                        
                                          </div>
                                        </div>
                                      </fieldset>
                                      @can('gestion-commande')
                                      <fieldset class="form-group col-md-4">
                                        <div class="row">
                                          <legend class="col-form-label  pt-0">Mode de paiement :</legend>
                                          <div class="col-sm-12">
                                            <div class="form-check">
                                              <input  onclick="myFunctionEdit2(this.value)" class="form-check-input" type="radio" name="mode" id="cd" value="cd" checked>
                                              <label class="form-check-label" for="cd">
                                                Cash on delivery
                                              </label>
                                            </div>
                                            <div class="form-check">
                                              <input  onclick="myFunctionEdit2(this.value)" class="form-check-input" type="radio" name="mode" id="cp" value="cp">
                                              <label class="form-check-label" for="cp">
                                                Card payment
                                              </label>
                                            </div>
                                        
                                          </div>
                                        </div>
                                      </fieldset>
                                     

                                      <div class="form-group col-md-12" id="montant2"  style="display: block">
                                        <label for="example-email" class="col-md-12">Montant (MAD) :</label>
                                        <div class="col-md-12">
                                            <input  value="{{ old('montant',$commande->montant) }}" type="number" class="form-control form-control-line" name="montant" id="example-email">
                                        </div>
                                    </div>
                                    @endcan
                                </div>
                
                                <div class="form-group">
                                    <label class="col-md-12">Téléphone :</label>
                                    <div class="col-md-12">
                                        <input value="{{ old('telephone',$commande->telephone) }}"  name="telephone" type="text" placeholder="+212 5393-07566" class="form-control form-control-line">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Adresse :</label>
                                    <div class="col-md-12">
                                        <textarea  name="adresse" rows="5" class="form-control form-control-line">{{ old('adresse',$commande->adresse) }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12">Ville :</label>
                                    <div class="col-sm-12">
                                        <select name="ville" class="form-control form-control-line" value="{{ old('ville',$commande->ville) }}" id="ville2" onchange="myFunctionEdit1()" required>
                                        <option value="{{$commande->ville}}" checked>{{$commande->ville}}</option>
                                            <option value="Tanger">Tanger</option>
                                            <option >Marrakech</option>
                                            <option >Kénitra</option>
                                            <option >Casablanca</option>
                                            <option >Rabat</option>
                                        </select>
                                    </div>
                                </div>
                                <div   class="form-group" id="secteur2">
                                    <label class="col-sm-12">Secteur :</label>
                                    <div class="col-sm-12">
                                        <select  value="{{ old('secteur',$commande->secteur) }}" name="secteur" class="form-control form-control-line" required>
                                            <option value="{{$commande->secteur}}" checked>{{$commande->secteur}}</option>
                                            <option>Aviation</option>
                                            <option>Al Kasaba</option>
                                            <option>Cap spartel</option>
                                            <option>Centre ville</option>
                                            <option>Cité californie</option>
                                            <option>Girari</option>
                                            <option>Ibn Taymia</option>
                                            <option>M'nar</option>
                                            <option>M'sallah</option>
                                            <option>Makhoukha</option>
                                            <option>Malabata</option>
                                            <option>Marchane</option>
                                            <option>Marjane</option>
                                            <option>Moujahidine</option>
                                            <option>Moulay Youssef</option>
                                            <option>Santa</option>
                                            <option>Val Fleuri</option>
                                            <option>Vieille montagne</option>
                                            <option>Ziatene</option>
                                            <option>Autre secteur</option>
                                            <option>Achennad</option>
                                            <option>Aharrarine</option>
                                            <option>Ahlane</option>
                                            <option>Aida</option>
                                            <option>Al Anbar</option>
                                            <option>Al Warda</option>
                                            <option>Aouama Gharbia</option>
                                            <option>Beausejour</option>
                                            <option>Behair</option>
                                            <option>Ben Dibane</option>
                                            <option>Beni Makada Lakdima</option>
                                            <option>Beni Said</option>
                                            <option>Beni Touzine</option>
                                            <option>Bir Aharchoune</option>
                                            <option>Bir Chifa</option>
                                            <option>Bir El Ghazi</option>
                                            <option>Bouchta-Abdelatif</option>
                                            <option>Bouhout 1</option>
                                            <option>Bouhout 2</option>
                                            <option>Dher Ahjjam</option>
                                            <option>Dher Lahmam</option>
                                            <option>El Baraka</option>
                                            <option>El Haj El Mokhtar</option>
                                            <option>El Khair 1</option>
                                            <option>El Khair 2</option>
                                            <option>El Mers 1</option>
                                            <option>El Mers 2</option>
                                            <option>El Mrabet</option>
                                            <option>Ennasr</option>
                                            <option>Gourziana</option>
                                            <option>Haddad</option>
                                            <option>Hanaa 1</option>
                                            <option>Hanaa 2</option>
                                            <option>Hanaa 3 - Soussi</option>
                                            <option>Jirrari</option>
                                            <option>Les Rosiers</option>
                                            <option>Zemmouri</option>
                                            <option>Zouitina</option>
                                            <option>Al Amal</option>
                                            <option>Al Mandar Al Jamil</option>
                                            <option>Alia</option>
                                            <option>Benkirane</option>
                                            <option>Charf</option>
                                            <option>Draoua</option>
                                            <option>Drissia</option>
                                            <option>El Majd</option>
                                            <option>El Oued</option>
                                            <option>Mghogha</option>
                                            <option>Nzaha</option>
                                            <option>Sania</option>
                                            <option>Tanger City Center</option>
                                            <option>Tanja Balia</option>
                                            <option>Zone Industrielle Mghogha</option>
                                            <option>Azib Haj Kaddour</option>
                                            <option>Bel Air - Val fleuri</option>
                                            <option>Bir Chairi</option>
                                            <option>Branes 1</option>
                                            <option>Branes 2</option>
                                            <option>Casabarata</option>
                                            <option>Castilla</option>
                                            <option>Hay Al Bassatine</option>
                                            <option>Hay El Boughaz</option>
                                            <option>Hay Zaoudia</option>
                                            <option>Lalla Chafia</option>
                                            <option>Souani</option>
                                            <option>Achakar</option>
                                            <option>Administratif</option>
                                            <option>Ahammar</option>
                                            <option>Ain El Hayani</option>
                                            <option>Algerie</option>
                                            <option>Branes Kdima</option>
                                            <option>Californie</option>
                                            <option>Centre</option>
                                            <option>De La Plage</option>
                                            <option>Du Golf</option>
                                            <option>Hay Hassani</option>
                                            <option>Iberie</option>
                                            <option>Jbel Kbir</option>
                                            <option>Laaouina</option>
                                            <option>Marchan</option>
                                            <option>Mediouna</option>
                                            <option>Mesnana</option>
                                            <option>Mghayer</option>
                                            <option>Mister Khouch</option>
                                            <option>Mozart</option>
                                            <option>Msala</option>
                                            <option>Médina</option>
                                            <option>Port Tanger ville</option>
                                            <option>Rmilat</option>
                                            <option>Star Hill</option>
                                            <option>manar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button class="btn btn-warning">Modifier</button>
                                        
                                    </div>
                                </div>
                            </form>
                            @if ($errors->any())
                            <div class="alert alert-dismissible alert-danger">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>
                                        <strong>{{$error}}</strong>
                                        </li>
                                    @endforeach
                                </ul>
                              </div>
                              @endif
                        </div>
            
                      </div>
                    </div>
    </div>
</div>
@endif
@endcan

<div class="container my-4">    
    <div class="modal fade" id="modalSubscriptionFormStatut" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header text-center">
                          <h4 class="modal-title w-100 font-weight-bold">Changer le statut</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body mx-3">
                            <form class="form-horizontal form-material" method="POST" action="{{route('commandeStatut',['id' => $commande->id])}}">
                                @csrf
                                @method('PATCH')
                                
                                <div class="form-group">
                                    <label class="col-sm-12">Statut :</label>
                                    <div class="col-sm-12">
                                        <select name="statut" class="form-control form-control-line" value="{{ old('statut',$commande->statut) }}">
                                            <option>Livré</option>
                                            <option>Retour Complet</option>
                                            <option>Retour Partiel</option>
                                            <option>Reporté</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12">Commentaire :</label>
                                    <div class="col-sm-12">
                                        <textarea  name="commentaire" rows="5" class="form-control form-control-line">{{ old('commentaire') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button class="btn btn-warning">Modifier statut</button>
                                        
                                    </div>
                                </div>
                            </form>
                            @if ($errors->any())
                            <div class="alert alert-dismissible alert-danger">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>
                                        <strong>{{$error}}</strong>
                                        </li>
                                    @endforeach
                                </ul>
                              </div>
                              @endif
                        </div>
            
                      </div>
                    </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
    
    function myFunctionEdit1() {
        var x = document.getElementById("secteur2");
    var test = document.getElementById("ville2").value;
    if(test=='Tanger'){
        x.style.display = "block";
    }
    else{
        x.style.display = "none";
    }
    }
</script>
<script>
    function myFunctionEdit2(mode) {
        var y = document.getElementById("montant2");
        if(mode == 'cd' && y.value != 0 ){
            y.style.display = "block";
        }
        else{
            y.style.display = "none";
        }
    }
</script>
<script>
    function myFunction() {
        var xx = document.getElementById("secteur");
    var test = document.getElementById("ville").value;
    if(test=='Tanger'){
        xx.style.display = "block";
    }
    else{
        xx.style.display = "none";
    }
    }
</script>

<script>
    function myFunction2(mode) {
        var yy = document.getElementById("montant");

        if(mode == 'cd'){
            yy.style.display = "block";
            console.log("cd");
        }
        else{
            yy.style.display = "none";
            console.log("cp");
        }
    }
</script>
@endsection