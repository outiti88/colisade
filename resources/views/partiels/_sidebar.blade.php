<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- User Profile-->
                <li>
                    <!-- User Profile-->
                    <div class="user-profile d-flex no-block dropdown m-t-20">
                        <div class="user-pic"><img src="{{Auth::user()->image}}" alt="users" class="rounded-circle" width="40" /></div>
                        <div class="user-content hide-menu m-l-10" style="font-size: 0.75em;">
                            <a href="javascript:void(0)" class="" id="Userdd" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <h5 style="font-size: 1.5em;" class="m-b-0 user-name font-medium">{{ Auth::user()->name }}<i class="fa fa-angle-down"></i></h5>
                                <span class="op-5 user-email">{{ Auth::user()->email }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Userdd">
                                <a class="dropdown-item" href="/profil" ><i class="ti-user m-r-5 m-l-5"></i> Mon Profil</a>
                                <a class="dropdown-item" href="{{route('facture.index')}}"><i class="ti-wallet m-r-5 m-l-5"></i> Facture</a>
                                <a class="dropdown-item" href="{{route('inbox.index')}}"><i class="ti-email m-r-5 m-l-5"></i> Inbox
                                    <span class="nbrNotify" style="
                                    left: 90px;
                                    top: 105px;
                                    position: absolute;
                                    " ><b>{{auth()->user()->unreadNotifications->count()}}</b></span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0)"><i class="ti-settings m-r-5 m-l-5"></i> Parametre</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item"  href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    <i class="fa fa-power-off m-r-5 m-l-5"></i>
                                    Deconnexion
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                     @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End User Profile-->
                </li>
                
                @can('fournisseur')
                <li class="p-15 m-t-10"><a href="javascript:void(0)" class="btn btn-block create-btn text-white no-block d-flex align-items-center" data-toggle="modal" data-target="#modalSubscriptionForm">
                    <i class="fa fa-plus-square"></i> 
                    <span class="hide-menu m-l-5">Nouvelle Commande</span> </a></li>
                @endcan
                @can('manage-users')
                <li class="p-15 m-t-10"><a href="{{route('register')}}" class="btn btn-block create-btn text-white no-block d-flex align-items-center">
                    <i class="fa fa-plus-square"></i> 
                    <span class="hide-menu m-l-5">Nouveau Utilisateur</span> </a></li>
                @endcan
                <!-- User Profile-->
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/profil" aria-expanded="false"><i class="mdi mdi-account-network"></i><span class="hide-menu">Profile</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/commandes" aria-expanded="false"><i class="mdi mdi-package-variant"></i><span class="hide-menu">Gestion des commandes</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('bonlivraison.index')}}" aria-expanded="false"><i class="mdi mdi-note-text"></i><span class="hide-menu">Bon de livraison</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('facture.index')}}" aria-expanded="false"><i class="mdi mdi-newspaper"></i><span class="hide-menu">Facture</span></a></li>
                @can('gestion-stock')
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('produit.index')}}" aria-expanded="false"><i class="mdi mdi-package-variant-closed"></i><span class="hide-menu">Gestion du stock</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('reception.index')}}" aria-expanded="false"><i class="mdi mdi-truck"></i><span class="hide-menu">Reception</span></a></li>
                @endcan
                @can('manage-users')
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('admin.users.index')}}" aria-expanded="false"><i class="mdi mdi-account-switch"></i><span class="hide-menu">Utilisateurs</span></a></li>
                @endcan
            </ul>
            
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>

