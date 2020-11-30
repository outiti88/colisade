@extends('racine')

@section('title')
Relances
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
            color: #f7941e;
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
            border-bottom:2px solid #f7941e;
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
            color: #f7941e;
        }
        a {
            color: #f7941e;
        }
        a:hover {
            color: #f7941e;
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

<div class="container-fluid">
    <div class="container emp-profile">
        <div class="row">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                <a class="nav-link active" id="vip-tab" data-toggle="tab" href="#vip" role="tab" aria-controls="vip" aria-selected="true">VIP</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" id="relance1-tab" data-toggle="tab" href="#relance1" role="tab" aria-controls="relance1" aria-selected="false">Relance 1</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" id="relance2-tab" data-toggle="tab" href="#relance2" role="tab" aria-controls="relance2" aria-selected="false">Relance 2</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="relance3-tab" data-toggle="tab" href="#relance3" role="tab" aria-controls="relance3" aria-selected="false">Relance 3</a>
                </li>
            </ul>
        </div>
        <div class="row">

            <div class="tab-content col-12" id="myTabContent">

                <div class="tab-pane fade show active" id="vip" role="tabpanel" aria-labelledby="vip-tab">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Relances 1 </h4>
                            <h6 class="card-subtitle">Vous pouvez <code>Relancer</code> tous ces commandes deux fois de plus.</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Client</th>
                                        <th scope="col">Numero commande</th>
                                        <th scope="col">Nom Complet</th>
                                        <th scope="col">Téléphone</th>
                                        <th scope="col">Ville</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Statut</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($vip as $index => $commande)
                                    <tr>
                                        <th scope="row">
                                            <a class=" text-muted waves-effect waves-dark pro-pic vip" >
                                                <img src="{{$commande->image}}" alt="user" class="rounded-circle" width="31">
                                            </a>
                                        </th>
                                        <td>{{$commande->numero}}</td>
                                        <td>{{$commande->nom}}</td>
                                        <td>{{$commande->telephone}}</td>
                                        <td>{{$commande->ville}}</td>
                                        <td>{{$commande->created_at}}</td>
                                        <td>{{$commande->statut}}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="10" style="text-align: center">Aucune commande enregistrée!</td>
                                    </tr>
                                    
                                    @endforelse
                                 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="tab-pane fade" id="relance1" role="tabpanel" aria-labelledby="relance1-tab">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Relances 1 </h4>
                                <h6 class="card-subtitle">Vous pouvez <code>Relancer</code> tous ces commandes deux fois de plus.</h6>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Client</th>
                                            <th scope="col">Numero commande</th>
                                            <th scope="col">Nom Complet</th>
                                            <th scope="col">Téléphone</th>
                                            <th scope="col">Ville</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Statut</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($relance1 as $index => $commande)
                                        <tr>
                                            <th scope="row">
                                                <a class=" text-muted waves-effect waves-dark pro-pic vip" >
                                                    <img src="{{$commande->image}}" href="{{route('admin.users.edit',$commande->user_id)}}" alt="user" class="rounded-circle" width="31">
                                                </a>
                                            </th>
                                            <td>{{$commande->numero}}</td>
                                            <td>{{$commande->nom}}</td>
                                            <td>{{$commande->telephone}}</td>
                                            <td>{{$commande->ville}}</td>
                                            <td>{{$commande->created_at}}</td>
                                            <td>{{$commande->statut}}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="10" style="text-align: center">Aucune commande enregistrée!</td>
                                        </tr>
                                        
                                        @endforelse
                                     
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>

                <div class="tab-pane fade" id="relance2" role="tabpanel" aria-labelledby="relance2-tab">

                </div>
                <div class="tab-pane fade" id="relance3" role="tabpanel" aria-labelledby="relance3-tab">Relance 3</div>
            </div>
        </div>
    </div>
</div>

@endsection
