
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
        
        @if (session()->has('nonExpidie'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Erreur !</strong>Commande déjà traitée  {{session()->get('nonExpidie')}} <br>
                vous pouvez modifier que les statuts des commandes qui ont le statut <b>Expidié</b>
        </div>
        @endif
        @if (session()->has('blgenere'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Erreur !</strong>vous ne pouvez pas changer le statut de La commande numero {{session()->get('blgenere')}} <br>
                => le bon de livraison pour cette commande à été déjà généré
        </div>
        @endif
        @if (session()->has('edit'))
        <div class="alert alert-dismissible alert-info col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Succés !</strong> Le statut de la commande numero {{session()->get('edit')}} à été bien edité !!
          </div>
        @endif
        @if (session()->has('noedit'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Erreur !</strong>vous ne pouvez pas changer le statut La commande numero {{session()->get('noedit')}}
          </div>
        @endif 

        <div class="col-lg-12">
            <div class="card">
             
                <div class="comment-widgets scrollable">
                    @foreach ($notifications as $notification)
                    <!-- Comment Row -->
                    <div class="d-flex flex-row comment-row"   
                    @if ($notification->read_at == NULL)
                    style="
                    background-color: #e6edf1;
                    "
                    @endif
                    
                    >
                <div class="p-2"><img src="
                    @can('ramassage-commande')
                    {{$notification->data['user']['image']}}
                    @endcan
                    @can('client')
                    https://scontent.frba3-1.fna.fbcdn.net/v/t1.0-9/107093937_2858330454295626_6840339815783805174_o.png?_nc_cat=101&_nc_sid=174925&_nc_ohc=f7hP3-o3n4oAX9AW9GV&_nc_ht=scontent.frba3-1.fna&oh=a91e690eb2d5ab61a7bfc34535465f58&oe=5F8F82CD
                    @endcan
                    "
                    alt="user" width="50" class="rounded-circle"></div>
                        <div class="comment-text w-100">
                            @can('ramassage-commande')
                                <h4 class=" float-right">
                                    <a href="{{ route('commandeStatut',['id'=> $notification->data['commande']['id'] ]) }}">
                                        <span class="badge badge-info">
                                            <i class="m-10 mdi mdi-verified"></i>
                                        </span>
                                    </a>
                                </h4>
                            @endcan
                            

                            <h5 class="font-medium" style="color: #e85f03">
                                <b>
                                    @can('ramassage-commande')
                                    {{$notification->data['user']['name']}}
                                    @endcan
                                    @can('client')
                                    Quickoo Delivery
                                    @endcan
                                </b>
                            </h5>


                            <span class="m-b-15 d-block">
                                    @can('ramassage-commande')
                                    A ajouté une nouvelle commande avec le numero :
                                    @endcan
                                    @can('client')
                                    A modifié le staut de la commande :
                                    @endcan
                                
                                <a style="color:black" href="{{route('commandes.showFromNotify',['commande' => $notification->data['commande']['id'] ,
                                'notification' => $notification->id])}}">
                                 <b>{{$notification->data['commande']['numero']}}</b> 
                                 </a>
                            </span>
                            <div class="comment-footer">
                                <span class="text-muted float-right">
                                    @can('ramassage-commande')
                                    {{date_format($notification->created_at,"Y/m/d")}}
                                    @endcan
                                    @can('client')
                                    {{date_format($notification->updated_at,"Y/m/d")}}
                                    @endcan
                                    <p class="proile-rating"><span> 
                                        @can('ramassage-commande')
                                        {{date_format($notification->created_at,"H:i:s")}}
                                        @endcan
                                        @can('client')
                                        {{date_format($notification->updated_at,"H:i:s")}}
                                        @endcan
                                    </span></p>
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

                      

                </div>
            </div>
        </div>
        <!-- column -->
      
    <!-- Recent comment and chats -->
    <!-- ============================================================== -->
</div>

@endsection

