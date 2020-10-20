
@extends('racine')

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
                        <li class="breadcrumb-item"><a href="#">Quickoo</a></li>
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
    <!-- ============================================================== -->
    <!-- Sales chart -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-md-flex align-items-center">
                        <div>
                            <h4 class="card-title">Les commandes livrés et les retours</h4>
                            <h5 class="card-subtitle">Statistique par mois</h5>
                        </div>
                        <div class="ml-auto d-flex no-block align-items-center">
                            <ul class="list-inline font-12 dl m-r-15 m-b-0">
                                <li class="list-inline-item text-info"><i class="fa fa-circle"></i> Livré</li>
                                <li class="list-inline-item text-primary"><i class="fa fa-circle"></i> Retour</li>
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
                                <div class="feed-icon bg-warning"><i class="ti-shopping-cart"></i></div> {{$tab['expidie']['nbr']}} Commandes <br> Expidiées. <span class="ml-auto font-12 text-muted">{{$tab['expidie']['date']}}</span></li>
                            <li class="feed-item">
                                <div class="feed-icon bg-info"><i class="mdi mdi-truck"></i></div> {{$tab['en_cours']['nbr']}} Commandes <br> Ramassées.<span class="ml-auto font-12 text-muted">{{$tab['en_cours']['date']}}</span></li>
                            <li class="feed-item">
                                <div class="feed-icon bg-success"><i class="mdi mdi-checkbox-marked-outline"></i></div> {{$tab['livré']['nbr']}} Commandes <br> Livrées.<span class="ml-auto font-12 text-muted">{{$tab['livré']['date']}}</span></li>
                            <li class="feed-item">
                                <div class="feed-icon bg-danger"><i class="mdi mdi-tumblr-reblog"></i></div> {{$tab['retour']['nbr']}} Retour <br> Commandes.<span class="ml-auto font-12 text-muted">{{$tab['retour']['date']}}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Sales chart -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Table -->
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
                        <thead>
                            <tr class="bg-light">
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
  
  {{--   <div class="row">
        <!-- column -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Recent Comments</h4>
                </div>
                <div class="comment-widgets scrollable">
                    <!-- Comment Row -->
                    <div class="d-flex flex-row comment-row m-t-0">
                        <div class="p-2"><img src="../../assets/images/users/1.jpg" alt="user" width="50" class="rounded-circle"></div>
                        <div class="comment-text w-100">
                            <h6 class="font-medium">James Anderson</h6>
                            <span class="m-b-15 d-block">Lorem Ipsum is simply dummy text of the printing and type setting industry. </span>
                            <div class="comment-footer">
                                <span class="text-muted float-right">April 14, 2016</span> <span class="label label-rounded label-primary">Pending</span> <span class="action-icons">
                                        <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                        <a href="javascript:void(0)"><i class="ti-check"></i></a>
                                        <a href="javascript:void(0)"><i class="ti-heart"></i></a>    
                                    </span>
                            </div>
                        </div>
                    </div>
                    <!-- Comment Row -->
                    <div class="d-flex flex-row comment-row">
                        <div class="p-2"><img src="../../assets/images/users/4.jpg" alt="user" width="50" class="rounded-circle"></div>
                        <div class="comment-text active w-100">
                            <h6 class="font-medium">Michael Jorden</h6>
                            <span class="m-b-15 d-block">Lorem Ipsum is simply dummy text of the printing and type setting industry. </span>
                            <div class="comment-footer ">
                                <span class="text-muted float-right">April 14, 2016</span>
                                <span class="label label-success label-rounded">Approved</span>
                                <span class="action-icons active">
                                        <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                        <a href="javascript:void(0)"><i class="icon-close"></i></a>
                                        <a href="javascript:void(0)"><i class="ti-heart text-danger"></i></a>    
                                    </span>
                            </div>
                        </div>
                    </div>
                    <!-- Comment Row -->
                    <div class="d-flex flex-row comment-row">
                        <div class="p-2"><img src="../../assets/images/users/5.jpg" alt="user" width="50" class="rounded-circle"></div>
                        <div class="comment-text w-100">
                            <h6 class="font-medium">Johnathan Doeting</h6>
                            <span class="m-b-15 d-block">Lorem Ipsum is simply dummy text of the printing and type setting industry. </span>
                            <div class="comment-footer">
                                <span class="text-muted float-right">April 14, 2016</span>
                                <span class="label label-rounded label-danger">Rejected</span>
                                <span class="action-icons">
                                        <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                        <a href="javascript:void(0)"><i class="ti-check"></i></a>
                                        <a href="javascript:void(0)"><i class="ti-heart"></i></a>    
                                    </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- column -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Temp Guide</h4>
                    <div class="d-flex align-items-center flex-row m-t-30">
                        <div class="display-5 text-info"><i class="wi wi-day-showers"></i> <span>73<sup>°</sup></span></div>
                        <div class="m-l-10">
                            <h3 class="m-b-0">Saturday</h3><small>Ahmedabad, India</small>
                        </div>
                    </div>
                    <table class="table no-border mini-table m-t-20">
                        <tbody>
                            <tr>
                                <td class="text-muted">Wind</td>
                                <td class="font-medium">ESE 17 mph</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Humidity</td>
                                <td class="font-medium">83%</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Pressure</td>
                                <td class="font-medium">28.56 in</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Cloud Cover</td>
                                <td class="font-medium">78%</td>
                            </tr>
                        </tbody>
                    </table>
                    <ul class="row list-style-none text-center m-t-30">
                        <li class="col-3">
                            <h4 class="text-info"><i class="wi wi-day-sunny"></i></h4>
                            <span class="d-block text-muted">09:30</span>
                            <h3 class="m-t-5">70<sup>°</sup></h3>
                        </li>
                        <li class="col-3">
                            <h4 class="text-info"><i class="wi wi-day-cloudy"></i></h4>
                            <span class="d-block text-muted">11:30</span>
                            <h3 class="m-t-5">72<sup>°</sup></h3>
                        </li>
                        <li class="col-3">
                            <h4 class="text-info"><i class="wi wi-day-hail"></i></h4>
                            <span class="d-block text-muted">13:30</span>
                            <h3 class="m-t-5">75<sup>°</sup></h3>
                        </li>
                        <li class="col-3">
                            <h4 class="text-info"><i class="wi wi-day-sprinkle"></i></h4>
                            <span class="d-block text-muted">15:30</span>
                            <h3 class="m-t-5">76<sup>°</sup></h3>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div> 
   --}}
    <!-- Recent comment and chats -->
    <!-- ============================================================== -->
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
</script>

@endsection