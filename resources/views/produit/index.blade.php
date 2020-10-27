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
                        <li class="breadcrumb-item"><a href="/">Colisade</a></li>
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
                                @can('ramassage-commande')
                                <th scope="col">Client</th>
                                @endcan
                                <th scope="col">Image</th>
                                <th scope="col">Reference</th>
                                <th scope="col">Libelle</th>
                                <th scope="col">Categorie</th>
                                <th scope="col">Prix</th>
                                <th scope="col">Quantité</th>
                                <th scope="col">En commande</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           @forelse ($produits as $index => $produit)
                           <tr>
                            @can('ramassage-commande')
                            <th scope="row">
                                <a title="{{$users[$index]->name}}" class=" text-muted waves-effect waves-dark pro-pic" 
                                       
                                            @can('edit-users')
                                                href="{{route('admin.users.edit',$users[$index]->id)}}"
                                            @endcan

                                        
                                    >
                                    <img src="{{$users[$index]->image}}" alt="user" class="rounded-circle" width="31">
                                </a>
                            </th>
                            @endcan

                            <th scope="row"> <a title="{{$produit->reference}}" class=" text-muted waves-effect waves-dark pro-pic">
                                    <img src="/uploads/produit/{{$produit->photo}}" alt="user" class="rounded-circle" width="31">
                                </a></th>
                            <td>{{$produit->reference}}</td>
                            <td>{{$produit->libelle}}</td>
                            <td>{{$produit->categorie}}</td>
                            <td>{{$produit->prix}} MAD</td>
                            <td>{{$stock[$index]->qte}}</td>
                            <td>
                            <a href="{{route('reception.index')}}" style="color: white" 
                                    class="badge badge-pill badge-danger">
                                {{$stock[$index]->cmd}}
                                </a>
                            </td>
                            
         
                           <td style="font-size: 1.5em">
                           
                            <a style="color: #f7941e" href="/produit/{{$produit->id}}">
                                <i class="ti-pencil""></i></a>
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





<div class="container my-4">    
    @can('ecom')
    <div class="modal fade" id="modalStockAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header text-center">
                          <h4 class="modal-title w-100 font-weight-bold">Nouveau Produit</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body mx-3">
                            <form class="form-horizontal form-material" method="POST" action="{{route('produit.store')}}" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="form-group">
                                    <label class="col-md-12">Libelle du Produit :</label>
                                    <div class="col-md-12">
                                        <input  value="{{ old('libelle') }}" name="libelle" type="text" placeholder="Libelle" class="form-control form-control-line" required>
                                    </div>
                                </div>
                               
                                <div class="form-group col-md-12">
                                    <label for="example-email" class="col-md-12">Prix (MAD) :</label>
                                    <div class="col-md-12">
                                        <input  value="{{ old('prix') }}" type="number" class="form-control form-control-line" name="prix" >
                                    </div>
                                </div>
                
                                <div class="form-group">
                                    <label class="col-md-12">Description :</label>
                                    <div class="col-md-12">
                                        <textarea  name="description" rows="5" class="form-control form-control-line">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12">Categorie :</label>
                                    <div class="col-sm-12">
                                        <select name="categorie" class="form-control form-control-line" >
                                            <option >Vêtements</option>
                                            <option >Chaussures</option>
                                            <option >Bijoux et accessoires</option>
                                            <option >Produits Cosmétiques</option>
                                            <option >Produits High Tech</option>
                                            <option >Librairie</option>
                                            <option >Maroquinerie</option>
                                            <option >Végétaux</option>
                                            <option >Autres</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                    </div>
                                    <div class="custom-file">
                                      <input type="file" name="photo" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                      <label class="custom-file-label" for="inputGroupFile01">choisir une photo</label>
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