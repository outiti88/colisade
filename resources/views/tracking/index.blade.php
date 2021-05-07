<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Colisade | Tracking</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('/assets/images/favicon.png')}}">

    <link rel="stylesheet" href="{{ url('/assets/vendor/fortawesome/fontawesome-free/css/all.min.css')}}"  type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <style>
        body {
            color: #000;
            overflow-x: hidden;
            height: 100%;
            background-color: #007db2;
            background-repeat: no-repeat
        }

        .card {
            z-index: 0;
            background-color: #ECEFF1;
            padding-bottom: 20px;
            margin-top: 90px;
            margin-bottom: 90px;
            border-radius: 10px
        }

        .top {
            padding-top: 40px;
            padding-left: 13% !important;
            padding-right: 13% !important
        }

        #progressbar {
            margin-bottom: 30px;
            overflow: hidden;
            color: #455A64;
            padding-left: 0px;
            margin-top: 30px
        }

        #progressbar li {
            list-style-type: none;
            font-size: 13px;
            width: 25%;
            float: left;
            position: relative;
            font-weight: 400
        }

        .icon-content i {
            font-size: 2em;
            padding-right: 10px;
            color: #007db2;
        }

        #progressbar li i {
            width: 40px;
            height: 40px;
            line-height: 45px;
            display: block;
            font-size: 20px;
            background: #dd885e;
            color:white;
            border-radius: 50%;
            margin: auto;
            padding: 0px
        }

            p{
                font-size: 0.8em;
            color: #007db2;
            }


        #progressbar li.active:after {
            content: '';
            width: 100%;
            height: 12px;
            background: #f16821;
            position: absolute;
            left: 0;
            top: 16px;
            z-index: -1
        }

        .step0:after {
            content: '';
            width: 100%;
            height: 12px;
            background: #dd885e;
            position: absolute;
            left: 0;
            top: 16px;
            z-index: -1
        }

        #progressbar li:last-child:after {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            position: absolute;
            left: -50%
        }

        #progressbar li:nth-child(2):after,
        #progressbar li:nth-child(3):after {
            left: -50%
        }

        #progressbar li:first-child:after {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
            position: absolute;
            left: 50%
        }

        #progressbar li:last-child:after {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px
        }

        #progressbar li:first-child:after {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px
        }

        #progressbar li.active i,
        #progressbar li.active i {
            background: #f16821;
            border-color: white;
            border-style: solid;
            color : white;
        }



        .icon {
            width: 40px;
            height: 40px;
            margin-right: 15px
        }

        .icon-content {
            padding-bottom: 20px
        }


    </style>
</head>
<body>


    <div class="container px-1 px-md-4 py-5 mx-auto">

        <div class="card">
            <div class="row d-flex justify-content-between px-3 top">

                <div class="d-flex">
                    <h6>COMMANDE <span class="text-primary font-weight-bold">{{$commande->numero}}</span></h6>
                </div>
                <img src="{{asset('assets/images/logo-light-text.png')}}" style="
                WIDTH: 20%;
            "class="light-logo" alt="homepage" />
                <div class="d-flex flex-column text-sm-right">
                    <p class="mb-0">Date <span>{{$commande->created_at}}</span></p>
                    <p>Client:  <span class="font-weight-bold">{{$commande->nom}}</span></p>
                </div>
            </div> <!-- Add class 'active' to progress -->
            <div class="row d-flex justify-content-center">
                <div class="col-12">
                    <ul id="progressbar" class="text-center">
                        @if ($state==1)
                            <li class="active " ><i class="fas fa-check"></i></li>
                            <li class="step0 "><i class="fas fa-check"></i></li>
                            <li class="step0"><i class="fas fa-check"></i></li>
                            <li class="step0"><i class="fas fa-check"></i></li>
                        @elseif ($state==2)
                            <li class="active " ><i class="fas fa-check"></i></li>
                            <li class="active "><i class="fas fa-check"></i></li>
                            <li class="step0"><i class="fas fa-check"></i></li>
                            <li class="step0"><i class="fas fa-check"></i></li>
                        @elseif ($state==3)
                        <li class="active " ><i class="fas fa-check"></i></li>
                        <li class="active "><i class="fas fa-check"></i></li>
                        <li class="active"><i class="fas fa-check"></i></li>
                        <li class="step0"><i class="fas fa-check"></i></li>
                        @else
                        <li class="active " ><i class="fas fa-check"></i></li>
                        <li class="active "><i class="fas fa-check"></i></li>
                        <li class="active"><i class="fas fa-check"></i></li>
                        <li class="active"><i class="fas fa-check"></i></li>
                        @endif

                    </ul>
                </div>
            </div>
            <div class="row justify-content-between top">
                <div class="row d-flex icon-content"> <i class="fas fa-box"></i>
                    <div class="d-flex flex-column">
                        <p class="font-weight-bold">Commande<br>Acceptée</p>
                    </div>
                </div>
                <div class="row d-flex icon-content"> <i class="fas fa-truck"></i>
                    <div class="d-flex flex-column">
                        <p class="font-weight-bold">Commande<br>Expédiée -RABAT-</p>
                    </div>
                </div>
                <div class="row d-flex icon-content"> <i class="fas fa-map-marked-alt"></i>
                    <div class="d-flex flex-column">
                        <p class="font-weight-bold">Commande<br>En cours -{{$commande->ville}}-</p>
                    </div>
                </div>
                <div class="row d-flex icon-content">
                    @if ($state<5)
                        <i class="fas fa-clipboard-check"></i>
                        <div class="d-flex flex-column">
                            <p class="font-weight-bold">Commande<br>Livrée</p>
                        </div>
                    @else
                    <i class="fas fa-exclamation-triangle" style="color: red"></i>
                    <div class="d-flex flex-column">
                        <p style="color: red" class="font-weight-bold">Commande<br>{{$commande->statut}}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <button onclick="goBack()" href="/tracking" type="button" class="btn  btn-block" style="background-color: #f16821; color: white;" >
            <i class="fas fa-backward"></i>  Retour</button>

    </div>


</body>

    <script>
        function goBack() {
        window.history.back();
        }
    </script>
</html>
