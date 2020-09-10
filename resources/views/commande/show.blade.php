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
        <div class="col-5">
            <h4 class="page-title">Gestion des Colis</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Quickoo</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="/commandes">Colis</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$commande->numero}}</li
                        
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-7">
            <div class="text-right upgrade-btn">
                <a  class="btn btn-danger text-white"  data-toggle="modal" data-target="#modalSubscriptionForm"><i class="fa fa-plus-square"></i> Ajouter une commande</a>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="container emp-profile">
       
        <div class="row">
          
            <div class="col-md-10">
                <div class="profile-head">
                            <h5>
                                Commande numero:
                            </h5>
                            <h6>
                                {{$commande->numero}}
                            </h6>
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
                <input type="submit" class="profile-edit-btn" name="btnAddMore" value="Imprimer"/>
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
                                        <label>Montant :</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$commande->montant}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Prix de livraison :</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$commande->prix}}</p>
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
                                        <label>Type de poids :</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$commande->poids}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Statut de la commande :</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$commande->statut}} ({{$commande->updated_at->diffForHumans()}})</p>
                                        <p class="proile-rating">Date : {{date_format($commande->created_at,"Y/m/d")}}<span> {{date_format($commande->updated_at,"H:i:s")}}</span></p>
                                    </div>
                                </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>STATUT</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>DATE</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                    <label>{{$commande->statut}}</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$commande->created_at}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                    <label>{{$commande->statut}}</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$commande->created_at}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                    <label>{{$commande->statut}}</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$commande->created_at}}</p>
                                    </div>
                                </div>
                                
                        <div class="row">
                            <div class="col-md-12">
                                <label>Commentaire</label><br/>
                                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Consectetur rem non, voluptatibus nemo blanditiis modi maiores nulla in, cum quis sapiente doloribus. Corporis autem facere, corrupti eum modi nemo veniam.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
               
</div>
</div>
   

@endsection