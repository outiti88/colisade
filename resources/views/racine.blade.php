<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Colisade Delivery Tanger propose 
    un service de collecte, de stockage, d’emballage et d’expédition de vos produits aux clients.">
    <meta name="author" content="Outiti Ayoub">
    <meta name="keywords" content="Colisade,Delivery,Tanger,Livraison,Expédition,Collecte">
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('/assets/images/favicon.png')}}">
    <title>@yield('title')</title>

    <link href="{{ url('/sass/style.min.css') }}" rel="stylesheet">
    <link href="{{ url('/css/app.css') }}" rel="stylesheet">

    <link href="{{ url('/assets/libs/chartist/dist/chartist.min.css') }}" rel="stylesheet">

    @yield('style')


</head>

<body>

    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">

        @include('partiels._navbar')

        @include('partiels._sidebar')

        <div class="page-wrapper">

            @yield('content')
            <footer class="footer text-center">
                Copyright © 2020 Colisade Delivery. Tous les droits sont réservés.
            </footer>
        </div>

    </div>

    <script>
        var xx = document.getElementById("secteur");
        function myFunction() {
        var test = document.getElementById("ville").value;
        if(test=='Tanger'){
            xx.style.display = "block";
        }
        else{
            xx.style.display = "none";
        }
        }
    </script>

    <script>
        var yy = document.getElementById("montant");
        function myFunction2(mode) {
            if(mode == 'cd'){
                yy.style.display = "block";
                console.log("cd");
            }
            else{
                yy.style.display = "none";
                console.log("cp");
            }
        }
    </script>
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
            "Douar Lahna" : "" ,
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
                "Khouribga" : "40,00 DH"
            };
                
      
        
        
      var xside = document.getElementById("ville3");
    
      for (const [key, value] of Object.entries(arr)) {
      var optionSide = document.createElement("option");
         xside.appendChild(optionSide);
            var textside = document.createTextNode(key);
            optionSide.appendChild(textside);
              
          
        }
    
    </script>
 

    <script src="{{ url('/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ url('/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ url('/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('/js/app-style-switcher.js') }}" ></script>
    <!--Wave Effects -->
    <script src="{{ url('/js/waves.js"') }}" ></script>
    <!--Menu sidebar -->
    <script src="{{ url('/js/sidebarmenu.js') }}" ></script>
    <!--Custom JavaScript -->
    <script src="{{ url('/js/custom.js') }}" ></script>

    @yield('javascript')
</body>

</html>