@extends('racine')

@section('title')
    Gestion des factures
@endsection




@section('style')
    <style>
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
        @if (session()->has('search'))
        <div class="alert alert-dismissible alert-warning col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Oupss !</strong> Il n'existe aucun numero de facture avec : {{session()->get('search')}}  </a>.
          </div>
        @endif
        @if (session()->has('nbrCmdLivre'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Erreur ! </strong>vous ne pouvez pas charger la facture avec 0 commande livrée !
          </div>
        @endif
        @if (session()->has('nbrCmdRamasse'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Erreur ! </strong>vous ne pouvez pas charger la facture avec sans traité tous les commandes ! <br>
        Il vous reste {{session()->get('nbrCmdRamasse')}} à traiter !
          </div>
        @endif

        @if (session()->has('facNoExist'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Erreur ! </strong>Cette facture à été déjà générée !
          </div>
        @endif

        @if (session()->has('ajoute'))
        <div class="alert alert-dismissible alert-success col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Et voilà ! </strong>La facture à été bien généner !
          </div>
        @endif
        @if (session()->has('envoyer'))
        <div class="alert alert-dismissible alert-success col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Succés</strong> La facture à été bien envoyer à  : {{session()->get('envoyer')}}  </a>.
          </div>
        @endif
        <div class="col-5">
            <h4 class="page-title">Gestion des factures</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Colisade</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Facture</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-7">
            <div class="text-right upgrade-btn">
                @can('ramassage-commande')
                <a  class="btn btn-danger text-white"  data-toggle="modal" data-target="#modalfacture"><i class="fa fa-plus-square">
                    </i> Générer la facture
                </a>

                </select>
                @endcan
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
            <div class="card-header">{{ __('Total des Factures générées : ') }} {{ $total }}</div>

                <div class="card-body ">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                              <tr>
                                @can('ramassage-commande')
                                <th scope="col">#</th>
                                @endcan
                                <th scope="col">Code</th>
                                <th scope="col">Commandes livrées</th>
                                <th scope="col">Montant Total</th>
                                <th scope="col">Frais de Livraison</th>
                                <th scope="col">Commandes non livrées</th>
                                <th scope="col">Colis non livrés</th>
                                <th scope="col">Date d'ajout</th>
                                <th scope="col">Imprimer la facture</th>
                                @can('ramassage-commande')
                                <th scope="col">Envoyer par mail</th>
                                @endcan
                              
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($factures as $index => $facture)
                              <tr>
                                @can('ramassage-commande')
                                <th scope="row"><img src="{{$users[$index]->image}}" alt="user" class="rounded-circle" width="31"></th>
                                @endcan
                                <th>
                                    <a class="btn btn-light" href="{{route('facture.search',$facture->id)}}">
                                        {{$facture->numero}}
                                    </a>
                                </th>
                                <td>{{ $facture->livre}}</td>
                                <td>{{ $facture->montant}} DH</td>
                                <td>{{ $facture->prix}} DH</td>
                                <td>{{$facture->commande}}</td>
                                <td>{{$facture->colis}}</td>
                                <td>{{ $facture->created_at}}</td>
                                <td>
                                    <a class="btn btn-warning text-white m-r-5" href="{{route('facture.gen',$facture->id)}}" target="_blank"><i class="mdi mdi-printer"></i></a>
                                </td>
                                @can('ramassage-commande')
                                <td>
                                    <a class="btn btn-info text-white m-r-5" href="{{route('email.facture',$facture->id)}}" ><i class="mdi mdi-send"></i></a>
                                </td>
                                @endcan
                            </tr>
                              @endforeach
    
                            </tbody>
                          </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



<div class="container my-4">    
    <div class="modal fade" id="modalfacture" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header text-center">
                          <h4 class="modal-title w-100 font-weight-bold">Choisissez le fournisseur</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body mx-3">
                            <form class="form-horizontal form-material" method="POST" action="{{route('facture.store')}}">
                                @csrf
                                
                                
                                <div class="form-group">
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
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button class="btn btn-warning">Générer</button>
                                        
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
    @if ($errors->any())
        <script type="text/javascript">
            $(window).on('load',function(){
                $('#modalSubscriptionForm').modal('show');
            });
        </script>
    @endif
@endsection