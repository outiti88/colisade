@extends('racine')


@section('title')
    Nouveau Utilisateur
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
                        <li class="breadcrumb-item"><a href="/">Utilisateurs</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ajouter</li>
                    </ol>
                </nav>
            </div>
        </div>

    </div>
</div>



<div class="container-fluid">
        <div class="alert alert-dismissible alert-warning col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Si l'utilisateur est un client c'est recommondé de laisser le mot de passe par defaut : Colisade2020 </a>.
          </div>
    <div class="row justify-content-center">

        <div class="col-md-10">

            <div class="card">
                <div class="card-header">
                    Ajouter un nouveau utilisateur:
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('register') }}">


                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-2 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-4">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <label for="email" class="col-md-2 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-4">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-2 col-form-label text-md-right">{{ __('ICE') }}</label>

                            <div class="col-md-4">
                                <input id="description" type="text" class="form-control"  name="description" value="{{ old('description') }}" >

                            </div>
                            <label for="ville" class="col-md-2 col-form-label text-md-right">{{ __('Ville') }}</label>

                            <div class="col-md-4">
                                <select  value="{{ old('ville') }}"  name="ville" class="form-control form-control-line" id="ville" onchange="myFunction()" required>
                                            <option selected="" disabled="">Choisissez la ville</option>
                                                                                        <option value="Adouz" class="rounded-circle">
                                                Adouz
                                            </option>
                                                                                        <option value="Afourar" class="rounded-circle">
                                                Afourar
                                            </option>
                                                                                        <option value="Agadir" class="rounded-circle">
                                                Agadir
                                            </option>
                                                                                        <option value="Agdz" class="rounded-circle">
                                                Agdz
                                            </option>
                                                                                        <option value="Aglmous" class="rounded-circle">
                                                Aglmous
                                            </option>
                                                                                        <option value="Aguime" class="rounded-circle">
                                                Aguime
                                            </option>
                                                                                        <option value="Ahfir" class="rounded-circle">
                                                Ahfir
                                            </option>
                                                                                        <option value="Ain Atiq" class="rounded-circle">
                                                Ain Atiq
                                            </option>
                                                                                        <option value="Ain Cheggag" class="rounded-circle">
                                                Ain Cheggag
                                            </option>
                                                                                        <option value="Ain Chkef" class="rounded-circle">
                                                Ain Chkef
                                            </option>
                                                                                        <option value="Ain Dorij" class="rounded-circle">
                                                Ain Dorij
                                            </option>
                                                                                        <option value="Ain El Aouda" class="rounded-circle">
                                                Ain El Aouda
                                            </option>
                                                                                        <option value="Ain Harouda" class="rounded-circle">
                                                Ain Harouda
                                            </option>
                                                                                        <option value="Ain Karma" class="rounded-circle">
                                                Ain Karma
                                            </option>
                                                                                        <option value="Ain Leuh" class="rounded-circle">
                                                Ain Leuh
                                            </option>
                                                                                        <option value="Ain Taoujdate" class="rounded-circle">
                                                Ain Taoujdate
                                            </option>
                                                                                        <option value="Ait Benhaddou" class="rounded-circle">
                                                Ait Benhaddou
                                            </option>
                                                                                        <option value="Ait Imour" class="rounded-circle">
                                                Ait Imour
                                            </option>
                                                                                        <option value="Ait Ishaq" class="rounded-circle">
                                                Ait Ishaq
                                            </option>
                                                                                        <option value="Aït Melloul" class="rounded-circle">
                                                Aït Melloul
                                            </option>
                                                                                        <option value="Ait Ourir" class="rounded-circle">
                                                Ait Ourir
                                            </option>
                                                                                        <option value="Ait Zineb" class="rounded-circle">
                                                Ait Zineb
                                            </option>
                                                                                        <option value="Akchour" class="rounded-circle">
                                                Akchour
                                            </option>
                                                                                        <option value="Aklim" class="rounded-circle">
                                                Aklim
                                            </option>
                                                                                        <option value="Al hoceima" class="rounded-circle">
                                                Al hoceima
                                            </option>
                                                                                        <option value="Al Rahma" class="rounded-circle">
                                                Al Rahma
                                            </option>
                                                                                        <option value="Amerzgane" class="rounded-circle">
                                                Amerzgane
                                            </option>
                                                                                        <option value="Amizmiz" class="rounded-circle">
                                                Amizmiz
                                            </option>
                                                                                        <option value="Aoufous" class="rounded-circle">
                                                Aoufous
                                            </option>
                                                                                        <option value="Arekmane" class="rounded-circle">
                                                Arekmane
                                            </option>
                                                                                        <option value="Arfoud" class="rounded-circle">
                                                Arfoud
                                            </option>
                                                                                        <option value="Assa-Zag" class="rounded-circle">
                                                Assa-Zag
                                            </option>
                                                                                        <option value="Assilah" class="rounded-circle">
                                                Assilah
                                            </option>
                                                                                        <option value="attaouia" class="rounded-circle">
                                                attaouia
                                            </option>
                                                                                        <option value="Azemour" class="rounded-circle">
                                                Azemour
                                            </option>
                                                                                        <option value="Azilal" class="rounded-circle">
                                                Azilal
                                            </option>
                                                                                        <option value="Azrou" class="rounded-circle">
                                                Azrou
                                            </option>
                                                                                        <option value="Bab Bered" class="rounded-circle">
                                                Bab Bered
                                            </option>
                                                                                        <option value="Bab Taza" class="rounded-circle">
                                                Bab Taza
                                            </option>
                                                                                        <option value="Bejaad" class="rounded-circle">
                                                Bejaad
                                            </option>
                                                                                        <option value="Bekra" class="rounded-circle">
                                                Bekra
                                            </option>
                                                                                        <option value="Belaaguid" class="rounded-circle">
                                                Belaaguid
                                            </option>
                                                                                        <option value="Belfaa" class="rounded-circle">
                                                Belfaa
                                            </option>
                                                                                        <option value="Ben ahmed" class="rounded-circle">
                                                Ben ahmed
                                            </option>
                                                                                        <option value="Ben Slimane" class="rounded-circle">
                                                Ben Slimane
                                            </option>
                                                                                        <option value="Benguerir" class="rounded-circle">
                                                Benguerir
                                            </option>
                                                                                        <option value="Beni Ayat" class="rounded-circle">
                                                Beni Ayat
                                            </option>
                                                                                        <option value="Beni Chiker" class="rounded-circle">
                                                Beni Chiker
                                            </option>
                                                                                        <option value="Beni Drar" class="rounded-circle">
                                                Beni Drar
                                            </option>
                                                                                        <option value="Beni Mellal" class="rounded-circle">
                                                Beni Mellal
                                            </option>
                                                                                        <option value="Beni Oukil" class="rounded-circle">
                                                Beni Oukil
                                            </option>
                                                                                        <option value="Berchid" class="rounded-circle">
                                                Berchid
                                            </option>
                                                                                        <option value="Berkane" class="rounded-circle">
                                                Berkane
                                            </option>
                                                                                        <option value="Bin El-Ouidane" class="rounded-circle">
                                                Bin El-Ouidane
                                            </option>
                                                                                        <option value="Biougra" class="rounded-circle">
                                                Biougra
                                            </option>
                                                                                        <option value="Bir Jdid" class="rounded-circle">
                                                Bir Jdid
                                            </option>
                                                                                        <option value="Bni Bouayach" class="rounded-circle">
                                                Bni Bouayach
                                            </option>
                                                                                        <option value="Bni Ensar" class="rounded-circle">
                                                Bni Ensar
                                            </option>
                                                                                        <option value="Bouaarek" class="rounded-circle">
                                                Bouaarek
                                            </option>
                                                                                        <option value="Boufekrane" class="rounded-circle">
                                                Boufekrane
                                            </option>
                                                                                        <option value="Bouizakarne" class="rounded-circle">
                                                Bouizakarne
                                            </option>
                                                                                        <option value="Boujdour" class="rounded-circle">
                                                Boujdour
                                            </option>
                                                                                        <option value="Boujniba" class="rounded-circle">
                                                Boujniba
                                            </option>
                                                                                        <option value="Bouknadal" class="rounded-circle">
                                                Bouknadal
                                            </option>
                                                                                        <option value="Boulmane" class="rounded-circle">
                                                Boulmane
                                            </option>
                                                                                        <option value="Boulnouar" class="rounded-circle">
                                                Boulnouar
                                            </option>
                                                                                        <option value="Boumalne Dades" class="rounded-circle">
                                                Boumalne Dades
                                            </option>
                                                                                        <option value="Boumia" class="rounded-circle">
                                                Boumia
                                            </option>
                                                                                        <option value="Bouraj" class="rounded-circle">
                                                Bouraj
                                            </option>
                                                                                        <option value="Bouskoura" class="rounded-circle">
                                                Bouskoura
                                            </option>
                                                                                        <option value="Bouznika" class="rounded-circle">
                                                Bouznika
                                            </option>
                                                                                        <option value="Bradia" class="rounded-circle">
                                                Bradia
                                            </option>
                                                                                        <option value="Bzaza" class="rounded-circle">
                                                Bzaza
                                            </option>
                                                                                        <option value="Cafemor-chouihia" class="rounded-circle">
                                                Cafemor-chouihia
                                            </option>
                                                                                        <option value="Casablanca" class="rounded-circle">
                                                Casablanca
                                            </option>
                                                                                        <option value="Chefchaouen" class="rounded-circle">
                                                Chefchaouen
                                            </option>
                                                                                        <option value="Chichaoua" class="rounded-circle">
                                                Chichaoua
                                            </option>
                                                                                        <option value="Chouiter" class="rounded-circle">
                                                Chouiter
                                            </option>
                                                                                        <option value="Daït Aoua" class="rounded-circle">
                                                Daït Aoua
                                            </option>
                                                                                        <option value="Dakhla" class="rounded-circle">
                                                Dakhla
                                            </option>
                                                                                        <option value="Dar bouaaza" class="rounded-circle">
                                                Dar bouaaza
                                            </option>
                                                                                        <option value="Dar Tounssi" class="rounded-circle">
                                                Dar Tounssi
                                            </option>
                                                                                        <option value="Dardara" class="rounded-circle">
                                                Dardara
                                            </option>
                                                                                        <option value="Demnate" class="rounded-circle">
                                                Demnate
                                            </option>
                                                                                        <option value="Deroua" class="rounded-circle">
                                                Deroua
                                            </option>
                                                                                        <option value="Douar Lahna" class="rounded-circle">
                                                Douar Lahna
                                            </option>
                                                                                        <option value="Douar Sidi Moussa" class="rounded-circle">
                                                Douar Sidi Moussa
                                            </option>
                                                                                        <option value="Driouach" class="rounded-circle">
                                                Driouach
                                            </option>
                                                                                        <option value="Echellalat" class="rounded-circle">
                                                Echellalat
                                            </option>
                                                                                        <option value="Echemmaia" class="rounded-circle">
                                                Echemmaia
                                            </option>
                                                                                        <option value="Ejdar" class="rounded-circle">
                                                Ejdar
                                            </option>
                                                                                        <option value="El Aroui" class="rounded-circle">
                                                El Aroui
                                            </option>
                                                                                        <option value="El gara" class="rounded-circle">
                                                El gara
                                            </option>
                                                                                        <option value="El Haj Kaddour" class="rounded-circle">
                                                El Haj Kaddour
                                            </option>
                                                                                        <option value="El Hajeb" class="rounded-circle">
                                                El Hajeb
                                            </option>
                                                                                        <option value="El jadida" class="rounded-circle">
                                                El jadida
                                            </option>
                                                                                        <option value="El Kelaa des Sraghna" class="rounded-circle">
                                                El Kelaa des Sraghna
                                            </option>
                                                                                        <option value="El Kelaâ des Sraghna" class="rounded-circle">
                                                El Kelaâ des Sraghna
                                            </option>
                                                                                        <option value="El Mhaya" class="rounded-circle">
                                                El Mhaya
                                            </option>
                                                                                        <option value="Elbradiya" class="rounded-circle">
                                                Elbradiya
                                            </option>
                                                                                        <option value="Elfkih Ben Saleh" class="rounded-circle">
                                                Elfkih Ben Saleh
                                            </option>
                                                                                        <option value="Errachidia" class="rounded-circle">
                                                Errachidia
                                            </option>
                                                                                        <option value="Es-semara" class="rounded-circle">
                                                Es-semara
                                            </option>
                                                                                        <option value="Essaouira" class="rounded-circle">
                                                Essaouira
                                            </option>
                                                                                        <option value="f" class="rounded-circle">
                                                f
                                            </option>
                                                                                        <option value="Farkhana" class="rounded-circle">
                                                Farkhana
                                            </option>
                                                                                        <option value="FES" class="rounded-circle">
                                                FES
                                            </option>
                                                                                        <option value="Fini" class="rounded-circle">
                                                Fini
                                            </option>
                                                                                        <option value="Fnideq" class="rounded-circle">
                                                Fnideq
                                            </option>
                                                                                        <option value="Foum El-Ansar" class="rounded-circle">
                                                Foum El-Ansar
                                            </option>
                                                                                        <option value="Foum Oudi" class="rounded-circle">
                                                Foum Oudi
                                            </option>
                                                                                        <option value="Goulmima" class="rounded-circle">
                                                Goulmima
                                            </option>
                                                                                        <option value="Guelmim" class="rounded-circle">
                                                Guelmim
                                            </option>
                                                                                        <option value="Guercif" class="rounded-circle">
                                                Guercif
                                            </option>
                                                                                        <option value="Had Draa" class="rounded-circle">
                                                Had Draa
                                            </option>
                                                                                        <option value="Had Hrara" class="rounded-circle">
                                                Had Hrara
                                            </option>
                                                                                        <option value="Had Soualem" class="rounded-circle">
                                                Had Soualem
                                            </option>
                                                                                        <option value="Haouara" class="rounded-circle">
                                                Haouara
                                            </option>
                                                                                        <option value="Harhoura" class="rounded-circle">
                                                Harhoura
                                            </option>
                                                                                        <option value="Ideslane" class="rounded-circle">
                                                Ideslane
                                            </option>
                                                                                        <option value="Ifrane" class="rounded-circle">
                                                Ifrane
                                            </option>
                                                                                        <option value="Ighrame Nougdal" class="rounded-circle">
                                                Ighrame Nougdal
                                            </option>
                                                                                        <option value="Ighrem Laalam" class="rounded-circle">
                                                Ighrem Laalam
                                            </option>
                                                                                        <option value="Ihddaden" class="rounded-circle">
                                                Ihddaden
                                            </option>
                                                                                        <option value="Imi n'Tanoute" class="rounded-circle">
                                                Imi n'Tanoute
                                            </option>
                                                                                        <option value="Imouzar" class="rounded-circle">
                                                Imouzar
                                            </option>
                                                                                        <option value="Imzouren" class="rounded-circle">
                                                Imzouren
                                            </option>
                                                                                        <option value="Inzegane" class="rounded-circle">
                                                Inzegane
                                            </option>
                                                                                        <option value="Jemaa-shaim" class="rounded-circle">
                                                Jemaa-shaim
                                            </option>
                                                                                        <option value="Jerada" class="rounded-circle">
                                                Jerada
                                            </option>
                                                                                        <option value="Jerada" class="rounded-circle">
                                                Jerada
                                            </option>
                                                                                        <option value="kalaat M'gouna" class="rounded-circle">
                                                kalaat M'gouna
                                            </option>
                                                                                        <option value="Kasba Tadla" class="rounded-circle">
                                                Kasba Tadla
                                            </option>
                                                                                        <option value="Kenitra" class="rounded-circle">
                                                Kenitra
                                            </option>
                                                                                        <option value="Khemisset" class="rounded-circle">
                                                Khemisset
                                            </option>
                                                                                        <option value="Khenifra" class="rounded-circle">
                                                Khenifra
                                            </option>
                                                                                        <option value="Khmis Ait Amira" class="rounded-circle">
                                                Khmis Ait Amira
                                            </option>
                                                                                        <option value="Khmis Zmamra" class="rounded-circle">
                                                Khmis Zmamra
                                            </option>
                                                                                        <option value="Khouribgua" class="rounded-circle">
                                                Khouribgua
                                            </option>
                                                                                        <option value="Ksar Lkbir" class="rounded-circle">
                                                Ksar Lkbir
                                            </option>
                                                                                        <option value="Ksar Maadid" class="rounded-circle">
                                                Ksar Maadid
                                            </option>
                                                                                        <option value="Ksar sghir" class="rounded-circle">
                                                Ksar sghir
                                            </option>
                                                                                        <option value="Laayayta" class="rounded-circle">
                                                Laayayta
                                            </option>
                                                                                        <option value="Laayoune" class="rounded-circle">
                                                Laayoune
                                            </option>
                                                                                        <option value="Lahri" class="rounded-circle">
                                                Lahri
                                            </option>
                                                                                        <option value="Lakbab" class="rounded-circle">
                                                Lakbab
                                            </option>
                                                                                        <option value="Lakraza" class="rounded-circle">
                                                Lakraza
                                            </option>
                                                                                        <option value="Lakssiba" class="rounded-circle">
                                                Lakssiba
                                            </option>
                                                                                        <option value="Larache" class="rounded-circle">
                                                Larache
                                            </option>
                                                                                        <option value="Loudaya (marrakech)" class="rounded-circle">
                                                Loudaya (marrakech)
                                            </option>
                                                                                        <option value="M'diq" class="rounded-circle">
                                                M'diq
                                            </option>
                                                                                        <option value="Marrakech" class="rounded-circle">
                                                Marrakech
                                            </option>
                                                                                        <option value="Martil" class="rounded-circle">
                                                Martil
                                            </option>
                                                                                        <option value="Massa" class="rounded-circle">
                                                Massa
                                            </option>
                                                                                        <option value="Massmouda" class="rounded-circle">
                                                Massmouda
                                            </option>
                                                                                        <option value="Mechra Bel Ksiri" class="rounded-circle">
                                                Mechra Bel Ksiri
                                            </option>
                                                                                        <option value="Mediouna" class="rounded-circle">
                                                Mediouna
                                            </option>
                                                                                        <option value="Meknes" class="rounded-circle">
                                                Meknes
                                            </option>
                                                                                        <option value="Mers El Kheir" class="rounded-circle">
                                                Mers El Kheir
                                            </option>
                                                                                        <option value="Merzouga" class="rounded-circle">
                                                Merzouga
                                            </option>
                                                                                        <option value="Midelt" class="rounded-circle">
                                                Midelt
                                            </option>
                                                                                        <option value="Mohammedia" class="rounded-circle">
                                                Mohammedia
                                            </option>
                                                                                        <option value="Mokrissat" class="rounded-circle">
                                                Mokrissat
                                            </option>
                                                                                        <option value="Moulay Abdellah" class="rounded-circle">
                                                Moulay Abdellah
                                            </option>
                                                                                        <option value="Moulay Bousselham" class="rounded-circle">
                                                Moulay Bousselham
                                            </option>
                                                                                        <option value="Moulay Idriss Zerhoun" class="rounded-circle">
                                                Moulay Idriss Zerhoun
                                            </option>
                                                                                        <option value="Mrirt" class="rounded-circle">
                                                Mrirt
                                            </option>
                                                                                        <option value="Msewar Rassou" class="rounded-circle">
                                                Msewar Rassou
                                            </option>
                                                                                        <option value="Nador" class="rounded-circle">
                                                Nador
                                            </option>
                                                                                        <option value="Nouacer" class="rounded-circle">
                                                Nouacer
                                            </option>
                                                                                        <option value="Ouad Amlil" class="rounded-circle">
                                                Ouad Amlil
                                            </option>
                                                                                        <option value="Ouad Zem" class="rounded-circle">
                                                Ouad Zem
                                            </option>
                                                                                        <option value="Ouaouizaght" class="rounded-circle">
                                                Ouaouizaght
                                            </option>
                                                                                        <option value="Ouarzazat" class="rounded-circle">
                                                Ouarzazat
                                            </option>
                                                                                        <option value="Ouazzane" class="rounded-circle">
                                                Ouazzane
                                            </option>
                                                                                        <option value="Oudaya" class="rounded-circle">
                                                Oudaya
                                            </option>
                                                                                        <option value="Oujda" class="rounded-circle">
                                                Oujda
                                            </option>
                                                                                        <option value="Oulad Ajbir" class="rounded-circle">
                                                Oulad Ajbir
                                            </option>
                                                                                        <option value="Oulad Ali Loued" class="rounded-circle">
                                                Oulad Ali Loued
                                            </option>
                                                                                        <option value="Oulad Ayach" class="rounded-circle">
                                                Oulad Ayach
                                            </option>
                                                                                        <option value="Oulad Ayad" class="rounded-circle">
                                                Oulad Ayad
                                            </option>
                                                                                        <option value="Oulad Frej" class="rounded-circle">
                                                Oulad Frej
                                            </option>
                                                                                        <option value="Oulad M'barek" class="rounded-circle">
                                                Oulad M'barek
                                            </option>
                                                                                        <option value="Oulad Moussa (region beni mellal)" class="rounded-circle">
                                                Oulad Moussa (region beni mellal)
                                            </option>
                                                                                        <option value="Oulad Said (region beni mellal)" class="rounded-circle">
                                                Oulad Said (region beni mellal)
                                            </option>
                                                                                        <option value="Oulad Tayeb" class="rounded-circle">
                                                Oulad Tayeb
                                            </option>
                                                                                        <option value="Oulad Tayma" class="rounded-circle">
                                                Oulad Tayma
                                            </option>
                                                                                        <option value="Oulad Yaich" class="rounded-circle">
                                                Oulad Yaich
                                            </option>
                                                                                        <option value="Oulad Youssef" class="rounded-circle">
                                                Oulad Youssef
                                            </option>
                                                                                        <option value="Oulad Zidouh" class="rounded-circle">
                                                Oulad Zidouh
                                            </option>
                                                                                        <option value="Oulad Zmam" class="rounded-circle">
                                                Oulad Zmam
                                            </option>
                                                                                        <option value="Ouled Abdallah" class="rounded-circle">
                                                Ouled Abdallah
                                            </option>
                                                                                        <option value="Ouled Driss (region beni mellal)" class="rounded-circle">
                                                Ouled Driss (region beni mellal)
                                            </option>
                                                                                        <option value="Ourika" class="rounded-circle">
                                                Ourika
                                            </option>
                                                                                        <option value="Rabat" class="rounded-circle">
                                                Rabat
                                            </option>
                                                                                        <option value="Rich" class="rounded-circle">
                                                Rich
                                            </option>
                                                                                        <option value="Rissani" class="rounded-circle">
                                                Rissani
                                            </option>
                                                                                        <option value="Rissani" class="rounded-circle">
                                                Rissani
                                            </option>
                                                                                        <option value="S" class="rounded-circle">
                                                S
                                            </option>
                                                                                        <option value="Safi" class="rounded-circle">
                                                Safi
                                            </option>
                                                                                        <option value="Saidia" class="rounded-circle">
                                                Saidia
                                            </option>
                                                                                        <option value="Sala El-Jadida" class="rounded-circle">
                                                Sala El-Jadida
                                            </option>
                                                                                        <option value="Sale" class="rounded-circle">
                                                Sale
                                            </option>
                                                                                        <option value="Salé ( les régions )" class="rounded-circle">
                                                Salé ( les régions )
                                            </option>
                                                                                        <option value="Sbaa Aiyoun" class="rounded-circle">
                                                Sbaa Aiyoun
                                            </option>
                                                                                        <option value="Sefrou" class="rounded-circle">
                                                Sefrou
                                            </option>
                                                                                        <option value="Selouane" class="rounded-circle">
                                                Selouane
                                            </option>
                                                                                        <option value="Settat" class="rounded-circle">
                                                Settat
                                            </option>
                                                                                        <option value="Sidi Aabed" class="rounded-circle">
                                                Sidi Aabed
                                            </option>
                                                                                        <option value="Sidi Addi" class="rounded-circle">
                                                Sidi Addi
                                            </option>
                                                                                        <option value="Sidi Allal Tazi" class="rounded-circle">
                                                Sidi Allal Tazi
                                            </option>
                                                                                        <option value="Sidi Bennour" class="rounded-circle">
                                                Sidi Bennour
                                            </option>
                                                                                        <option value="Sidi Bibi" class="rounded-circle">
                                                Sidi Bibi
                                            </option>
                                                                                        <option value="Sidi bouzid" class="rounded-circle">
                                                Sidi bouzid
                                            </option>
                                                                                        <option value="Sidi hajjaj" class="rounded-circle">
                                                Sidi hajjaj
                                            </option>
                                                                                        <option value="Sidi Harazem" class="rounded-circle">
                                                Sidi Harazem
                                            </option>
                                                                                        <option value="Sidi Ifni" class="rounded-circle">
                                                Sidi Ifni
                                            </option>
                                                                                        <option value="Sidi Ismail" class="rounded-circle">
                                                Sidi Ismail
                                            </option>
                                                                                        <option value="Sidi Issa" class="rounded-circle">
                                                Sidi Issa
                                            </option>
                                                                                        <option value="Sidi Jaber" class="rounded-circle">
                                                Sidi Jaber
                                            </option>
                                                                                        <option value="Sidi Kacem" class="rounded-circle">
                                                Sidi Kacem
                                            </option>
                                                                                        <option value="Sidi Rahal" class="rounded-circle">
                                                Sidi Rahal
                                            </option>
                                                                                        <option value="Sidi Redouane" class="rounded-circle">
                                                Sidi Redouane
                                            </option>
                                                                                        <option value="Sidi Slimane" class="rounded-circle">
                                                Sidi Slimane
                                            </option>
                                                                                        <option value="Sidi Taibi" class="rounded-circle">
                                                Sidi Taibi
                                            </option>
                                                                                        <option value="Sidi Yahya Des Zaer" class="rounded-circle">
                                                Sidi Yahya Des Zaer
                                            </option>
                                                                                        <option value="Sidi Yahya El Gharb" class="rounded-circle">
                                                Sidi Yahya El Gharb
                                            </option>
                                                                                        <option value="Sidi Zouine" class="rounded-circle">
                                                Sidi Zouine
                                            </option>
                                                                                        <option value="Skhirat" class="rounded-circle">
                                                Skhirat
                                            </option>
                                                                                        <option value="Skoura" class="rounded-circle">
                                                Skoura
                                            </option>
                                                                                        <option value="Souk Elarbaa Du Gharb" class="rounded-circle">
                                                Souk Elarbaa Du Gharb
                                            </option>
                                                                                        <option value="Souk Elhad (ouazzane)" class="rounded-circle">
                                                Souk Elhad (ouazzane)
                                            </option>
                                                                                        <option value="Souk Essabt Oulad Nema" class="rounded-circle">
                                                Souk Essabt Oulad Nema
                                            </option>
                                                                                        <option value="ss" class="rounded-circle">
                                                ss
                                            </option>
                                                                                        <option value="Tadla" class="rounded-circle">
                                                Tadla
                                            </option>
                                                                                        <option value="Tagzirt" class="rounded-circle">
                                                Tagzirt
                                            </option>
                                                                                        <option value="Tahannaout" class="rounded-circle">
                                                Tahannaout
                                            </option>
                                                                                        <option value="Tahla" class="rounded-circle">
                                                Tahla
                                            </option>
                                                                                        <option value="Tamaris" class="rounded-circle">
                                                Tamaris
                                            </option>
                                                                                        <option value="Tamesloht" class="rounded-circle">
                                                Tamesloht
                                            </option>
                                                                                        <option value="Tamesna" class="rounded-circle">
                                                Tamesna
                                            </option>
                                                                                        <option value="Tamnsourt" class="rounded-circle">
                                                Tamnsourt
                                            </option>
                                                                                        <option value="Tan Tan" class="rounded-circle">
                                                Tan Tan
                                            </option>
                                                                                        <option value="Tan Tan Plage" class="rounded-circle">
                                                Tan Tan Plage
                                            </option>
                                                                                        <option value="Tanger" class="rounded-circle">
                                                Tanger
                                            </option>
                                                                                        <option value="Tanougha" class="rounded-circle">
                                                Tanougha
                                            </option>
                                                                                        <option value="Taounate" class="rounded-circle">
                                                Taounate
                                            </option>
                                                                                        <option value="Taourirt" class="rounded-circle">
                                                Taourirt
                                            </option>
                                                                                        <option value="Tarfaya" class="rounded-circle">
                                                Tarfaya
                                            </option>
                                                                                        <option value="Taroudant" class="rounded-circle">
                                                Taroudant
                                            </option>
                                                                                        <option value="Taza" class="rounded-circle">
                                                Taza
                                            </option>
                                                                                        <option value="Tazenakht" class="rounded-circle">
                                                Tazenakht
                                            </option>
                                                                                        <option value="Temara" class="rounded-circle">
                                                Temara
                                            </option>
                                                                                        <option value="Tetouan" class="rounded-circle">
                                                Tetouan
                                            </option>
                                                                                        <option value="Thannaout" class="rounded-circle">
                                                Thannaout
                                            </option>
                                                                                        <option value="Tiflet" class="rounded-circle">
                                                Tiflet
                                            </option>
                                                                                        <option value="Tighssaline" class="rounded-circle">
                                                Tighssaline
                                            </option>
                                                                                        <option value="Timdline" class="rounded-circle">
                                                Timdline
                                            </option>
                                                                                        <option value="Tinejdad" class="rounded-circle">
                                                Tinejdad
                                            </option>
                                                                                        <option value="Tinghir" class="rounded-circle">
                                                Tinghir
                                            </option>
                                                                                        <option value="Tinghir ( les regions )" class="rounded-circle">
                                                Tinghir ( les regions )
                                            </option>
                                                                                        <option value="Tinzouline" class="rounded-circle">
                                                Tinzouline
                                            </option>
                                                                                        <option value="Tiouine (dimanche)" class="rounded-circle">
                                                Tiouine (dimanche)
                                            </option>
                                                                                        <option value="Tit Melil" class="rounded-circle">
                                                Tit Melil
                                            </option>
                                                                                        <option value="Tiznit" class="rounded-circle">
                                                Tiznit
                                            </option>
                                                                                        <option value="Tiztoutine (Nador)" class="rounded-circle">
                                                Tiztoutine (Nador)
                                            </option>
                                                                                        <option value="Tnin Chtouka" class="rounded-circle">
                                                Tnin Chtouka
                                            </option>
                                                                                        <option value="Touima" class="rounded-circle">
                                                Touima
                                            </option>
                                                                                        <option value="Youssoufia" class="rounded-circle">
                                                Youssoufia
                                            </option>
                                                                                        <option value="Zagora" class="rounded-circle">
                                                Zagora
                                            </option>
                                                                                        <option value="Zaida" class="rounded-circle">
                                                Zaida
                                            </option>
                                                                                        <option value="Zaïo" class="rounded-circle">
                                                Zaïo
                                            </option>
                                                                                        <option value="Zaouiat Chikh" class="rounded-circle">
                                                Zaouiat Chikh
                                            </option>
                                                                                        <option value="Zghanghan" class="rounded-circle">
                                                Zghanghan
                                            </option>
                                                                                        <option value="Zoumi" class="rounded-circle">
                                                Zoumi
                                            </option>
                                                                                        <option value="Zrarda" class="rounded-circle">
                                                Zrarda
                                            </option>
                                </select>
                                @error('ville')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="telephone" class="col-md-2 col-form-label text-md-right">{{ __('Téléphone') }}</label>

                            <div class="col-md-4">
                                <input id="telephone" type="text" class="form-control" name="telephone" value="{{ old('telephone') }}"    >
                            </div>
                            <label for="image" class="col-md-2 col-form-label text-md-right">{{ __('Url de l\'image') }}</label>

                            <div class="col-md-4">
                                <input id="image" type="text" class="form-control" name="image" value="{{ old('image') }}"  >

                
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="rib" class="col-md-2 col-form-label text-md-right">{{ __('RIB') }}</label>

                            <div class="col-md-10">
                                <input id="rib" type="text" class="form-control" name="rib" value="{{ old('rib') }}"    >
                            </div>
                           
                        </div>

                        <div class="form-group row">
                            <label for="adresse" class="col-md-2 col-form-label text-md-right">{{ __('Adresse') }}</label>

                            <div class="col-md-10">
                                <textarea name="adresse" id="adresse" cols="100" rows="5"></textarea >
                            </div>
                            
                            
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-2 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-4">
                                <input id="password" value="Colisade2020" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <label for="password-confirm" class="col-md-2 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-4">
                                <input id="password-confirm"  value="Colisade2020"  type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="roles" class="col-md-12 col-form-label text-center font-bold font-16">Rôles Colisade : </label>
                            <label for="roles" class="col-md-2 col-form-label text-md-right">Rôle : </label>
                            <div class="col-md-10 d-flex p-t-10 justify-content-around">
                                <div class="form-check">
                                    <input type="radio" name="roles[]" value="1" id="admin" >
                                    <label for="admin">Admin</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="roles[]" value="3" id="Livreur" >
                                    <label for="Livreur">Livreur</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="roles[]" value="4" id="Personnel" >
                                    <label for="Personnel">Personnel</label>
                                </div>
                            </div>
                            <label for="roles" class="col-md-12 col-form-label text-center font-bold font-16">Utilisateur Client : </label>
                            <label for="roles" class="col-md-2 col-form-label text-md-right">Service : </label>
                            <div class="col-md-10 d-flex p-t-10 justify-content-around">
                            <div class="form-check">
                                <input type="radio" name="roles[]" value="2" id="cl" checked>
                                <label for="cl">Collecte, Livraison</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="roles[]" value="5" id="cls">
                                <label for="cls">Collecte, Stockage, Livraison</label>
                            </div>
                          
                        
                            </div>
                            

                                <label for="type" class="col-md-2 col-form-label text-md-right">Statut : </label>
                                <div class="col-md-10 d-flex p-t-10 justify-content-around">
                                <div class="form-check">
                                    <input type="radio" name="statut" value="0" id="Premium" checked>
                                    <label for="Premium">Premium</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="statut" value="1" id="VIP">
                                    <label for="VIP">VIP</label>
                                </div>
                            
                                </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-12 d-flex justify-content-around ">
                                <button type="submit" class="btn btn-primary" style="width: 30%;">
                                    {{ __('Ajouter') }}
                                </button>
                            </div>
                        </div>


                    </form>

                </div>
            
            </div>
        
        </div>

    </div>

</div>
@endsection

@section('javascript')

	<script>

</script>
@endsection
