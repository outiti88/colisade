
@extends('racine')

@section('title')
   Gestion des Colis
@endsection


@section('style')
    <style>

        .dropdown.dropdown-lg .dropdown-menu {
            margin-top: -1px;
            padding: 6px 20px;
        }
        .input-group-btn .btn-group {
            display: flex !important;
        }
        .btn-group .btn {
            border-radius: 0;
            margin-left: -1px;
        }
        .btn-group .btn:last-child {
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
        }
        .btn-group .form-horizontal .btn[type="submit"] {
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
        }
        .form-horizontal .form-group {
            margin-left: 0;
            margin-right: 0;
        }
        .form-group .form-control:last-child {
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }

        @media screen and (min-width: 768px) {
            #adv-search {
                width: 500px;
                margin: 0 auto;
            }
            .dropdown.dropdown-lg {
                position: static !important;
            }
            .dropdown.dropdown-lg .dropdown-menu {
                min-width: 500px;
            }
        }
        .page-link {
            color: #e85f03 !important;
        }
        .page-item.active .page-link {
            
            background-color: #e85f03 !important;
            border-color: #e85f03 !important;
            color: #fff !important;
        }
    </style>
@endsection


@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-5">
            <h4 class="page-title">Gestion des Colis</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Quickoo</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Colis</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-7">
        <div class="row float-right d-flex ">
            <div class=m-r-5" style="margin-right: 10px;">
                <a  class="btn btn-warning text-white"  data-toggle="modal" data-target="#modalSearchForm"><i class="fa fa-search"></i></a>
            </div>
            @can('client-admin')
            <div class="m-r-5">
                <a  class="btn btn-danger text-white"  data-toggle="modal" data-target="#modalSubscriptionForm"><i class="fa fa-plus-square"></i> Ajouter</a>
            </div>
            @endcan
        </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        @if (session()->has('search'))
        <div class="alert alert-dismissible alert-warning col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Oupss !</strong> Il n'existe aucun numero de commande et aucun statut avec : {{session()->get('search')}}  </a>.
          </div>
        @endif
        @if (session()->has('statut'))
        <div class="alert alert-dismissible alert-success col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Succés !</strong> La commande à été bien enregister <a  href="commandes/{{session()->get('statut')}}" class="alert-link">(Voir la commande)</a>.
          </div>
        @endif

        @if (session()->has('avant18'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Erreur !</strong> {{gmdate("H")+1 . gmdate(":i:s")}} Vous pouvez pas ajouter une commande après 19h:00 GMT+1 !!
          </div>
        @endif

        @if (session()->has('delete'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Succés !</strong> La commande numero {{session()->get('delete')}} à été bien supprimée !!
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
        <strong>Erreur !</strong>vous ne pouvez pas changer le statut La commande numero {{session()->get('noedit')}}
          </div>
        @endif 
        @if (session()->has('bonLivraison'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Erreur !</strong>Vous pouvez pas ajouter une commande, Le bon de livraison de ce jour à été déjà générer
          </div>
        @endif
        @if (session()->has('nonExpidie'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Erreur !</strong>Commande déjà traitée  {{session()->get('nonExpidie')}} <br>
                vous pouvez modifier que les statuts des commandes qui ont le statut <b>Expidié</b>
        </div>
        @endif
        @if (session()->has('blgenere'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Erreur !</strong>vous ne pouvez pas changer le statut de La commande numero {{session()->get('blgenere')}} <br>
                => le bon de livraison pour cette commande à été déjà généré
        </div>
        @endif
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Gestion des comandes / colis</h4>
                    <h6 class="card-subtitle">Nombre total des commandes : <code>{{$total}} Commandes</code> .</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" style="font-size: 0.85em;">
                        <thead>
                            <tr>
                                @can('ramassage-commande')
                                <th scope="col">Client</th>
                                @endcan
                                <th scope="col">Numero Commande</th>
                                <th scope="col">Nom Complet</th>
                                <th scope="col">Téléphone</th>
                                <th scope="col">Ville</th>
                                <th scope="col">Adresse</th>
                                <th scope="col">Montant</th>
                                <th scope="col">Prix de Livraison</th>
                                <th scope="col">Date</th>
                                <th scope="col">Statut</th>
                                <th scope="col">Ticket</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                           @forelse ($commandes as $index => $commande)
                           <tr>
                            @can('ramassage-commande')
                            <th scope="row">
                                <a title="{{$users[$index]->name}}" class=" text-muted waves-effect waves-dark pro-pic" 
                                        @if(Auth::user()->id === $users[$index]->id )
                                            href="/profil"
                                        @else
                                            @can('edit-users')
                                                href="{{route('admin.users.edit',$users[$index]->id)}}"
                                            @endcan

                                        @endif
                                    >
                                    <img src="{{$users[$index]->image}}" alt="user" class="rounded-circle" width="31">
                                </a>
                            </th>
                            @endcan
                            <th scope="row">{{$commande->numero}}</th>
                            <td>{{$commande->nom}}</td>
                            <td>{{$commande->telephone}}</td>
                            <td>{{$commande->ville}}</td>
                            <td>{{$commande->adresse}}</td>
                            <td>{{$commande->montant}} MAD</td>
                            <td>{{$commande->prix}} MAD</td>
                            <td>{{$commande->created_at}}</td>
                            <td>
                                
                                <a style="color: white" title="Rammaser la commande" 
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
                                    "
                                    @can('ramassage-commande')
                                     href="{{ route('commandeStatut',['id'=> $commande->id]) }}"
                                    @endcan
                                     > 
                                     <span style="font-size: 1.25em">{{$commande->statut}}</span> 
                                </a>
                                <br> ({{\Carbon\Carbon::parse($commande->updated_at)->diffForHumans()}}) 
                            </td>
                           <td style="font-size: 1.5em"><a title="Voir le detail" style="color: #e85f03" href="/commandes/{{$commande->id}}"><i class="mdi mdi-eye"></i></a></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" style="text-align: center">Aucune commande enregistrée!</td>
                        </tr>
                        
                           @endforelse
                         
                        </tbody>
                        
                    </table>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                           {{$commandes -> links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<div class="container my-4">    
    <div class="modal fade" id="modalSearchForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header text-center">
                          <h4 class="modal-title w-100 font-weight-bold">Rechercher sur les commandes</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body mx-3">
                            <form class="form-horizontal form-material" method="GET" action="{{route('commande.filter')}}">
                                @csrf
                                @can('ramassage-commande')
                                <div class="form-group row">
                                    <label for="client" class="col-sm-4">Fournisseur :</label>
                                    <div class="col-sm-8">
                                        <select name="client" id="client" class="form-control form-control-line" value="{{ old('client') }}">
                                            <option value="" disabled selected>Choisissez le fournisseur</option>
                                            @foreach ($clients as $client)
                                        <option value="{{$client->id}}" class="rounded-circle">
                                            {{$client->name}}
                                        </option>
                                            @endforeach
                                           
                                        </select>
                                        
                                    </div>
                                </div>
                                @endcan
                                
                                <div class="form-group row">
                                    <label class="col-md-4">Nom et Prénom:</label>
                                    <div class="col-md-8">
                                        <input  value="{{ old('nom') }}" name="nom" type="text" placeholder="Nom & Prénom" class="form-control form-control-line">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Statut de commande:</label>
                                    <div class="col-sm-8">
                                        <select name="statut" class="form-control form-control-line">
                                            <option selected disabled>Choisissez le statut</option>
                                            <option>Expidié</option>
                                            <option>en cours</option>
                                            <option>Livré</option>
                                            <option>Retour Complet</option>
                                            <option>Retour Partiel</option>
                                            <option>Reporté</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-date-input" class="col-4 col-form-label">Date Min</label>
                                    <div class="col-8">
                                      <input class="form-control" name="dateMin" type="date" value="{{now()}}" id="example-date-input">
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label for="example-date-input" class="col-4 col-form-label">Date Max</label>
                                    <div class="col-8">
                                      <input class="form-control" name="dateMax"  type="date" value="{{now()}}" id="example-date-input">
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label class="col-sm-4">Ville :</label>
                                    <div class="col-sm-8">
                                        <select name="ville" class="form-control form-control-line">
                                            <option selected disabled>Choisissez la ville</option>
                                            <option value="Tanger">Tanger</option>
                                            <option value="Marrakech">Marrakech</option>
                                            <option value="Kénitra">Kénitra</option>
                                            <option value="Casablanca">Casablanca</option>
                                            <option value="Rabat">Rabat</option>
                                        </select>
                                    </div>
                                </div>
                                  <div class="form-group row">
                                    <label for="example-date-input" class="col-3 col-form-label">Montant Min</label>
                                    <div class="col-3">
                                      <input class="form-control" name="prixMin" type="number" value="0" id="example-date-input">
                                    </div>
                                    <label for="example-date-input" class="col-3 col-form-label">Montant Max</label>
                                    <div class="col-3">
                                      <input class="form-control" type="number" name="prixMax" value="0" id="example-date-input">
                                    </div>
                                  </div>
                                
                                <div class="form-group">
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i> Rechercher</button>
                                        
                                    </div>
                                </div>
                            </form>
                        </div>
            
                      </div>
                    </div>
    </div>
</div>




<div class="container my-4">    
    @can('manage-users')
    <div class="modal fade" id="modalSubscriptionForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header text-center">
                          <h4 class="modal-title w-100 font-weight-bold">Nouvelle Commande</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body mx-3">
                            <form class="form-horizontal form-material" method="POST" action="{{route('commandes.store')}}">
                                @csrf
                                <div class="form-group row">
                                    <label for="client" class="col-sm-12">Fournisseur :</label>
                                    <div class="col-sm-12">
                                        <select name="client" id="client" class="form-control form-control-line" value="{{ old('client') }}" required>
                                            <option value="" disabled selected>Choisissez le fournisseur</option>
                                            @foreach ($clients as $client)
                                        <option value="{{$client->id}}" class="rounded-circle">
                                            {{$client->name}}
                                        </option>
                                            @endforeach
                                           
                                        </select>
                                        
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Nom et Prénom du destinataire :</label>
                                    <div class="col-md-12">
                                        <input  value="{{ old('nom') }}" name="nom" type="text" placeholder="Nom & Prénom" class="form-control form-control-line">
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="example-email" class="col-md-12">Nombre de Colis :</label>
                                        <div class="col-md-12">
                                            <input  value="{{ old('colis') }}" type="number" class="form-control form-control-line" name="colis" id="example-email">
                                        </div>
                                    </div>
    
    
                                    <fieldset class="form-group col-md-4">
                                        <div class="row">
                                          <legend class="col-form-label  pt-0">Poids :</legend>
                                          <div class="col-sm-12">
                                            <div class="form-check">
                                              <input   class="form-check-input" type="radio" name="poids" id="normal" value="normal" checked>
                                              <label class="form-check-label" for="normal">
                                                P. Normal
                                              </label>
                                            </div>
                                            <div class="form-check">
                                              <input   class="form-check-input" type="radio" name="poids" id="voluminaux" value="voluminaux">
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
                                            <input  value="{{ old('montant') }}" type="number" class="form-control form-control-line" name="montant" id="example-email">
                                        </div>
                                    </div>
                                    
                                </div>
                
                                <div class="form-group">
                                    <label class="col-md-12">Téléphone :</label>
                                    <div class="col-md-12">
                                        <input value="{{ old('telephone') }}"  name="telephone" type="text" placeholder="0xxx xxxxxx" class="form-control form-control-line">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Adresse :</label>
                                    <div class="col-md-12">
                                        <textarea  name="adresse" rows="5" class="form-control form-control-line">{{ old('adresse') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12">Ville :</label>
                                    <div class="col-sm-12">
                                        <select name="ville" class="form-control form-control-line">
                                            <option>Tanger</option>
                                            <option>Marrakech</option>
                                            <option>Kénitra</option>
                                            <option>Casablanca</option>
                                            <option>Rabat</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button class="btn btn-danger">Ajouter</button>
                                        
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
    @endcan
</div>




@endsection

@section('javascript')
    @if ($errors->any())
        <script type="text/javascript">
            $(window).on('load',function(){
                $('#modalSubscriptionForm').modal('show');
            });
        </script>
    @endif
@endsection