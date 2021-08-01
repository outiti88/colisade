
@extends('racine')

@section('title')
   Gestion des Colis
@endsection


@section('style')
    <style>
    .orangeBadge{
        background-color: #FF5722;
    }
    .violetBadge{
        background-color: #ab03ca;
    }
    .cielBadge{
            background-color: #00BCD4;
    }
    .relanceBadge{
      background-color: #867f43;
    }
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
            color: #f7941e !important;
        }
        .page-item.active .page-link {

            background-color: #f7941e !important;
            border-color: #f7941e !important;
            color: #fff !important;
        }
    </style>
@endsection


@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-5">
            <h4 class="page-title">Gestion des Commandes</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Colisade</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="/commandes">Colis</a></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-7">
        <div class="row float-right d-flex ">
            @can('client-admin')
            <div class="m-r-5">
                <a  class="btn btn-danger text-white"  data-toggle="modal" data-target="#modalSubscriptionForm"><i class="fa fa-plus-square"></i></a>
            </div>
            <div class="m-r-5">

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#EXCELMODAL">
                    <i class="fas fa-file-upload"></i>
                  </button>
            </div>

            @endcan
            <div class="m-r-5" style="margin-right: 10px;">
                <a  class="btn btn-warning text-white"  data-toggle="modal" data-target="#modalSearchForm"><i class="fa fa-search"></i></a>
            </div>
        </div>
        </div>
    </div>

        <!-- EXCEL MODAL -->
