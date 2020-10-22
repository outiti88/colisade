@extends('racine')

@section('title')
{{$produit->libelle}} | {{$produit->reference}}
@endsection

@section('style')
<style class="cp-pen-styles">
    
 
    
    .box {
      display: block;
      min-width: 300px;
      height: 300px;
      margin: 10px;
      background-color: white;
      border-radius: 5px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
      -webkit-transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
      transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
      overflow: hidden;
    }
    
    .upload-options {
      position: relative;
      height: 75px;
      background-color: #e95f04;
      cursor: pointer;
      overflow: hidden;
      text-align: center;
      -webkit-transition: background-color ease-in-out 150ms;
      transition: background-color ease-in-out 150ms;
    }
    .upload-options:hover {
      background-color: #b64a02;
    }
    .upload-options input {
      width: 0.1px;
      height: 0.1px;
      opacity: 0;
      overflow: hidden;
      position: absolute;
      z-index: -1;
    }
    .upload-options label {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
          -ms-flex-align: center;
              align-items: center;
      width: 100%;
      height: 100%;
      font-weight: 400;
      text-overflow: ellipsis;
      white-space: nowrap;
      cursor: pointer;
      overflow: hidden;
    }
    .upload-options label::after {
      content: 'Modifier';
      position: absolute;
      font-size: 2.5rem;
      color: #e6e6e6;
      top: calc(50% - 2.3rem);
    left: calc(50% - 4.25rem);
      z-index: 0;
    }
    .upload-options label span {
      display: inline-block;
      width: 50%;
      height: 100%;
      text-overflow: ellipsis;
      white-space: nowrap;
      overflow: hidden;
      vertical-align: middle;
      text-align: center;
    }
    .upload-options label span:hover i.material-icons {
      color: lightgray;
    }
    
    .js--image-preview {
      height: 225px;
      width: 100%;
      position: relative;
      overflow: hidden;
      background-image: url("");
      background-color: white;
      background-position: center center;
      background-repeat: no-repeat;
      background-size: cover;
    }
    .js--image-preview::after {
      font-family: 'Material Icons';
      position: relative;
      font-size: 4.5em;
      color: #e6e6e6;
      top: calc(50% - 3rem);
      left: calc(50% - 2.25rem);
      z-index: 0;
    }
    .js--image-preview.js--no-default::after {
      display: none;
    }
    
    i.material-icons {
      -webkit-transition: color 100ms ease-in-out;
      transition: color 100ms ease-in-out;
      font-size: 2.25em;
      line-height: 55px;
      color: white;
      display: block;
    }
    
    .drop {
      display: block;
      position: absolute;
      background: rgba(95, 158, 160, 0.2);
      border-radius: 100%;
      -webkit-transform: scale(0);
              transform: scale(0);
    }
    
    .animate {
      -webkit-animation: ripple 0.4s linear;
              animation: ripple 0.4s linear;
    }
    
    @-webkit-keyframes ripple {
      100% {
        opacity: 0;
        -webkit-transform: scale(2.5);
                transform: scale(2.5);
      }
    }
    
    @keyframes ripple {
      100% {
        opacity: 0;
        -webkit-transform: scale(2.5);
                transform: scale(2.5);
      }
    }
    </style>
@endsection

@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-5">
        <h4 class="page-title">Gestion du produit {{$produit->reference}}</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Quickoo</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="/produit">Stock</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$produit->libelle}}</li>

                    </ol>
                </nav>
            </div>
        </div>
  
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->


