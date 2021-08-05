
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Se Connecter - Colisade</title>
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
    <style>
        .switch {
          position: relative;
          display: inline-block;
          width: 42px;
          height: 26px;
        }

        .switch input {
          opacity: 0;
          width: 0;
          height: 0;
        }

        .slider {
          position: absolute;
          cursor: pointer;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: #ccc;
          -webkit-transition: .4s;
          transition: .4s;
        }

        .slider:before {
          position: absolute;
          content: "";
          height: 22px;
          width: 22px;
          left: -4px;
          bottom: 1px;
          background-color: white;
          -webkit-transition: .4s;
          transition: .4s;
        }

        input:checked + .slider {
          background-color: #2196F3;
        }

        input:focus + .slider {
          box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
          -webkit-transform: translateX(22px);
          -ms-transform: translateX(22px);
          transform: translateX(22px);
        }

        /* Rounded sliders */
        .slider.round {
          border-radius: 34px;
        }

        .slider.round:before {
          border-radius: 50%;
        }
        </style>
<!--===============================================================================================-->
</head>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
                <form class="login100-form validate-form" style="position:relative;top:-100px;" method="POST" action="{{ route('login') }}">
                    @csrf
					<span class="login100-form-title p-b-34">
				        Se Connecter à votre espace
					</span>

					<div class="wrap-input100 rs1-wrap-input100 validate-input m-b-20" data-validate="Vérifiez votre Adresse Email">
						<input style="height: 100%" class="input100 @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Votre Email">
                        <span class="focus-input100"></span>

					</div>
					<div class="wrap-input100 rs2-wrap-input100 validate-input m-b-20" data-validate="Vérifiez votre mot de passe">
						<input  id="showPasswordId" style="height: 100%" class="input100  @error('password') is-invalid @enderror" type="password" name="password" placeholder="Password" required autocomplete="current-password">
                        <span class="focus-input100"></span>


					</div>
                    <div>
                        <label class="switch">
                            <input type="checkbox" onclick="showPassword()">
                            <span class="slider round"></span>
                        </label>
                         <span>Voir le Mot de Passe </span>
                    </div>

                    @error('email')
                    <span class="invalid-feedback" role="alert" style="color:red">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    @error('password')
                    <span class="invalid-feedback" role="alert" style="color:red">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

					<div class="container-login100-form-btn">
						<button type="submit"  class="login100-form-btn">
							Se Connecter
						</button>
					</div>
                    @if (Route::has('password.request'))
					<div class="w-full text-center p-t-27 ">
                        <a href="#" class="txt2">
							Utilisateur
						</a>
                        <span class="txt1">
							ou
						</span>
                        <a href="{{ route('password.request')}}" class="txt2">
							Mot de passe
						</a>
                        <span class="txt1">
							Oublié?
						</span>
					</div>

					<div class="w-full text-center">
						<a href="{{ route('user.nouveau') }}" class="txt2">
							Créer un nouveau Compte?
						</a>
                    </div>
                    @endif
				</form>

				<div class="login100-more" style="background-image: url('/assets/images/bg-02.jpg'); "></div>
			</div>
		</div>
	</div>



	<div id="dropDownSelect1"></div>

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
        function showPassword() {
        var x = document.getElementById("showPasswordId");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
        }
    </script>

</body>
</html>
