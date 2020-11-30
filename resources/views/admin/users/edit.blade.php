
@extends('racine')

@section('title')
   Gestion des Utilisateurs
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
        <div class="col-5">
            <h4 class="page-title">Gestion des Utilisateurs</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Colisade</a></li>
                        <li class="breadcrumb-item"><a href="/admin/users">Utilisateurs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$user->name}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    
    </div>
</div>

<div class="container-fluid">
    
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Modifier l'utilisateur: {{ $user->name}}</div>

                <div class="card-body">
                <form method="POST" action="{{route('admin.users.update',$user)}}">
                    @csrf
                    @method("PUT")
                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label text-md-right">Nom & Prénom: </label>

                        <div class="col-md-10">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required  autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-2 col-form-label text-md-right">Email: </label>

                        <div class="col-md-10">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label text-md-right">Url de l'image</label>
                        <div class="col-md-10">
                            <input name="image" type="text" value="{{$user->image}}"class="form-control form-control-line">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label text-md-right">Ville</label>
                        <div class="col-md-10">
                            <select name="ville" class="form-control form-control-line" id="ville" onchange="myFunction()" required>
                                <option checked value="{{$user->ville}}"> {{$user->ville}}</option>
                                <option value="Agadir"> Agadir</option>
                                    <option value="Al Hoceima"> Al Hoceima</option>
                                    <option value="Béni Mellal"> Béni Mellal</option>
                                    <option value="Casablanca">Casablanca</option>
                                    <option value="El Jadida"> El Jadida</option>
                                    <option value="Errachidia"> Errachidia</option>
                                    <option value="Fès"> Fès</option>
                                    <option value="Khénifra"> Khénifra</option>
                                    <option value="Khouribga"> Khouribga</option>
                                    <option value="Kénitra">Kénitra</option>
                                    <option value="Larache"> Larache</option>
                                    <option value="Marrakech">Marrakech</option>
                                    <option value="Meknès"> Meknès</option>
                                    <option value="Nador"> Nador</option>
                                    <option value="Ouarzazate"> Ouarzazate</option>
                                    <option value="Oujda"> Oujda</option>
                                    <option value="Rabat"> Rabat</option>
                                    <option value="Safi"> Safi</option>
                                    <option value="Settat"> Settat</option>
                                    <option value="Salé"> Salé</option>
                                    <option value="Tanger"> Tanger</option>
                                    <option value="Taza"> Taza</option>
                                    <option value="Tétouan"> Tétouan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label text-md-right">ICE</label>
                        <div class="col-md-10">
                            <input name="description" type="text" value="{{$user->description}}"class="form-control form-control-line">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label text-md-right">RIB</label>
                        <div class="col-md-10">
                            <input name="rib" type="text" value="{{$user->rib}}"class="form-control form-control-line">
                        </div>
                    </div>

                    
                    
                    <div class="form-group row">
                        <label for="roles" class="col-md-12 col-form-label text-center font-bold font-16">Rôles Colisade : </label>
                        <label for="roles" class="col-md-2 col-form-label text-md-right">Rôle : </label>
                        <div class="col-md-10 d-flex p-t-10 justify-content-around">
                            <div class="form-check">
                                <input type="radio" name="roles[]" value="1" id="admin" @if(implode($user->roles()->get()->pluck('name')->toarray()) == "admin") checked @endif>
                                <label for="admin">Admin</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="roles[]" value="3" id="Livreur" @if(implode($user->roles()->get()->pluck('name')->toarray()) == "livreur") checked @endif >
                                <label for="Livreur">Livreur</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="roles[]" value="4" id="Personnel" @if(implode($user->roles()->get()->pluck('name')->toarray()) == "personnel") checked @endif>
                                <label for="Personnel">Personnel</label>
                            </div>
                        </div>
                        <label for="roles" class="col-md-12 col-form-label text-center font-bold font-16">Utilisateur Client : </label>
                        <label for="roles" class="col-md-2 col-form-label text-md-right">Service : </label>
                        <div class="col-md-10 d-flex p-t-10 justify-content-around">
                            <div class="form-check">
                                <input type="radio" name="roles[]" value="6" id="nv" @if(implode($user->roles()->get()->pluck('name')->toarray()) == "nouveau") checked @endif>
                                <label for="nv">Nouveau</label>
                            </div>
                        <div class="form-check">
                            <input type="radio" name="roles[]" value="2" id="cl" @if(implode($user->roles()->get()->pluck('name')->toarray()) == "client") checked @endif>
                            <label for="cl">Collecte, Livraison</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="roles[]" value="5" id="cls" @if(implode($user->roles()->get()->pluck('name')->toarray()) == "ecom") checked @endif>
                            <label for="cls">Collecte, Stockage, Livraison</label>
                        </div>
                      
                    
                        </div>
                        

                            <label for="type" class="col-md-2 col-form-label text-md-right">Statut : </label>
                            <div class="col-md-10 d-flex p-t-10 justify-content-around">
                            <div class="form-check">
                                <input type="radio" name="statut" value="0" id="Premium" @if( !$user->statut) checked @endif>
                                <label for="Premium">Premium</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="statut" value="1" id="VIP" @if($user->statut) checked @endif>
                                <label for="VIP">VIP</label>
                            </div>
                        
                            </div>

                    </div>
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </form>
                  
                     
                  
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