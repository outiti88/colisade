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
                    @can('client-admin')
                    <a  class="btn btn-danger text-white m-r-5" data-toggle="modal" data-target="#modalSubscriptionForm"><i class="fa fa-plus-square"></i></a>
                    @endcan
                    @can('ramassage-commande')
                    @if ($commande->statut === "En cours")
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
            <strong>Succés !</strong> La commande à été bien Modifier </a>.
              </div>
            @endif
            @if (session()->has('edit'))
        <div class="alert alert-dismissible alert-info col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Succés !</strong> Le statut de la commande numero {{session()->get('edit')}} à été bien edité !!
          </div>
        @endif
        @if (session()->has('noedit'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Erreur !</strong>vous ne pouvez pas changer le statut de La commande numero {{session()->get('noedit')}}
          </div>
        @endif
        @if (session()->has('nodelete'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Erreur !</strong>vous ne pouvez pas supprimer La commande numero {{session()->get('nodelete')}}
          </div>
        @endif
        @if (session()->has('noupdate'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Erreur !</strong>vous ne pouvez pas modifier La commande numero {{session()->get('noupdate')}} <br>
                vous pouvez modifier que les commandes qui ont le statut <b>EXPIDIE</b>
        </div>
        @endif
        @if (session()->has('nonEncours'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Erreur !</strong>vous ne pouvez pas changer le statut de La commande numero {{session()->get('nonEncours')}} <br>
                vous pouvez modifier que les statuts des commandes qui ont le statut <b>En Cours</b>
        </div>
        @endif

            <div class="col-md-10">
                <div class="profile-head">
                            <h5>
                                Commande numero:
                            </h5>
                            <h6>
                                {{$commande->numero}}
                            </h6>
                            <a href="" title="Statut" 
                                    class="badge badge-pill 
                                    @switch($commande->statut)
                                    @case("expidié")
                                    badge-warning
                                        @break
                                    @case("En cours")
                                    badge-info
                                        @break
                                    @case("Livré")
                                    badge-success
                                        @break
                                    @default
                                    badge-danger
                                @endswitch
                                    "> 
                                     <span style="font-size: 1.25em">{{$commande->statut}}</span> 
                                </a>
                            <p class="proile-rating">Date : {{date_format($commande->created_at,"Y/m/d")}}<span> {{date_format($commande->created_at,"H:i:s")}}</span></p>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Informations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Historique</a>
                        </li>
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
                                        <p>{{$commande->montant}} MAD</p>
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
                                        <a style="color: white" href="" title="Statut" 
                                    class="badge badge-pill 
                                    @switch($statut->name)
                                    @case("expidié")
                                    badge-warning
                                        @break
                                    @case("En cours")
                                    badge-info
                                        @break
                                    @case("Livré")
                                    badge-success
                                        @break
                                    @default
                                    badge-danger
                                @endswitch
                                    "> 
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
                </div>
            </div>
        </div>
               
</div>
</div>
   
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
    
    
                                      <div class="form-group col-md-4">
                                        <label for="example-email" class="col-md-12">Montant (MAD) :</label>
                                        <div class="col-md-12">
                                            <input  value="{{ old('montant',$commande->montant) }}" type="number" class="form-control form-control-line" name="montant" id="example-email">
                                        </div>
                                    </div>
                                    
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
                                        <select name="ville" class="form-control form-control-line" value="{{ old('ville',$commande->ville) }}">
                                            <option>Tanger</option>
                                            <option>Marrakech</option>
                                            <option>Kénitra</option>
                                            <option>Casablanca</option>
                                            <option>Rabata</option>
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