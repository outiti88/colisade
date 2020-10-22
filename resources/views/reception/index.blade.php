@extends('racine')

@section('title')
   Reception
@endsection

@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-5">
            <h4 class="page-title">Reception</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Quickoo</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Reception</li>
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
                <a  class="btn btn-danger text-white"  data-toggle="modal" data-target="#modalReception"><i class="fa fa-plus-square"></i> Envoyer</a>
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
                    <h4 class="card-title">Receptions</h4>
                    <h6 class="card-subtitle">Nombre total des receptions : <code>{{$total}} Receptions</code> .</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" style="font-size: 0.85em;">
                        <thead>
                            <tr>
                                @can('ramassage-commande')
                                <th scope="col">Client</th>
                                @endcan
                                <th scope="col">Reference</th>
                                <th scope="col">Nbr de produit</th>
                                <th scope="col">Quantité</th>
                                <th scope="col">Date Envoie</th>
                                <th scope="col">Transport</th>
                                <th scope="col">Date d'arrivé</th>
                                <th scope="col">Etat</th>
                            </tr>
                        </thead>
                        <tbody>
                           @forelse ($receptions as $index => $reception)
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
                            <td>{{$reception->reference}}</td>
                            <td>{{$reception->colis}}</td>
                            <td>{{$reception->qte}}</td>
                            <td>{{$reception->created_at}}</td>
                            <td>{{$reception->company}}</td>
                            <td>{{$reception->prevu_at}}</td>
                            <td>{{$reception->etat}}</td>

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
    
<div class="container my-4">    
  
    <div class="modal fade" id="modalReception" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header text-center">
                          <h4 class="modal-title w-100 font-weight-bold">Envoyer une reception</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body mx-3">
                            <form class="form-horizontal form-material" method="POST" action="{{route('reception.store')}}">
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
                                    <button class="btn btn-success " type="button"  onclick="education_fields();"> <span class="mdi mdi-library-plus" aria-hidden="true"></span> </button>
                                  </div>
                                <div class="form-group">
                                    <label class="col-md-12">Entreprise de logistique :</label>
                                    <div class="col-md-12">
                                        <input  value="{{ old('company') }}" name="company" type="text" placeholder="Entreprise de logistique" class="form-control form-control-line" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-date-input" class="col-12 col-form-label">Date Prévu</label>
                                    <div class="col-12">
                                      <input class="form-control" name="prevu_at" type="date" value="{{now()}}" id="example-date-input" required>
                                    </div>
                                  </div>
                               
                                <div class="form-group">
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button class="btn btn-danger">Envoyer</button>
                                        
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
@endsection