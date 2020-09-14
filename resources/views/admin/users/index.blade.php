
@extends('racine')

@section('title')
   Gestion des Utilisateurs
@endsection



@section('style')
    <style>
        .page-link {
            color: #e85f03 !important;
        }
        .page-item.active .page-link {
            
            background-color: #e85f03 !important;
            border-color: #e85f03 !important;
            color: #fff !important;
        }
    </style>
@endsection


@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-5">
            <h4 class="page-title">Gestion des Utilisateurs</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Quickoo</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Utilisateurs</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-7">
            <div class="text-right upgrade-btn">
            <a  class="btn btn-danger text-white" href="{{route('register')}}"><i class="fa fa-plus-square"></i> Ajouter</a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nom & Prénom</th>
                            <th scope="col">Email</th>
                            <th scope="col">Rôles</th>
                            @can('edit-users')
                            <th scope="col">Action</th>
                            @endcan
                            
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                          <tr>
                            <th scope="row"><img src="{{$user->image}}" alt="user" class="rounded-circle" width="31"></a></th>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{ implode(', ' , $user->roles()->get()->pluck('name')->toArray() )}}</td>
                            @can('edit-users')
                            <td>
                                <a href="{{route('admin.users.edit',$user->id)}}">
                                   <button class="btn btn-primary float-lef"><i class="mdi mdi-account-edit"></i></button>
                               </a>
                               <a href="{{route('admin.users.destroy',$user->id)}}">
                                   <form action="{{route('admin.users.destroy',$user->id)}}" method="POST" class="float-left">
                                       @csrf
                                       @method("DELETE")
                                       <button class="btn btn-warning"><i class="mdi mdi-delete"></i></button>
                                   </form>
                                   
                               </a>
                           </td>
                            @endcan
                            
                            </tr>
                          @endforeach

                        </tbody>
                      </table>
                  
                     
                  
                </div>
            </div>
        </div>
    </div>

</div>




@endsection

@section('javascript')
    @if ($errors->any())
        <script type="text/javascript">
            $(window).on('load',function(){
                $('#modalSubscriptionForm').modal('show');
            });
        </script>
    @endif
@endsection