<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    <!-- ============================================================== -->
    <div class="row">
           
        @if (session()->has('produit'))
        <div class="alert alert-dismissible alert-success col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Succés !</strong> Ce produit à été bien Modifié </a>.
          </div>
        @endif
    </div>    <!-- ============================================================== -->
    <!-- Row -->
    <div class="row">
        
        <!-- Column -->
        <div class="col-lg-4 col-xlg-3 col-md-5">
            <div class="card">
                <div class="card-body">
                <center class="m-t-30">
                    <div class="box">
                        <div class="js--image-preview">
                           <img class="photo_produit" src="/uploads/produit/{{$produit->photo}}" alt="" width="250" height="250">
                            </div>
                        <div class="upload-options">
                          <label>
                            <input type="file" class="image-upload" accept="image/*" />
                          </label>
                        </div>
                      </div>
                    
                        <h4 class="card-title m-t-10">{{$produit->libelle}}</h4>
                        <h6 class="card-subtitle">{{$produit->description}}</h6>
                        <div class="row text-center justify-content-md-center">
                        <div class="col-4"><a href="{{route('commandes.index')}}" class="link"><i class="icon-people"></i> <font class="font-medium">0 <br>En Stock</font></a></div>
                            <div class="col-4"><a href="{{route('facture.index')}}" class="link"><i class="icon-picture"></i> <font class="font-medium">0<br>En commande</font></a></div>
                        </div>
                    </center>
                </div>
                <div>
                    <hr> </div>
                <div class="card-body"> 
                    <h3>Mouvement du stock</h3>
                    <small class="text-muted">Addresse email </small>
                    <h6>test test</h6> <small class="text-muted p-t-30 db">Téléphone</small>
                    <h6>test test</h6> <small class="text-muted p-t-30 db">Addresse</small>
                    <h6>test test</h6>
                    </div>
            </div>
        </div>
        <!-- Column -->
        <!-- Column -->
        <div class="col-lg-8 col-xlg-9 col-md-7">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal form-material" method="POST" action="{{route('produit.update',$produit)}}">
                        @csrf
                        @method("PUT")
                        <div class="form-group">
                            <label for="libelle" class="col-md-12">Libelle: </label>

                        <div class="col-md-12">
                            <input id="libelle" type="text" class="form-control @error('libelle') is-invalid @enderror" name="libelle" value="{{ $produit->libelle }}" required  autofocus>

                            @error('libelle')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-12">Prix de produit</label>
                            <div class="col-md-12">
                            <input name="prix" type="text" value="{{$produit->prix}}" class="form-control form-control-line">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Description</label>
                            <div class="col-md-12">
                            <textarea name="description" rows="5" class="form-control form-control-line">{{$produit->description}}</textarea>
                            </div>
                        </div>
                     
                        <div class="form-group">
                            <label class="col-sm-12">Catégorie :</label>
                            <div class="col-sm-12">
                                <select name="categorie" value="{{$produit->categorie}}" class="form-control form-control-line" >
                                    <option checked>{{$produit->categorie}}</option>
                                    <option >Vêtements</option>
                                    <option >Chaussures</option>
                                    <option >Bijoux et accessoires</option>
                                    <option >Produits Cosmétiques</option>
                                    <option >Produits High Tech</option>
                                    <option >Librairie</option>
                                    <option >Maroquinerie</option>
                                    <option >Végétaux</option>
                                    <option >Autres</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-success">Modifier</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>

</div>
@endsection

@section('javascript')
<script src='//production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'></script>
<script >function initImageUpload(box) {
  let uploadField = box.querySelector('.image-upload');

  uploadField.addEventListener('change', getFile);

  function getFile(e){
    let file = e.currentTarget.files[0];
    checkType(file);
  }
  
  function previewImage(file){
    
    let thumb = box.querySelector('.photo_produit'),
        reader = new FileReader();

    reader.onload = function() {
      thumb.src = reader.result;
    }
    reader.readAsDataURL(file);
    thumb.className += ' js--no-default';
  }

  function checkType(file){
    let imageType = /image.*/;
    if (!file.type.match(imageType)) {
      throw 'Datei ist kein Bild';
    } else if (!file){
      throw 'Kein Bild gewählt';
    } else {
      previewImage(file);
    }
  }
  
}

// initialize box-scope
var boxes = document.querySelectorAll('.box');

for(let i = 0; i < boxes.length; i++) {if (window.CP.shouldStopExecution(1)){break;}
  let box = boxes[i];
  initDropEffect(box);
  initImageUpload(box);
}
window.CP.exitedLoop(1);




/// drop-effect
function initDropEffect(box){
  let area, drop, areaWidth, areaHeight, maxDistance, dropWidth, dropHeight, x, y;
  
  // get clickable area for drop effect
  area = box.querySelector('.js--image-preview');
  area.addEventListener('click', fireRipple);
  
  function fireRipple(e){
    area = e.currentTarget
    // create drop
    if(!drop){
      drop = document.createElement('span');
      drop.className = 'drop';
      this.appendChild(drop);
    }
    // reset animate class
    drop.className = 'drop';
    
    // calculate dimensions of area (longest side)
    areaWidth = getComputedStyle(this, null).getPropertyValue("width");
    areaHeight = getComputedStyle(this, null).getPropertyValue("height");
    maxDistance = Math.max(parseInt(areaWidth, 10), parseInt(areaHeight, 10));

    // set drop dimensions to fill area
    drop.style.width = maxDistance + 'px';
    drop.style.height = maxDistance + 'px';
    
    // calculate dimensions of drop
    dropWidth = getComputedStyle(this, null).getPropertyValue("width");
    dropHeight = getComputedStyle(this, null).getPropertyValue("height");
    
    // calculate relative coordinates of click
    // logic: click coordinates relative to page - parent's position relative to page - half of self height/width to make it controllable from the center
    x = e.pageX - this.offsetLeft - (parseInt(dropWidth, 10)/2);
    y = e.pageY - this.offsetTop - (parseInt(dropHeight, 10)/2) - 30;
    
    // position drop and animate
    drop.style.top = y + 'px';
    drop.style.left = x + 'px';
    drop.className += ' animate';
    e.stopPropagation();
    
  }
}

//# sourceURL=pen.js
</script>
@endsection