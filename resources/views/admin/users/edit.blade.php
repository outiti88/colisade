
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
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label text-md-right">Prix de livraison</label>
                        <div class="col-md-10">
                            <input name="prix" type="number" value="{{$user->prix}}"class="form-control form-control-line">
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
<script>
    var arr =
        {"Martil" : "45,00 DH" ,
        "M'diq" : "45,00 DH" ,
        "Fnideq" : "45,00 DH" ,
        "larache" : "45,00 DH" ,
        "Ksar lkbir" : "50,00 DH" ,
        "Ksar sghir" : "50,00 DH" ,
        "Assilah" : "50,00 DH" ,
        "Al Hoceima" : "50,00 DH" ,
        "Bab bered" : "50,00 DH" ,
        "Bab taza" : "50,00 DH" ,
        "Dardara" : "50,00 DH" ,
        "Akchour" : "50,00 DH" ,
        "Tetouan" : "40,00 DH" ,
        "Taza" : "40,00 DH" ,
        "Casablanca" : "30,00 DH" ,
        "Marrakech" : "40,00 DH" ,
        "Fès" : "35,00 DH" ,
        "Tiznit" : "45,00 DH" ,
        "Taroudant" : "45,00 DH" ,
        "Haouara" : "45,00 DH" ,
        "Belfaa" : "45,00 DH" ,
        "Massa" : "45,00 DH" ,
        "Khmis Ait Amira" : "45,00 DH" ,
        "Sidi Bibi" : "45,00 DH" ,
        "Bikra" : "45,00 DH" ,
        "Oulad Tayma" : "45,00 DH" ,
        "El-Hajeb" : "40,00 DH" ,
        "Boufakrane" : "45,00 DH" ,
        "Sabaa Aiyoun" : "45,00 DH",
        "Azrou" : "45,00 DH" ,
        "El Hadj Kaddour" : "45,00 DH" ,
        "Ifrane" : " 40,00 DH" ,
        "Imouzar" : " 45,00 DH" ,
        "Ain Leuh" : " 45,00 DH" ,
        "Moulay Idriss Zerhoun" : " 45,00 DH" ,
        "Ain karma" : " 45,00 DH" ,
        "Ain Taoujdate" : " 45,00 DH" ,
        "EL mhaya" : " 45,00 DH" ,
        "Sidi Addi" : " 45,00 DH" ,
        "Tiflet" : "45,00 DH " ,
        "Tarfaya" : " 45,00 DH" ,
        "Boujdour" : "45,00 DH " ,
        "Es -semara" : "45,00 DH " ,
        "Dakhla" : "45,00 DH " ,
        "Sidi  Yahya El GHarb" : "45,00 DH " ,
        "Sidi  Yahya des zaer" : "45,00 DH " ,
        "Temara" : "30,00 DH " ,
        "Sale" : "30,00 DH " ,
        "Ain El Aouda" : " 30,00 DH" ,
        "Sale EL-jadida" : "30,00 DH " ,
        "Ain Atiq" : "45,00 DH" ,
        "Tamsna" : "45,00 DH" ,
        "Mers El kheir" : "45,00 DH" ,
        "Bouknadal" : "45,00 DH" ,
        "Skhirat" : "45,00 DH" ,
        "Sidi Taibi" : "45,00 DH" ,
        "Kenitra" : "40,00 DH" ,
        "Sidi slimane" : "45,00 DH" ,
        "Sidi kacem" : "45,00 DH" ,
        "Berkan" : " 50,00 DH" ,
        "Aklim" : "50,00 DH " ,
        "Cafemor-chouihia" : " 50,00 DH" ,
        "Saidia" : "50,00 DH " ,
        "Ahfir" : "50,00 DH " ,
        "Taourirt" : " 50,00 DH" ,
        "Beni drar" : "50,00 DH" ,
        "Bni Oukil" : "50,00 DH" ,
        "Jerada" : "50,00 DH" ,
        "Laayoune" : "50,00 DH" ,
        "Ejdar" : "50,00 DH" ,
        "Ihddaden" : "50,00 DH" ,
        "Touima" : "50,00 DH" ,
        "bouraj" : "50,00 DH" ,
        "Bni Ensar" : "50,00 DH" ,
        "Farkhana" : "50,00 DH" ,
        "Beni chiker" : "50,00 DH" ,
        "bouaarek" : "50,00 DH" ,
        "selouane" : "50,00 DH" ,
        "zghanghan" : "50,00 DH" ,
        "Arekmane" : "50,00 DH" ,
        "El Aroui" : "50,00 DH" ,
        "Safi" : "40,00 DH" ,
        "Essaouira" : "40,00 DH" ,
        "Chichaoua" : "45,00 DH" ,
        "Tamnsourt" : "45,00 DH" ,
        "Oudaya (Marrakech)" : "45,00 DH" ,
        "Douar Lahna" : "50.00 DH" ,
        "Douar  Sidi Moussa" : "45,00 DH" ,
        "Belaaguid" : "45,00 DH" ,
        "Dar Tounssi" : "45,00 DH" ,
        "Chouiter" : "45,00 DH" ,
        "Sidi Zouine" : "45,00 DH" ,
        "Tamesloht" : "45,00 DH" ,
        "Ait Ourir" : "45,00 DH" ,
        "Tahannaout" : "45,00 DH" ,
        "Tit Melil" : "45,00 DH" ,
        "Mediouna" : "45,00 DH" ,
        "Bouskoura" : "45,00 DH" ,
        "Mohammedia" : "40,00 DH" ,
        "Echellalat" : "50,00 DH" ,
        "Deroua" : "50,00 DH" ,
        "Nouacer" : "50,00 DH" ,
        "Dar bouaaza" : "50,00 DH" ,
        "Tamaris" : "50,00 DH" ,
        "Al rahma" : "45,00 DH" ,
        "Ouad zem" : "50,00 DH" ,
        "Boujniba" : "50,00 DH" ,
        "Boulnouar" : "50,00 DH" ,
        "Fini" : "50,00 DH" ,
        "Beni Mellal" : "40,00 DH" ,
        "Ouarzazate" : "50,00 DH" ,
        "Tghsaline" : "45,00 DH" ,
        "Ait Ishaq" : "45,00 DH" ,
        "Lakbab" : "45,00 DH" ,
        "lahri" : "45,00 DH" ,
        "Mrirt" : "45,00 DH" ,
        "Settat" : "40,00 DH" ,
        "sidi bouzid" : "40,00 DH" ,
        "Moulay abedellah" : "45,00 DH" ,
        "sidi aabed (eljadida)" : "45,00 DH" ,
        "azmour" : "45,00 DH" ,
        "Bir jdid" : "45,00 DH" ,
        "Msewar rassou" : "50,00 DH" ,
        "Sidi Ismail" : "50,00 DH" ,
        "Sidi Benour" : "50,00 DH" ,
        "Khmis Zmamra" : "50,00 DH" ,
        "Oulad  frej" : "50,00 DH" ,
        "Chefchaouen" : "40,00 DH" ,
        "Elbradiya" : "45,00 DH" ,
        "Ihrem Laalam" : "45,00 DH" ,
        "Elfkih ben saleh" : "45,00 DH" ,
        "Souk essabt/ oulad nema" : "45,00 DH" ,
        "Azilal" : "50,00DH" ,
        "Ouaouizght" : "45,00DH" ,
        "Khnifra" : "45,00 DH" ,
        "Ben louidane" : "50,00 DH" ,
        "Zauiyat Echikh" : "50,00 DH" ,
        "Tadla" : "50,00 DH" ,
        "Afourar" : "50,00 DH" ,
        "Laayata" : "50,00 DH" ,
        "Oulad  Youssef" : "50,00 DH" ,
        "Adouz" : "50,00 DH" ,
        "Sidi  Jaber" : "50,00 DH" ,
        "Ooulad  Zidouh" : "50,00 DH" ,
        "Lakssiba" : "50,00 DH" ,
        "Beni  Aayat" : "50,00 DH" ,
        "Oulad  Aayad" : "50,00 DH" ,
        "Tagzirt" : "50,00 DH" ,
        "Sidi Issa" : "50,00 DH" ,
        "Oulad M'barek" : "50,00 DH" ,
        "Oulad  Zam" : "50,00 DH" ,
        "Agadir" : "40,00 DH" ,
        "Oulad Ayach" : "50,00 DH" ,
        "Foum Nsser" : "50,00 DH ",
        "Tanougha" : "50,00 DH ",
        "Taounate" : "50,00 DH ",
        "Tahla" : " 45,00DH",
        "Guercif" : " 45,00DH",
        "Ouad  Amlil" : " 45,00DH",
        "Essaouira" : " 40,00 DH",
        "Berchid" : " 40,00 DH",
        "Bouznika" : " 40,00 DH",
        "Tanger" : " 40,00 DH",
        "Guelmim" : " 50.00 DH",
        "Tan Tan" : " 50.00 DH",
        "Tan Tan plage" : " 50.00 DH",
        "Sidi ifni" : " 50.00 DH",
        "Ait lmour" : " 45.00DH",
        "Souk Larbaa" : " 45.00DH",
        "Rabat" : "25.00 DH ",
        "Driouach" : "60,00 DH ",
        "Errachidia" : " 50,00 DH",
        "Khmiset" : " 50,00 DH",
        "Ben Slimane" : " 50,00 DH",
        "Ouazzane" : "45,00 DH ",
        "Sefrou" : " 45,00 DH",
        "Sidi benour" : " 50,00 DH",
        "Had Hrara" : " 60,00 DH",
        "Zrarda" : "45,00 DH ",
        "Zoumi" : "50 ,00 DH ",
        "Mokrissat" : "50 ,00 DH ",
        "Souk ELaha" : "50 ,00 DH ",
        "Ain Dorij" : "50 ,00 DH ",
        "Sidi redouane" : "50 ,00 DH ",
        "Massmouda" : " 50 ,00 DH", 
        "Sidi Rahal" : " 45 ,00 DH",
        "Had Soualem" : " 45 ,00 DH",
        "Oujda" : "40 ,00 DH ",
        "Sefrou" : " 45 ,00 DH",
        "Oulad tayeb" : "40,00  DH ",
        "Ain chekaf" : "40,00  DH ",
        "Ain chegag" : " 50,00 DH",
        "Bel ksir" : " 50,00 DH", 
        "Meknès" : "40,00  DH ",
        "Sidi Hrazem" : "50,00 DH ",
        "Nador" : "40,00  DH ",
            "Khouribga" : "40,00 DH",
            "El Youssoufia" : "50,00 DH"

        };
            
  
    
    
  var x3 = document.getElementById("ville");
  

  for (const [key, value] of Object.entries(arr)) {
  var option = document.createElement("option");
         x3.appendChild(option);
        var text1 = document.createTextNode(key);
        option.appendChild(text1);
          
      
	}
</script>
    @if ($errors->any())
        <script type="text/javascript">
            $(window).on('load',function(){
                $('#modalSubscriptionForm').modal('show');
            });
        </script>
    @endif
@endsection