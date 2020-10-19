
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
                        <li class="breadcrumb-item"><a href="/admin/users">Utilisateurs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$user->name}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    
    </div>
</div>

<div class="container-fluid">
    
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Modifier l'utilisateur: {{ $user->name}}</div>

                <div class="card-body">
                <form method="POST" action="{{route('admin.users.update',$user)}}">
                    @csrf
                    @method("PUT")
                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label text-md-right">Nom & Prénom: </label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required  autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-2 col-form-label text-md-right">Email: </label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label text-md-right">Url de l'image</label>
                        <div class="col-md-6">
                            <input name="image" type="text" value="{{$user->image}}"class="form-control form-control-line">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label text-md-right">ICE</label>
                        <div class="col-md-6">
                            <input name="description" type="text" value="{{$user->description}}"class="form-control form-control-line">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="roles" class="col-md-2 col-form-label text-md-right">Rôles: </label>
                        <div class="col-md-6">
                    @foreach ($roles as $role)
                        <div class="form-check">
                            @if (in_array($role->name, $user->roles()->get()->pluck('name')->toArray()) )
                            <input type="radio" name="roles[]" value="{{$role->id}}" id="{{$role->name}}" checked>
                            @else
                            <input type="radio" name="roles[]" value="{{$role->id}}" id="{{$role->name}}">
                            @endif
                            <label for="{{$role->name}}">
                                @switch($role->name)
                                    @case('client')
                                     Collecte, Livraison
                                        @break
                                    @case('ecom')
                                    Collecte, livraison, stockage
                                        @break
                                    @default
                                    {{$role->name}}
                                @endswitch
                            </label>
                        </div>
                    @endforeach
                    </div>
                </div>
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </form>
                  
                     
                  
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