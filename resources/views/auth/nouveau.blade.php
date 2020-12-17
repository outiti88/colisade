
<!DOCTYPE html>
<html lang="en">
<head>
	<title>S'inscrire - Colisade</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
<link rel="icon" type="image/png" sizes="16x16" href="{{url('/assets/images/favicon.png')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{url('/assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{url('/assets/fonts/Linearicons-Free-v1.0.0/icon-font.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css"  href="{{url('/css/inscription/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('/css/inscription/css/main.css')}}">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
                <form class="login100-form validate-form" style="position:relative;top:-250px;" method="POST" action="{{ route('register') }}">
                    @csrf
					<span class="login100-form-title p-b-34">
				        Créez votre espace
					</span>
					
					<div class="wrap-input100 rs1-wrap-input100 validate-input m-b-20" data-validate="">
						<input id="name" class="input100  @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus type="text" placeholder="Nom Complet">
                        <span class="focus-input100"></span>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
					</div>
					<div class="wrap-input100 rs2-wrap-input100 validate-input m-b-20" data-validate="Vérifiez votre email">
						<input class="input100 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" type="email" placeholder="Email">
                        <span class="focus-input100"></span>
                        @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
					</div>
                    <div class="wrap-input100 rs1-wrap-input100 validate-input m-b-20" data-validate="">
						<input id="description" class="input100" type="text" placeholder="ICE"  name="description" value="{{ old('description') }}">
						<span class="focus-input100"></span>
					</div>
                    <div class="wrap-input100 rs1-wrap-input100 validate-input m-b-20" data-validate="">
						<input id="first-name" class="input100" value="{{ old('rib') }}" type="text" name="rib" placeholder="RIB">
						<span class="focus-input100"></span>
					</div>
					<div class="wrap-input100 rs2-wrap-input100 validate-input m-b-20" data-validate="">
							 <select style="
						border: 6px solid transparent;
					"   name="ville" class="input100" value="{{ old('ville') }}" id="ville" onchange="myFunctionEdit1()" required>

                                        </select>
                        <span class="focus-input100"></span>
                        @error('ville')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
					</div>
                    <div class="wrap-input100 rs1-wrap-input100 validate-input m-b-20" data-validate="">
						<input id="first-name" class="input100" type="tel"  name="telephone" value="{{ old('telephone') }}" placeholder="Téléphone">
						<span class="focus-input100"></span>
					</div>
					<div class="wrap-input100 rs2-wrap-input100 validate-input m-b-20" data-validate="" style="width: 100%;">
						<input class="input100" type="text" name="adresse" value="{{ old('adresse') }}" placeholder="Adresse">
						<span class="focus-input100"></span>
					</div>
                    <div class="wrap-input100 rs1-wrap-input100 validate-input m-b-20" data-validate="">
						<input id="first-name" class="input100 @error('password') is-invalid @enderror" type="password"  name="password" required autocomplete="new-password" placeholder="Mot de passe">
                        <span class="focus-input100"></span>
                        @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
					</div>
					<div class="wrap-input100 rs2-wrap-input100 validate-input m-b-20" data-validate="">
						<input id="password-confirm" class="input100" type="password"  name="password_confirmation" required autocomplete="new-password" placeholder="Confirmez votre Mot de passe">
						<span class="focus-input100"></span>
					</div>
					
					<div class="container-login100-form-btn">
						<button type="submit"  class="login100-form-btn inscrire">
							S'inscrire
						</button>
					</div>


					<div class="w-full text-center p-t-27 ">
						<a href="/login" class="txt4" >
							Se connecter
						</a>
					</div>
				</form>

				<div class="login100-more" style="background-image: url('/assets/images/bg-01.jpg'); background-size: 102%;
    background-position: top;"></div>
			</div>
		</div>
	</div>
	
	

	<div id="dropDownSelect1"></div>
    
      <script src="{{ url('/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ url('/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ url('/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('/js/app-style-switcher.js') }}" ></script>
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
	<script>
		$(".selection-2").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect1')
		});
	</script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>
	
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
            
  
    
    
  var x3 = document.getElementById("ville");
  

  for (const [key, value] of Object.entries(arr)) {
  var option = document.createElement("option");
         x3.appendChild(option);
        var text1 = document.createTextNode(key);
        option.appendChild(text1);
          
      
	}
</script>

</body>
</html>