<div class="modal fade" id="EXCELMODAL" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Importer/Exporter les commandes via EXCEL</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" enctype="multipart/form-data" action="{{ route('import') }}">

        <div class="modal-body">
            <div class="row">
                    @csrf
                    <div class="custom-file">
                        <input type="file" name="select_file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" required>
                        <label class="custom-file-label" for="inputGroupFile01">.xls, .xslx </label>
                      </div>
                      <br><br>
                      <p style="margin-top:15px"><a href="/uploads/commandes.xlsx" class="tooltip-test" title="Tooltip">Format</a> du fichier excel à importer.</p>

            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" name="upload" class="btn btn-primary">Importer</button>
          <a class="btn btn-warning" href="{{ route('export') }}">Exporter en Excel</a>

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
<div class="container-fluid">
    <div class="row">
        @if (session()->has('search'))
        <div class="alert alert-dismissible alert-warning col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Aucun résultat trouvé !</strong> Il n'existe aucun numero de commande et aucun statut avec : {{session()->get('search')}}  </a>.
          </div>
        @endif
        @if (session()->has('statut'))
        <div class="alert alert-dismissible alert-success col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Succès !</strong> La commande a été bien enregistrée <a  href="commandes/{{session()->get('statut')}}" class="alert-link">(Voir la commande)</a>.
          </div>
        @endif

        @if (session()->has('delete'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Succés !</strong> La commande numero {{session()->get('delete')}} à été bien supprimée !
          </div>
        @endif

        @if (session()->has('stock_insuf'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Attention !</strong> Le stock de l'article {{session()->get('stock_insuf')}} est insuffisant !
          </div>
        @endif

        @if (session()->has('produit_required'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Attention !</strong> Il faut mentionner les produits de la commande
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
        <strong>Attention !</strong>vous ne pouvez pas changer le statut La commande numero {{session()->get('noedit')}}
          </div>
        @endif

        @if (session()->has('nonExpidie'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Attention !</strong>Commande déjà traitée  {{session()->get('nonExpidie')}} <br>
                vous pouvez modifier que les statuts des commandes qui ont le statut <b>envoyée</b>
        </div>
        @endif
        @if (session()->has('blgenere'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Attention !</strong>vous ne pouvez pas changer le statut de La commande numero {{session()->get('blgenere')}} <br>
                => le bon de livraison pour cette commande à été déjà généré
        </div>
        @endif
        @if (session()->has('blNongenere'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Attention !</strong>vous ne pouvez pas changer le statut de La commande numero {{session()->get('blNongenere')}} sans générer le bon de livraison <br>

        </div>
        @endif
        @if (session()->has('excel'))
        <div class="alert alert-dismissible alert-success col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Succès !</strong> Les commandes ont été bien ajoutées.
          </div>
        @endif
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Gestion des commandes / colis</h4>
                    <h6 class="card-subtitle">Nombre total des commandes : <code>{{$total}} Commandes</code> .</h6>
                    <input class="form-control" id="myInput" type="text" placeholder="Rechercher...">
                </div>
                <div class="table-responsive">
                    <table  data-click-to-select="true"
                            class="table table-hover" style="font-size: 0.72em;">
                        <thead>
                            <tr>
                                @can('manage-users')
                                    @if ($checkBox==1)
                                        <th  class="bs-checkbox " style="width: 36px; " data-field="state"><div class="th-inner "><label>
                                            <input  id="check_bl" onclick="checkFunction()" name="btSelectAll" type="checkbox">
                                            </label></div>
                                        </th>
                                    @endif
                                <th scope="col">Client</th>
                                @endcan
                                <th scope="col">Numero Commande</th>
                                <th scope="col">Nom Complet</th>
                                <th scope="col">Téléphone</th>
                                <th scope="col">Ville</th>
                                <th scope="col">Montant</th>
                                @cannot('livreur')
                                <th scope="col">Prix de Livraison</th>
                                @endcannot
                                <th scope="col">Date</th>
                                <th scope="col">Statut</th>
                                <th scope="col">Ticket</th>

                            </tr>
                        </thead>
                        <form id="commandes-form" method="GET">
                            <tbody id="myTable">

                                    @csrf
                                    <input type="hidden" name="livreur" value="{{ request()->get('livreur') }}">
                                    @forelse ($commandes as $index => $commande)
                                        <tr>
                                            @can('manage-users')
                                            @if ($checkBox==1)
                                                <td class="bs-checkbox " style="width: 36px; ">
                                                    <label>
                                                        <input value="{{$commande->id}}"  class="cb" name="btSelectItem[]" type="checkbox">
                                                        <span></span>
                                                    </label>
                                                </td>
                                            @endif


                                            <th scope="row">
                                                <a title="{{$users[$index]->name}}" class=" text-muted waves-effect waves-dark pro-pic @if($users[$index]->statut) vip @endif "
                                                            @can('edit-users')
                                                                href="{{route('admin.users.edit',$users[$index]->id)}}"
                                                            @endcan >
                                                    <img src="{{$users[$index]->image}}" alt="user" class="rounded-circle" width="31">
                                                </a>
                                            </th>
                                            @endcan
                                            <th scope="row">

                                                @if ($commande->facturer != 0)

                                                    <a href="{{route('facture.infos',$commande->facturer)}}" style="color: white; background-color: #f7941e" class="badge badge-pill" >
                                                        <span style="font-size: 1.25em">Facturée</span>
                                                    </a>
                                                    <br>
                                                @else
                                                    @if ($commande->traiter != 0)
                                                    <a href="{{route('bon.infos',$commande->traiter)}}" style="color: white" class="badge badge-pill badge-dark">
                                                        <span style="font-size: 1.25em">Bon livraison</span>
                                                    </a>
                                                    <br>
                                                    @endif
                                                @endif
                                                {{$commande->numero}}

                                            </th>
                                            <td>{{$commande->nom}}</td>
                                            <td>{{$commande->telephone}}</td>
                                            <td>{{$commande->ville}}</td>
                                            @if ($commande->montant > 0)
                                            <td>{{$commande->montant}} DH</td>
                                            @else
                                            <td> <i class="far fa-credit-card"></i> CARD PAYMENT </td>
                                            @endif
                                            @cannot('livreur')
                                            <td>{{$commande->prix}} DH</td>
                                            @endcannot
                                            <td>{{$commande->created_at}}</td>
                                            <td>
                                                <a  style="color: white; cursor:pointer"
                                                    @switch($commande->statut)
                                                        @case("envoyée")
                                                        class="badge badge-pill badge-warning"
                                                            @can('ramassage-commande')
                                                                title="Rammaser la commande"
                                                                href="{{ route('commandeStatut',['id'=> $commande->id]) }}"
                                                            @endcan
                                                        @break
                                                        @case("Reporté") class="badge badge-pill orangeBadge" @break
                                                        @case("Pas de Réponse") class="badge badge-pill violetBadge" @break
                                                        @case("Modifiée") class="badge badge-pill cielBadge" @break
                                                        @case("Relancée") class="badge badge-pill relanceBadge" @break
                                                        @case("En cours") class="badge badge-pill badge-info" @break
                                                        @case("Ramassée")
                                                            class="badge badge-pill badge-secondary"
                                                            @can('ramassage-commande')
                                                                title="Recevoir la commande"
                                                                href="{{ route('commandeStatut',['id'=> $commande->id]) }}"
                                                            @endcan
                                                        @break
                                                        @case("Reçue")
                                                            class="badge badge-pill badge-dark"
                                                            @can('ramassage-commande')
                                                                title="Envoyer la commande"
                                                                href="{{ route('commandeStatut',['id'=> $commande->id]) }}"
                                                            @endcan
                                                        @break
                                                        @case("Expidiée")
                                                            class="badge badge-pill badge-primary"
                                                            @can('ramassage-commande')
                                                                title="Valider la commande"
                                                                href="{{ route('commandeStatut',['id'=> $commande->id]) }}"
                                                            @endcan
                                                        @break
                                                        @case("Livré") class="badge badge-pill badge-success" @break
                                                        @default class="badge badge-pill badge-danger"
                                                    @endswitch
                                                    @can('livreur')
                                                        @if (( $commande->statut === "Pas de Réponse" || $commande->statut === "Livré" || $commande->statut === "Injoignable" || $commande->statut === "En cours" || $commande->statut === "Refusée" || $commande->statut === "Modifiée" || $commande->statut === "Annulée" || $commande->statut === "Relancée" || $commande->statut === "Reporté" ) && $commande->facturer == 0 )
                                                            data-toggle="modal" data-target="#modalSubscriptionFormStatut{{$commande->id}}"
                                                        @endif
                                                    @endcan
                                                    @can('manage-users')
                                                        @if (( $commande->statut === "Pas de Réponse" || $commande->statut === "Livré" || $commande->statut === "Injoignable" || $commande->statut === "En cours" || $commande->statut === "Refusée" || $commande->statut === "Modifiée" || $commande->statut === "Annulée" || $commande->statut === "Relancée" || $commande->statut === "Reporté" ) && $commande->facturer == 0 )
                                                        data-toggle="modal" data-target="#modalSubscriptionFormStatut{{$commande->id}}"
                                                        @endif
                                                    @endcan >
                                                        <span style="font-size: 1.25em">{{$commande->statut}}</span>
                                                </a>
                                                <br>
                                                @if ($commande->statut == "Reporté" || $commande->statut == "Relancée")
                                                    Pour le: <br>{{$commande->postponed_at}}
                                                @else
                                                ({{\Carbon\Carbon::parse($commande->updated_at)->diffForHumans()}})

                                                @endif
                                            </td>
                                            <td style="font-size: 1.5em"><a title="Voir le detail" style="color: #f7941e" href="/commandes/{{$commande->id}}"><i class="mdi mdi-eye"></i></a></td>
                                        </tr>

                                        <div class="container my-4">
                                            <div class="modal fade" id="modalSubscriptionFormStatut{{$commande->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header text-center">
                                                                <h4 class="modal-title w-100 font-weight-bold">Changer le statut</h4>

                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                                </div>
                                                                <h5 class="font-weight-bold" style="text-align: center">Commande Numero : {{$commande->numero}}</h5>

                                                                <div class="modal-body mx-3">


                                                                        <div class="form-group">
                                                                            <label for="etat{{$commande->id}}" class="col-sm-12">Statut :</label>
                                                                            <div class="col-sm-12">
                                                                                <select id="etat{{$commande->id}}" onchange="reporter({{$commande->id}})"  class="form-control form-control-line" >
                                                                                    <option>Livré</option>
                                                                                    <option>Injoignable</option>
                                                                                    <option>Pas de Réponse</option>
                                                                                    <option>Refusée</option>
                                                                                    @cannot('livreur')
                                                                                    <option>Retour</option>
                                                                                    @endcannot
                                                                                    <option>Reporté</option>
                                                                                    <option>Annulée</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group" style="display: none" id="prevu{{$commande->id}}">
                                                                            <label for="datePrevu{{$commande->id}}" class="col-sm-12">Date Prévue :</label>
                                                                            <div class="col-sm-12">
                                                                            <input class="form-control"  type="date" id="datePrevu{{$commande->id}}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-sm-12">Commentaire :</label>
                                                                            <div class="col-sm-12">
                                                                                <textarea id="commentaire{{$commande->id}}"  rows="5" class="form-control form-control-line"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="modal-footer d-flex justify-content-center">
                                                                                <a class="btn btn-warning" style="color:white" onclick="changeStatus({{$commande->id}})">Enregistrer</a>

                                                                            </div>
                                                                        </div>
                                                                    {{-- </form> --}}
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
                                    @empty
                                        <tr>
                                            <td colspan="10" style="text-align: center">Aucune commande enregistrée!</td>
                                        </tr>

                                    @endforelse

                            @if ($checkBox==1)
                                @if (request()->get('livreur') != null)
                                <button style="margin: 20px;" onclick="submitForm1()" class="btn btn-primary">Bon de Commande</button>
                                @endif
                                <button style="margin: 20px;" onclick="submitForm2()" class="btn btn-info">Ticket de Commande</button>
                            @endif
                            </tbody>
                    </form>


                    </table>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            {{$commandes ->appends($data)-> links()}}
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
                                @can('manage-users')
                                <div class="form-group row">
                                    <label for="client" class="col-sm-4">Fournisseur :</label>
                                    <div class="col-sm-8">
                                        <select name="client" id="client" class="form-control form-control-line" value="{{ old('client') }}">
                                            <option value="" selected >Choisissez le fournisseur</option>
                                            @foreach ($clients as $client)
                                            @if(request()->get('client') == $client->id )
                                            <option selected value="{{$client->id}}" class="rounded-circle">
                                                {{$client->name}}
                                            </option>
                                            @else
                                            <option value="{{$client->id}}" class="rounded-circle">
                                                {{$client->name}}
                                            </option>
                                            @endif

                                            @endforeach

                                        </select>

                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="livreur" class="col-sm-4">Livreur :</label>
                                    <div class="col-sm-8">
                                        <select name="livreur" id="livreur" class="form-control form-control-line" value="{{ old('livreur') }}">
                                            <option value=""  selected >Choisissez le livreur</option>
                                            @foreach ($livreurs as $livreur)
                                            @if(request()->get('livreur') == $livreur->id )
                                            <option selected value="{{$livreur->id}}" class="rounded-circle">
                                                {{$livreur->name}}
                                            </option>
                                            @else
                                        <option value="{{$livreur->id}}" class="rounded-circle">
                                            {{$livreur->name}}
                                        </option>
                                        @endif
                                            @endforeach

                                        </select>

                                    </div>
                                </div>
                                @endcan

                                <div class="form-group row">
                                    <label class="col-md-4">Nom et Prénom:</label>
                                    <div class="col-md-8">
                                        <input  value="{{request()->get('nom')}}" name="nom" type="text" placeholder="Nom & Prénom" class="form-control form-control-line">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">Téléphone:</label>
                                    <div class="col-md-8">
                                        <input  value="{{ request()->get('telephone')}}" name="telephone" type="text" placeholder="Téléphone" class="form-control form-control-line">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Statut de commande:</label>
                                    <div class="col-sm-8">
                                        <select name="statut" class="form-control form-control-line">

                                            <option selected value="">Choisissez le statut</option>
                                            @if(request()->get('statut') != null )
                                            <option selected>{{request()->get('statut')}}</option>
                                            @endif
                                            @cannot('livreur')
                                                <option>envoyée</option>
                                                <option>Ramassée</option>
                                                <option>Reçue</option>
                                            @endcannot
                                            <option>Expidiée</option>
                                            <option>en cours</option>
                                            <option>Relancée</option>
                                            <option>Modifiée</option>
                                            <option>Livré</option>
                                            <option>Pas de Réponse</option>
                                            <option>Injoignable</option>
                                            <option>Refusée</option>
                                            <option>Annulée</option>
                                            <option>Retour</option>
                                            <option>Reporté</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-date-input" class="col-4 col-form-label">Date Min</label>
                                    <div class="col-8">
                                      <input class="form-control" name="dateMin" type="date" value="{{request()->get('dateMin')}}" id="example-date-input">
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label for="example-date-input" class="col-4 col-form-label">Date Max</label>
                                    <div class="col-8">
                                      <input class="form-control" name="dateMax"  type="date" value="{{request()->get('dateMax')}}" id="example-date-input">
                                    </div>
                                  </div>
                                  @cannot('livreur')

                                  <div class="form-group row">
                                    <label class="col-sm-4">Ville :</label>
                                    <div class="col-sm-8">
                                        <select name="ville" class="form-control form-control-line">
                                            <option selected value="">Choisissez la ville</option>

                                            @if(request()->get('ville') != null )
                                            <option selected value="{{request()->get('ville')}}" class="rounded-circle">
                                                {{request()->get('ville')}}
                                            </option>
                                            @endif

                                            @foreach ($villes as $ville)
                                            <option value="{{$ville->name}}" class="rounded-circle">
                                                {{$ville->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endcannot
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

                                  <div class="from-group row">
                                      <label for="bl" class="col-sm-3">BL générée</label>
                                      <div class="col-3">
                                        <input class="form-control" name="bl" type="checkbox" value="1" id="bl">
                                      </div>
                                      <label for="facture" class="col-sm-3">Facturée</label>
                                      <div class="col-3">
                                        <input class="form-control" name="facturer" type="checkbox" value="1" id="facture">
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
                                            <option value=""  selected>Choisissez le fournisseur</option>
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


                                      <fieldset class="form-group col-md-6">
                                        <div class="row">
                                          <legend class="col-form-label  pt-0">Mode de paiement :</legend>
                                          <div class="col-sm-12">
                                            <div class="form-check">
                                              <input  onclick="myFunction2(this.value)" class="form-check-input" type="radio" name="mode" id="cd" value="cd" checked>
                                              <label class="form-check-label" for="cd">
                                                à la livraison
                                              </label>
                                            </div>
                                            <div class="form-check">
                                              <input  onclick="myFunction2(this.value)" class="form-check-input" type="radio" name="mode" id="cp" value="cp">
                                              <label class="form-check-label" for="cp">
                                                carte bancaire
                                              </label>
                                            </div>

                                          </div>
                                        </div>
                                      </fieldset>

                                      <div class="form-group col-md-6" id="isOpen">
                                        <label for="isOpen" class="col-md-12">Client peut ouvrir le colis :</label>
                                        <div class="col-md-12">
                                            <input  value="1" type="checkbox" class="form-control form-control-line" name="isOpen" id="isOpen">
                                        </div>
                                    </div>

                                      <div class="form-group col-md-12" id="montant" style="display: block">
                                        <label for="montantin" class="col-md-12">Montant (DH) :</label>
                                        <div class="col-md-12">
                                            <input  value="{{ old('montant') }}" type="text" class="form-control form-control-line" name="montant" id="montantin">
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
                                    <label class="col-sm-12">Ville :</label>
                                    <div class="col-sm-12">
                                        <select name="ville" class="form-control form-control-line"  onchange="myFunction()" required>
                                            <option checked>Choisissez la ville</option>
                                            @foreach ($villes as $ville)
                                            <option value="{{$ville->name}}" class="rounded-circle">
                                                {{$ville->name}}
                                            </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Adresse :</label>
                                    <div class="col-md-12">
                                        <textarea  name="adresse" rows="5" class="form-control form-control-line">{{ old('adresse') }}</textarea>
                                    </div>
                                </div>
                                <div style="display: none"  class="form-group" id="secteur">
                                    <label class="col-sm-12">Secteur :</label>
                                    <div class="col-sm-12">
                                      <select  value="{{ old('secteur') }}" name="secteur" class="form-control form-control-line" >

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

<div class="container my-4">
    @can('client')
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
                                <div class="form-group">
                                    <label class="col-md-12">Nom et Prénom du destinataire :</label>
                                    <div class="col-md-12">
                                        <input  value="{{ old('nom') }}" name="nom" type="text" placeholder="Nom & Prénom" class="form-control form-control-line">
                                    </div>
                                </div>


                                      <fieldset class="form-group col-md-12">
                                          <legend class="col-form-label  pt-0">Mode de paiement :</legend>
                                          <div class="col-sm-12" style="display: flex;justify-content: space-around;
                                          align-items: center;">
                                            <div class="form-check">
                                              <input  onclick="myFunction2(this.value)" class="form-check-input" type="radio" name="mode" id="cd" value="cd" checked>
                                              <label class="form-check-label" for="cd">
                                              à la livraison
                                              </label>
                                            </div>
                                            <div class="form-check">
                                              <input  onclick="myFunction2(this.value)" class="form-check-input" type="radio" name="mode" id="cp" value="cp">
                                              <label class="form-check-label" for="cp">
                                                carte bancaire
                                              </label>
                                            </div>

                                          </div>
                                      </fieldset>

                                <div class="form-group col-md-12" id="montant"  style="display: block">
                                    <label for="example-email" class="col-md-12">Montant (MAD) :</label>
                                    <div class="col-md-12">
                                        <input  value="{{ old('montant') }}" type="text" class="form-control form-control-line" name="montant" id="example-email">
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
                                       <select name="ville" class="form-control form-control-line"  onchange="myFunction()" required>
                                            <option checked>Choisissez la ville</option>
                                            @foreach ($villes as $ville)
                                            <option value="{{$ville->name}}" class="rounded-circle">
                                                {{$ville->name}}
                                            </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div style="display: none"  class="form-group" id="secteur">
                                    <label class="col-sm-12">Secteur :</label>
                                    <div class="col-sm-12">
                                      <select  value="{{ old('secteur') }}" name="secteur" class="form-control form-control-line">

                                        <option value="">Tous les secteurs</option>
                                     </select>
                                    </div>
                                </div>
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input class="custom-control-input" id="customCheckRegister" type="checkbox" name="isOpen" value="1">
                                    <label class="custom-control-label" for="customCheckRegister">
                                      <span >J'accepte l'ouverture du colis par le client.</span>
                                    </label>
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


@can('ecom')
<div class="container my-4">

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

                              <div id="education_fields">

                              </div>
                                <div class="row" id="test">

                                    <div class="form-group col-md-6">
                                      <label for="produit" class="col-sm-12">Produit :</label>
                                      <div class="col-md-12">
                                          <select name="produit[]" id="produit" class="form-control form-control-line" value="{{ old('produit') }}" required>
                                              <option value="" disabled selected>Produit</option>
                                              @foreach ($produits as $produit)
                                          <option value="{{$produit->id}}" class="rounded-circle">
                                              {{$produit->reference .' '.$produit->libelle}}
                                          </option>
                                              @endforeach

                                          </select>
                                        </div>
                                      </div>

                                      <div class="form-group col-md-4 input-group">
                                        <label for="qte" class="col-md-12">Quantité:</label>
                                        <div class="col-md-12">
                                            <input  value="{{ old('qte') }}" type="number" class="form-control form-control-line" name="qte[]" id="qte" required>
                                        </div>

                                    </div>

                                </div>
                                <div class="input-group-btn col-md-2" style="position: relative; left:350px; top:-55px">
                                  <button class="btn btn-success " type="button"  onclick="education_fields()"> <span class="mdi mdi-library-plus" aria-hidden="true"></span> </button>
                                </div>
                              <div class="form-group">
                                  <label class="col-md-12">Nom et Prénom du destinataire :</label>
                                  <div class="col-md-12">
                                      <input  value="{{ old('nom') }}" name="nom" type="text" placeholder="Nom & Prénom" class="form-control form-control-line">
                                  </div>
                              </div>


                                    <fieldset class="form-group col-md-12">
                                      <div class="row">
                                        <legend class="col-form-label  pt-0">Mode de paiement :</legend>
                                        <div class="col-sm-12" style="display: flex;justify-content: space-around;
                                          align-items: center;">
                                          <div class="form-check">
                                            <input  onclick="myFunction2(this.value)" class="form-check-input" type="radio" name="mode" id="cd" value="cd" checked>
                                            <label class="form-check-label" for="cd">
                                              à la livraison
                                            </label>
                                          </div>
                                          <div class="form-check">
                                            <input  onclick="myFunction2(this.value)"  class="form-check-input" type="radio" name="mode" id="cp" value="cp">
                                            <label class="form-check-label" for="cp">
                                              carte bancaire
                                            </label>
                                          </div>

                                        </div>
                                      </div>
                                    </fieldset>

                                    <div class="form-group col-md-12" id="montant" style="display: block">
                                        <label for="montantin" class="col-md-12">Montant (DH) : <br>
                                            <span style="font-size: 0.75em;">Le montant va être automatiquement calculer si vous ne le mentionner pas</span></label>
                                        <div class="col-md-12">
                                            <input  value="{{ old('montant') }}" type="text" class="form-control form-control-line" name="montant" id="montantin">
                                        </div>
                                    </div>

                              <div class="form-group">
                                  <label class="col-md-12">Téléphone :</label>
                                  <div class="col-md-12">
                                      <input value="{{ old('telephone') }}"  name="telephone" type="text" placeholder="0xxx xxxxxx" class="form-control form-control-line" required>
                                  </div>
                              </div>
                              <div class="form-group">
                                <label class="col-sm-12">Ville:</label>
                                <div class="col-sm-12">
                                    <select value="{{ old('ville') }}" name="ville" class="form-control form-control-line" onchange="myFunction()" required>
                                        <option checked>Choisissez la ville</option>
                                        @foreach ($villes as $ville)
                                          <option value="{{$ville->name}}" class="rounded-circle">
                                              {{$ville->name}}
                                          </option>
                                          @endforeach

                                    </select>
                                </div>
                            </div>
                              <div class="form-group">
                                  <label class="col-md-12">Adresse :</label>
                                  <div class="col-md-12">
                                      <textarea  name="adresse" rows="5" class="form-control form-control-line" required>{{ old('adresse') }}</textarea>
                                  </div>
                              </div>

                              <div style="display: none"  class="form-group" id="secteur">
                                  <label class="col-sm-12">Secteur :</label>
                                  <div class="col-sm-12">
                                    <select  value="{{ old('secteur') }}" name="secteur" class="form-control form-control-line">

                                      </select>
                                  </div>
                              </div>

                              <div class="custom-control custom-control-alternative custom-checkbox">
                                <input class="custom-control-input" id="customCheckRegister" type="checkbox" name="isOpen" value="1">
                                <label class="custom-control-label" for="customCheckRegister">
                                  <span >J'accepte l'ouverture du colis par le client.</span>
                                </label>
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

</div>
@endcan


<form class="form-horizontal form-material" method="POST" id="changingStatusByModelForm">
    @csrf
    @method('PATCH')
    <input type="text" name="statut" id="orderSatus"  style="display: none"> </input>
    <input name="prevu_at" id="orderPostponedDate" type="date"  style="display: none">
    <input type="text" name="commentaire" id="orderComment"  style="display: none"></input>
</form>


@endsection

@section('javascript')
    @if ($errors->any())
        <script type="text/javascript">
            $(window).on('load',function(){
                $('#modalSubscriptionForm').modal('show');
            });
        </script>
    @endif
    <script>
        $(document).ready(function(){
          $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
          });
        });
        </script>

<script>
    var room = 1;
    function education_fields() {

        room++;
        var objTo = document.getElementById('education_fields')
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "row removeclass"+room);
        var rdiv = 'removeclass'+room;

        divtest.innerHTML  = $("#test").html() + '<div class="input-group-btn"> <button class="btn btn-danger m-t-25" type="button" onclick="remove_education_fields('+ room +');"> <span class="mdi mdi-close-box" aria-hidden="true"></span> </button></div></div></div></div><div class="clear"></div>';

        objTo.appendChild(divtest)
    }
    function remove_education_fields(rid) {
        $('.removeclass'+rid).remove();
    }

</script>

<script>



function checkFunction(){

    var cbp = document.getElementById('check_bl');
    if (cbp.checked == true){
        var cbs = document.querySelectorAll('.cb');
        cbs.forEach((cb) => {
            cb.checked = true;
        });
    } else {
        var cbs = document.querySelectorAll('.cb');
        cbs.forEach((cb) => {
            cb.checked = false;
        });
    }
}

function submitForm1(){
    let form = document.getElementById('commandes-form');

    form.action = "{{route('bonCommande.index')}}";
    form.submit();
}

function submitForm2(){
    let form = document.getElementById('commandes-form');
    form.action = "{{route('ticket.index')}}";
    form.submit();
}

function changeStatus(id) {
    let form = document.getElementById('changingStatusByModelForm');
    let orderSatusToCommit = document.getElementById('orderSatus');
    let orderPostponedDateToCommit = document.getElementById('orderPostponedDate');
    let orderCommentToCommit = document.getElementById('orderComment');

    let orderSatusForm = document.getElementById('etat'+id).value;
    let orderPostponedDateForm = document.getElementById('datePrevu'+id).value;
    let orderCommentForm = document.getElementById('commentaire'+id).value;

    orderSatusToCommit.value = orderSatusForm ;
    orderPostponedDateToCommit.value = orderPostponedDateForm ;
    orderCommentToCommit.value = orderCommentForm ;
    form.action = "/commandes/"+id+"/statut";
    form.method = "post";
    form.submit();
}


</script>

<script>
    function reporter(id) {
        var xx = document.getElementById("prevu"+id);

        var test = document.getElementById("etat"+id).value;
        //alert(test);
        if(test=='Reporté'){
            xx.style.display = "block";
        }
        else{
            xx.style.display = "none";
        }
    }
</script>

@endsection
