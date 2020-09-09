
@extends('racine')

@section('title')
   Gestion des Colis
@endsection

@section('title')
    Dashboard
@endsection

@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-5">
            <h4 class="page-title">Gestion des Colis</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Quickoo</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Colis</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-7">
            <div class="text-right upgrade-btn">
                <a  class="btn btn-danger text-white" target="_blank">Ajouter une commande</a>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
      
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Gestion des comandes / colis</h4>
                    <h6 class="card-subtitle">Nombre total des commande : <code>33 Commandes</code> .</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Numero Commande</th>
                                <th scope="col">Nom Complet</th>
                                <th scope="col">Téléphone</th>
                                <th scope="col">Ville</th>
                                <th scope="col">Adresse</th>
                                <th scope="col">Montant</th>
                                <th scope="col">Prix de Livraison</th>
                                <th scope="col">Date</th>
                                <th scope="col">Statut</th>
                                <th scope="col">Ticket</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Outiti Ayoub</td>
                                <td>0649440905</td>
                                <td>Tanger</td>
                                <td>Lot fath 27 avenue lirak</td>
                                <td>173 MAD</td>
                                <td>17 MAD</td>
                                <td>01/08/2020</td>
                                <td>Livré</td>
                                <td style="font-size: 1.5em"><a style="color: #e85f03" href=""><i class="mdi mdi-eye"></i></a></td>

                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Outiti Ayoub</td>
                                <td>0649440905</td>
                                <td>Tanger</td>
                                <td>Lot fath 27 avenue lirak</td>
                                <td>173 MAD</td>
                                <td>17 MAD</td>
                                <td>01/08/2020</td>
                                <td>Livré</td>
                                <td style="font-size: 1.5em"><a style="color: #e85f03" href=""><i class="mdi mdi-eye"></i></a></td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Outiti Ayoub</td>
                                <td>0649440905</td>
                                <td>Tanger</td>
                                <td>Lot fath 27 avenue lirak</td>
                                <td>173 MAD</td>
                                <td>17 MAD</td>
                                <td>01/08/2020</td>
                                <td>Livré</td>
                                <td style="font-size: 1.5em"><a style="color: #e85f03" href=""><i class="mdi mdi-eye"></i></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Right sidebar -->
    <!-- ============================================================== -->
    <!-- .right-sidebar -->
    <!-- ============================================================== -->
    <!-- End Right sidebar -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- footer -->
<!-- ============================================================== -->

@endsection

@section('javascript')

@endsection