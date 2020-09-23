
@extends('racine')

@section('title')
    Inbox
@endsection

@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-5">
            <h4 class="page-title">Inbox  @can('ramassage-commande')
                (<b>{{auth()->user()->unreadNotifications->count()}}</b>) 
                @endcan</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Quickoo</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Inbox</li>
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
        <!-- column -->
        <div class="col-lg-12">
            <div class="card">
             
                <div class="comment-widgets scrollable">
                    @can('ramassage-commande')
                    @unless (Auth::user()->unreadNotifications->isEmpty())
                    @foreach ($notifications as $notification)
                    <!-- Comment Row -->
                    <div class="d-flex flex-row comment-row"   
                    @if ($notification->read_at == NULL)
                    style="
                    background-color: #e6edf1;
                    "
                    @endif
                    
                    >
                <div class="p-2"><img src="{{$notification->data['user']['image']}}" alt="user" width="50" class="rounded-circle"></div>
                        <div class="comment-text w-100">
                            <h5 class="font-medium" style="color: #e85f03"><b>{{$notification->data['user']['name']}}</b></h5>
                            <span class="m-b-15 d-block">A ajouté une nouvelle commande avec le numero :<a style="color:black" href="{{route('commandes.showFromNotify',['commande' => $notification->data['commande']['id'] ,
                                'notification' => $notification->id])}}">
                                 <b>{{$notification->data['commande']['numero']}}</b> 
                            </a>
                               </span>
                            <div class="comment-footer">
                                <span class="text-muted float-right">{{date_format($notification->created_at,"Y/m/d")}}
                                    <p class="proile-rating"><span> {{date_format($notification->created_at,"H:i:s")}}</span></p>
                                </span>
                                <span class="label label-rounded create-btn" style="background-color: #e85f03"><a style="color:white" href="{{route('commandes.showFromNotify',['commande' => $notification->data['commande']['id'] ,
                                    'notification' => $notification->id])}}">
                                    Voir le detail
                                </a>
                                </span>
                                <span class="action-icons">
                                        <a href="{{route('commandes.showFromNotify',['commande' => $notification->data['commande']['id'] ,
                                            'notification' => $notification->id])}}" data-toggle="tooltip" data-placement="top" title="Modifier"><i class="ti-pencil-alt"></i></a>
                                        <a href="{{route('inbox.show', $notification->id)}}" data-toggle="tooltip" data-placement="top" title="marquer lu"><i class="ti-check"></i></a>
                                        <a href="{{route('inbox.destroy', $notification->id)}}" data-toggle="tooltip" data-placement="top" title="supprimer"><i class="ti-close"></i></a>    
                                    </span>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @endunless
                    @endcan      
                </div>
            </div>
        </div>
        <!-- column -->
      
    <!-- Recent comment and chats -->
    <!-- ============================================================== -->
</div>

@endsection