<div class="container my-4">    
    @can('client')
    <div class="modal fade" id="modalSubscriptionForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header text-center">
                          <h4 class="modal-title w-100 font-weight-bold">Nouvelle Commande</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body mx-3">
                            <form class="form-horizontal form-material" method="POST" action="{{route('commandes.store')}}">
                                @csrf
                                <div class="form-group">
                                    <label class="col-md-12">Nom et Prénom du destinataire :</label>
                                    <div class="col-md-12">
                                        <input  value="{{ old('nom') }}" name="nom" type="text" placeholder="Nom & Prénom" class="form-control form-control-line">
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="example-email" class="col-md-12">Nombre de Colis :</label>
                                        <div class="col-md-12">
                                            <input  value="{{ old('colis') }}" type="number" class="form-control form-control-line" name="colis" id="example-email">
                                        </div>
                                    </div>
    
    
    
                                      <fieldset class="form-group col-md-6">
                                        <div class="row">
                                          <legend class="col-form-label  pt-0">Mode de paiement :</legend>
                                          <div class="col-sm-12">
                                            <div class="form-check">
                                              <input  onclick="myFunction2(this.value)" class="form-check-input" type="radio" name="mode" id="cd" value="cd" checked>
                                              <label class="form-check-label" for="cd">
                                              à la livraison
                                              </label>
                                            </div>
                                            <div class="form-check">
                                              <input  onclick="myFunction2(this.value)" class="form-check-input" type="radio" name="mode" id="cp" value="cp">
                                              <label class="form-check-label" for="cp">
                                                carte bancaire
                                              </label>
                                            </div>
                                        
                                          </div>
                                        </div>
                                      </fieldset>
    
                                      <div class="form-group col-md-12" id="montant"  style="display: block">
                                        <label for="example-email" class="col-md-12">Montant (MAD) :</label>
                                        <div class="col-md-12">
                                            <input  value="{{ old('montant') }}" type="number" class="form-control form-control-line" name="montant" id="example-email">
                                        </div>
                                    </div>
                                    
                                </div>
                
                                <div class="form-group">
                                    <label class="col-md-12">Téléphone :</label>
                                    <div class="col-md-12">
                                        <input value="{{ old('telephone') }}"  name="telephone" type="text" placeholder="0xxx xxxxxx" class="form-control form-control-line">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Adresse :</label>
                                    <div class="col-md-12">
                                        <textarea  name="adresse" rows="5" class="form-control form-control-line">{{ old('adresse') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12">Ville :</label>
                                    <div class="col-sm-12">
                                        <select value="{{ old('ville') }}" name="ville" class="form-control form-control-line" id="ville" onchange="myFunction()" required>
                                            <option checked>Choisissez la ville</option>
                                            <option value="Tanger">Tanger</option>
                                            <option >Marrakech</option>
                                            <option >Kénitra</option>
                                            <option >Casablanca</option>
                                            <option >Rabat</option>
                                        </select>
                                    </div>
                                </div>
                                <div style="display: none"  class="form-group" id="secteur">
                                    <label class="col-sm-12">Secteur :</label>
                                    <div class="col-sm-12">
                                      <select  value="{{ old('secteur') }}" name="secteur" class="form-control form-control-line">

                                        <option value="">Tous les secteurs</option>
                                            <option>Aviation</option>
                                            <option>Al Kasaba</option>
                                            <option>Cap spartel</option>
                                            <option>Centre ville</option>
                                            <option>Cité californie</option>
                                            <option>Girari</option>
                                            <option>Ibn Taymia</option>
                                            <option>M'nar</option>
                                            <option>M'sallah</option>
                                            <option>Makhoukha</option>
                                            <option>Malabata</option>
                                            <option>Marchane</option>
                                            <option>Marjane</option>
                                            <option>Moujahidine</option>
                                            <option>Moulay Youssef</option>
                                            <option>Santa</option>
                                            <option>Val Fleuri</option>
                                            <option>Vieille montagne</option>
                                            <option>Ziatene</option>
                                            <option>Autre secteur</option>
                                            <option>Achennad</option>
                                            <option>Aharrarine</option>
                                            <option>Ahlane</option>
                                            <option>Aida</option>
                                            <option>Al Anbar</option>
                                            <option>Al Warda</option>
                                            <option>Aouama Gharbia</option>
                                            <option>Beausejour</option>
                                            <option>Behair</option>
                                            <option>Ben Dibane</option>
                                            <option>Beni Makada Lakdima</option>
                                            <option>Beni Said</option>
                                            <option>Beni Touzine</option>
                                            <option>Bir Aharchoune</option>
                                            <option>Bir Chifa</option>
                                            <option>Bir El Ghazi</option>
                                            <option>Bouchta-Abdelatif</option>
                                            <option>Bouhout 1</option>
                                            <option>Bouhout 2</option>
                                            <option>Dher Ahjjam</option>
                                            <option>Dher Lahmam</option>
                                            <option>El Baraka</option>
                                            <option>El Haj El Mokhtar</option>
                                            <option>El Khair 1</option>
                                            <option>El Khair 2</option>
                                            <option>El Mers 1</option>
                                            <option>El Mers 2</option>
                                            <option>El Mrabet</option>
                                            <option>Ennasr</option>
                                            <option>Gourziana</option>
                                            <option>Haddad</option>
                                            <option>Hanaa 1</option>
                                            <option>Hanaa 2</option>
                                            <option>Hanaa 3 - Soussi</option>
                                            <option>Jirrari</option>
                                            <option>Les Rosiers</option>
                                            <option>Zemmouri</option>
                                            <option>Zouitina</option>
                                            <option>Al Amal</option>
                                            <option>Al Mandar Al Jamil</option>
                                            <option>Alia</option>
                                            <option>Benkirane</option>
                                            <option>Charf</option>
                                            <option>Draoua</option>
                                            <option>Drissia</option>
                                            <option>El Majd</option>
                                            <option>El Oued</option>
                                            <option>Mghogha</option>
                                            <option>Nzaha</option>
                                            <option>Sania</option>
                                            <option>Tanger City Center</option>
                                            <option>Tanja Balia</option>
                                            <option>Zone Industrielle Mghogha</option>
                                            <option>Azib Haj Kaddour</option>
                                            <option>Bel Air - Val fleuri</option>
                                            <option>Bir Chairi</option>
                                            <option>Branes 1</option>
                                            <option>Branes 2</option>
                                            <option>Casabarata</option>
                                            <option>Castilla</option>
                                            <option>Hay Al Bassatine</option>
                                            <option>Hay El Boughaz</option>
                                            <option>Hay Zaoudia</option>
                                            <option>Lalla Chafia</option>
                                            <option>Souani</option>
                                            <option>Achakar</option>
                                            <option>Administratif</option>
                                            <option>Ahammar</option>
                                            <option>Ain El Hayani</option>
                                            <option>Algerie</option>
                                            <option>Branes Kdima</option>
                                            <option>Californie</option>
                                            <option>Centre</option>
                                            <option>De La Plage</option>
                                            <option>Du Golf</option>
                                            <option>Hay Hassani</option>
                                            <option>Iberie</option>
                                            <option>Jbel Kbir</option>
                                            <option>Laaouina</option>
                                            <option>Marchan</option>
                                            <option>Mediouna</option>
                                            <option>Mesnana</option>
                                            <option>Mghayer</option>
                                            <option>Mister Khouch</option>
                                            <option>Mozart</option>
                                            <option>Msala</option>
                                            <option>Médina</option>
                                            <option>Port Tanger ville</option>
                                            <option>Rmilat</option>
                                            <option>Star Hill</option>
                                            <option>manar</option>
                                      </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button class="btn btn-danger">Ajouter</button>
                                        
                                    </div>
                                </div>
                            </form>
                            @if ($errors->any())
                            <div class="alert alert-dismissible alert-danger">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>
                                        <strong>{{$error}}</strong>
                                        </li>
                                    @endforeach
                                </ul>
                              </div>
                              @endif
                        </div>
            
                      </div>
                    </div>
    </div>
    @endcan
</div>

