<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reception extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function produits(){
        return $this->BelongsToMany('App\Produit')->withPivot('qte');
    }


}
