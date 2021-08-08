
@extends('racine')



@section('style')
 <!-- Icons -->


<style>
.ct-label{
    height: 30px;
    width: 20px !important;
      /** Rotation */
      -webkit-transform: rotate(-25deg);
        -moz-transform: rotate(-25deg);
        transform:rotate(-25deg);

}

path{
    fill: #d65600;
    stroke: rgb(247, 247, 247);
    stroke-width: 0.998664px;
}
</style>

@endsection

@section('title')
    Dashboard
@endsection

@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-5">
            <h4 class="page-title">Dashboard</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Colisade</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
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

    <div class="row">
        <div class="col-xl-3 col-md-3">
          <div class="card card-stats" class="d-inline-block">
            <!-- Card body -->
            <div class="card-body" >
              <div class="row">
                <div class="col">

                  <h5 class="card-title text-uppercase text-muted mb-0">Chiffre d'affaire NET</h5>
                  <span class="h2 font-weight-bold mb-0" >{{$ca}} DH</span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow"  data-toggle="tooltip" data-placement="top" title="CA TOTAL des Commandes Livrées">
                    <i class="ni ni-money-coins"></i>


                  </div>
                </div>
              </div>
              <p class="mt-3 mb-0 text-sm">
                  @if ($caPercent<=0)
                  <span class="text-danger mr-2"><i class="fa fa-arrow-down"></i> {{$caPercent}}%</span>
                  @elseif($caPercent<10)
                  <span class="text-warning mr-2"><i class="fa fa-arrow-right"></i> {{$caPercent}}%</span>
                  @else
                  <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{$caPercent}}%</span>
                  @endif
                <span class="text-nowrap">Depuis le mois dernier</span>
              </p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-3">
          <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">
                      @can('edit-users')
                      Commandes Livrées
                      @endcan
                      @can('fournisseur')
                      Montant facturé
                      @endcan

                    </h5>
                  <span class="h2 font-weight-bold mb-0">{{$caFacturer}} DH</span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow" data-toggle="tooltip" data-placement="top" title="Montants facturés">
                    <i class="ni ni-active-40"></i>

                  </div>
                </div>
              </div>
              <p class="mt-3 mb-0 text-sm">
                <span class="text-success mr-2"><i class="fas fa-file-invoice-dollar"></i>  {{$caNonfacturer}} MAD</span>
                <span class="text-nowrap">
                    @can('edit-users')
                        Part des livreurs
                    @endcan

                    @can('fournisseur')
                    Restant à Facturer
                    @endcan

                    </span>
              </p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-3">
          <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                    @can('edit-users')
                    <h5 class="card-title text-uppercase text-muted mb-0">Commandes Refusées</h5>
                    <span class="h2 font-weight-bold mb-0">{{$cmdRefuser}} MAD</span>
                    @endcan
                    @can('fournisseur')
                    <h5 class="card-title text-uppercase text-muted mb-0">Commandes Refusées</h5>
                    <span class="h2 font-weight-bold mb-0">{{$cmdRefuser}} Commandes</span>
                    @endcan

                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                    <i class="ni ni-chart-pie-35"></i>
                  </div>
                </div>
              </div>
              <p class="mt-3 mb-0 text-sm">
                  @can('edit-users')
                  <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{$cmdLivRefuser}} MAD</span>
                  <span class="text-nowrap">Part des livreurs</span>
                  @endcan
                  @can('fournisseur')
                  <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{$cmdLivRefuser}} %</span>
                  <span class="text-nowrap">Des commandes</span>
                  @endcan

              </p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-3">
          <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Commandes du jour</h5>
                  <span class="h2 font-weight-bold mb-0">{{$todayCmd}} Commandes</span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                    <i class="ni ni-chart-bar-32"></i>
                  </div>
                </div>
              </div>
              <p class="mt-3 mb-0 text-sm">
                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{$lastdayCmd}} Commandes</span>
                <span class="text-nowrap">Commandes d'hier</span>
              </p>
            </div>
          </div>
        </div>
      </div>


    <!-- ============================================================== -->
    <!-- Sales chart -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-md-flex align-items-center">
                        <div>
                            <h4 class="card-title">Statistique de chiffre d'affaire par mois</h4>
                            <h5 class="card-subtitle">Les commandes livrées et les Non livrées</h5>
                        </div>
                        <div class="ml-auto d-flex no-block align-items-center">
                            <ul class="list-inline font-12 dl m-r-15 m-b-0">
                                <li class="list-inline-item text-info"><i class="fa fa-circle"></i> Livrée</li>
                                <li class="list-inline-item text-primary"><i class="fa fa-circle"></i> Non Livrée</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <!-- column -->
                        <div class="col-lg-12">
                            <div class="campaign ct-charts"></div>
                        </div>
                        <!-- column -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Statuts des commandes</h4>
                    <div class="feed-widget">
                        <ul class="list-style-none feed-body m-0 p-b-20">
                            <li class="feed-item">
                                <div class="feed-icon bg-warning"><i class="ti-shopping-cart"></i></div> {{$tab['expidie']['nbr']}} Commandes <br> Envoyées. <span class="ml-auto font-12 text-muted">{{$tab['expidie']['date']}}</span></li>
                            <li class="feed-item">
                                <div class="feed-icon bg-info"><i class="mdi mdi-truck"></i></div> {{$tab['en_cours']['nbr']}} Commandes <br> En Cours de livraison.<span class="ml-auto font-12 text-muted">{{$tab['en_cours']['date']}}</span></li>
                            <li class="feed-item">
                                <div class="feed-icon bg-success"><i class="mdi mdi-checkbox-marked-outline"></i></div> {{$tab['livré']['nbr']}} Commandes <br> Livrées.<span class="ml-auto font-12 text-muted">{{$tab['livré']['date']}}</span></li>
                            <li class="feed-item">
                                <div class="feed-icon bg-danger"><i class="mdi mdi-tumblr-reblog"></i></div> {{$tab['retour']['nbr']}} Commandes <br> NON Livrées.<span class="ml-auto font-12 text-muted">{{$tab['retour']['date']}}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
     <div class="row">
        <!-- column -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- title -->
                    <div class="d-md-flex align-items-center">
                        <div>
                            <h4 class="card-title">Top client</h4>
                            <h5 class="card-subtitle">Les commandes qui ont le plus grand montant</h5>
                        </div>

                    </div>
                    <!-- title -->
                </div>
                <div class="table-responsive">
                    <table class="table v-middle">
                        <thead class="thead-light">
                            <tr>
                                @can('ramassage-commande')
                                <th class="border-top-0">Nom du fournisseur</th>
                                @endcan
                                <th class="border-top-0">Nom du client</th>
                                <th class="border-top-0">Nombre de commandes</th>
                                <th class="border-top-0">Nombre de colis</th>
                                <th class="border-top-0">Montant</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topCmds as $index => $topCmd)
                            <tr>
                                @can('ramassage-commande')
                                <td>
                                    <div class="d-flex align-items-center">
                                    <div class="m-r-10">
                                        <a title="{{$users[$index]->name}}" class=" text-muted waves-effect waves-dark pro-pic"

                                                @can('edit-users')
                                                    href="{{route('admin.users.edit',$users[$index]->id)}}"
                                                @endcan

                                        >
                                        <img src="{{$users[$index]->image}}" alt="user" class="rounded-circle" width="31">
                                    </a>
                                    </div>
                                    <div>
                                        <h4 class="m-b-0 font-16">{{$users[$index]->name}}</h4>
                                    </div>
                                </div>
                                </td>
                                @endcan
                                <td>
                                            <h5 class="m-b-0 font-16">{{$topCmd->nom}}</h5>
                                </td>

                                <td>{{$topCmd->cmd}}</td>
                                <td>{{$topCmd->colis}}</td>
                                <td>
                                    <h5 class="m-b-0">{{$topCmd->m}} MAD</h5>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>




