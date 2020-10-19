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
                
                @can('client')
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
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('produit.index')}}" aria-expanded="false"><i class="mdi mdi-package-variant-closed"></i><span class="hide-menu">Gestion de stock</span></a></li>
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
                                    <div class="form-group col-md-4">
                                        <label for="example-email" class="col-md-12">Nombre de Colis :</label>
                                        <div class="col-md-12">
                                            <input  value="{{ old('colis') }}" type="number" class="form-control form-control-line" name="colis" id="example-email">
                                        </div>
                                    </div>
    
    
                                    <fieldset class="form-group col-md-4">
                                        <div class="row">
                                          <legend class="col-form-label  pt-0">Poids :</legend>
                                          <div class="col-sm-12">
                                            <div class="form-check">
                                              <input   class="form-check-input" type="radio" name="poids" id="normal" value="normal" checked>
                                              <label class="form-check-label" for="normal">
                                                P. Normal
                                              </label>
                                            </div>
                                            <div class="form-check">
                                              <input   class="form-check-input" type="radio" name="poids" id="voluminaux" value="voluminaux">
                                              <label class="form-check-label" for="voluminaux">
                                                P. Volumineux
                                              </label>
                                            </div>
                                        
                                          </div>
                                        </div>
                                      </fieldset>
    
                                      <fieldset class="form-group col-md-4">
                                        <div class="row">
                                          <legend class="col-form-label  pt-0">Mode de paiement :</legend>
                                          <div class="col-sm-12">
                                            <div class="form-check">
                                              <input  onclick="myFunction2(this.value)" class="form-check-input" type="radio" name="mode" id="cd" value="cd" checked>
                                              <label class="form-check-label" for="cd">
                                                Cash on delivery
                                              </label>
                                            </div>
                                            <div class="form-check">
                                              <input  onclick="myFunction2(this.value)" class="form-check-input" type="radio" name="mode" id="cp" value="cp">
                                              <label class="form-check-label" for="cp">
                                                Card payment
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
                                        <select name="ville" class="form-control form-control-line" id="ville" onchange="myFunction()" required>
                                            <option checked>Choisissez la ville</option>
                                            <option value="tanger">Tanger</option>
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
                                        <select name="secteur" class="form-control form-control-line" required>
                                            
                                            <option value="">Tous les secteurs</option>
                                            <option value="0">Al Kasaba</option>
                                            <option value="0">Aviation</option>
                                            <option value="0">Cap spartel</option>
                                            <option value="0">Centre ville</option>
                                            <option value="0">Cité californie</option>
                                            <option value="0">Girari</option>
                                            <option value="0">Ibn Taymia</option>
                                            <option value="1">M'nar</option>
                                            <option value="0">M'sallah</option>
                                            <option value="0">Makhoukha</option>
                                            <option value="0">Malabata</option>
                                            <option value="0">Marchane</option>
                                            <option value="0">Marjane</option>
                                            <option value="0">Moujahidine</option>
                                            <option value="0">Moulay Youssef</option>
                                            <option value="0">Santa</option>
                                            <option value="0">Val Fleuri</option>
                                            <option value="0">Vieille montagne</option>
                                            <option value="0">Ziatene</option>
                                            <option value="0">Autre secteur</option>
                                            <option value="0">Achennad</option>
                                            <option value="0">Aharrarine</option>
                                            <option value="0">Ahlane</option>
                                            <option value="0">Aida</option>
                                            <option value="0">Al Anbar</option>
                                            <option value="0">Al Warda</option>
                                            <option value="0">Aouama Gharbia</option>
                                            <option value="0">Beausejour</option>
                                            <option value="0">Behair</option>
                                            <option value="0">Ben Dibane</option>
                                            <option value="0">Beni Makada Lakdima</option>
                                            <option value="0">Beni Said</option>
                                            <option value="0">Beni Touzine</option>
                                            <option value="0">Bir Aharchoune</option>
                                            <option value="0">Bir Chifa</option>
                                            <option value="0">Bir El Ghazi</option>
                                            <option value="0">Bouchta-Abdelatif</option>
                                            <option value="0">Bouhout 1</option>
                                            <option value="0">Bouhout 2</option>
                                            <option value="0">Dher Ahjjam</option>
                                            <option value="0">Dher Lahmam</option>
                                            <option value="0">El Baraka</option>
                                            <option value="0">El Haj El Mokhtar</option>
                                            <option value="0">El Khair 1</option>
                                            <option value="0">El Khair 2</option>
                                            <option value="0">El Mers 1</option>
                                            <option value="0">El Mers 2</option>
                                            <option value="0">El Mrabet</option>
                                            <option value="0">Ennasr</option>
                                            <option value="0">Gourziana</option>
                                            <option value="0">Haddad</option>
                                            <option value="0">Hanaa 1</option>
                                            <option value="0">Hanaa 2</option>
                                            <option value="0">Hanaa 3 - Soussi</option>
                                            <option value="0">Jirrari</option>
                                            <option value="0">Les Rosiers</option>
                                            <option value="0">Zemmouri</option>
                                            <option value="0">Zouitina</option>
                                            <option value="0">Al Amal</option>
                                            <option value="0">Al Mandar Al Jamil</option>
                                            <option value="0">Alia</option>
                                            <option value="0">Benkirane</option>
                                            <option value="0">Charf</option>
                                            <option value="0">Draoua</option>
                                            <option value="0">Drissia</option>
                                            <option value="0">El Majd</option>
                                            <option value="0">El Oued</option>
                                            <option value="0">Mghogha</option>
                                            <option value="0">Nzaha</option>
                                            <option value="0">Sania</option>
                                            <option value="0">Tanger City Center</option>
                                            <option value="0">Tanja Balia</option>
                                            <option value="1">Zone Industrielle Mghogha</option>
                                            <option value="0">Azib Haj Kaddour</option>
                                            <option value="0">Bel Air - Val fleuri</option>
                                            <option value="0">Bir Chairi</option>
                                            <option value="0">Branes 1</option>
                                            <option value="0">Branes 2</option>
                                            <option value="0">Casabarata</option>
                                            <option value="0">Castilla</option>
                                            <option value="0">Hay Al Bassatine</option>
                                            <option value="0">Hay El Boughaz</option>
                                            <option value="0">Hay Zaoudia</option>
                                            <option value="0">Lalla Chafia</option>
                                            <option value="0">Souani</option>
                                            <option value="1">Achakar</option>
                                            <option value="0">Administratif</option>
                                            <option value="0">Ahammar</option>
                                            <option value="0">Ain El Hayani</option>
                                            <option value="0">Algerie</option>
                                            <option value="0">Branes Kdima</option>
                                            <option value="0">Californie</option>
                                            <option value="0">Centre</option>
                                            <option value="0">De La Plage</option>
                                            <option value="1">Du Golf</option>
                                            <option value="0">Hay Hassani</option>
                                            <option value="0">Iberie</option>
                                            <option value="0">Jbel Kbir</option>
                                            <option value="0">Laaouina</option>
                                            <option value="0">Marchan</option>
                                            <option value="0">Mediouna</option>
                                            <option value="0">Mesnana</option>
                                            <option value="0">Mghayer</option>
                                            <option value="0">Mister Khouch</option>
                                            <option value="0">Mozart</option>
                                            <option value="0">Msala</option>
                                            <option value="0">Médina</option>
                                            <option value="0">Port Tanger ville</option>
                                            <option value="0">Rmilat</option>
                                            <option value="0">Star Hill</option>
                                            <option value="0">manar</option>
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