@endsection

@section('javascript')
<script src="{{url('/assets/libs/chartist/dist/chartist.min.js')}}"></script>
<script src="{{url('/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js')}}"></script>
<script>
    $(function() {
    "use strict";
    // ==============================================================
    // Newsletter
    // ==============================================================

    var livre = <?php echo $livre; ?> ;
    var retour = <?php echo $retour; ?> ;

   // console.log("heeeeeeeeeeeeeey",livre );
    var chart = new Chartist.Line('.campaign', {
        labels: [1, 2, 3, 4, 5, 6, 7, 8,9,10,11,12],
        series: [ livre, retour]

    }, {
        low: 0,
        high: livre,

        showArea: true,
        fullWidth: true,
        plugins: [
            Chartist.plugins.tooltip()
        ],
        axisY: {
            onlyInteger: true,
            scaleMinSpace: 30,
            offset: 20,
            labelInterpolationFnc: function(value) {
                return (value / 1) + '';
            }
        },

    });

    // Offset x1 a tiny amount so that the straight stroke gets a bounding box
    // Straight lines don't get a bounding box
    // Last remark on -> http://www.w3.org/TR/SVG11/coords.html#ObjectBoundingBox
    chart.on('draw', function(ctx) {
        if (ctx.type === 'area') {
            ctx.element.attr({
                x1: ctx.x1 + 0.001
            });
        }
    });

    // Create the gradient definition on created event (always after chart re-render)
    chart.on('created', function(ctx) {
        var defs = ctx.svg.elem('defs');
        defs.elem('linearGradient', {
            id: 'gradient',
            x1: 0,
            y1: 1,
            x2: 0,
            y2: 0
        }).elem('stop', {
            offset: 0,
            'stop-color': 'rgba(255, 255, 255, 1)'
        }).parent().elem('stop', {
            offset: 1,
            'stop-color': 'rgba(64, 196, 255, 1)'
        });
    });


    var chart = [chart];
});

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>

@endsection
