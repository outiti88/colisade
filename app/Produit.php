<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function stock(){
        return $this->hasOne('App\Stock');
    }

    public function commandes(){
        return $this->BelongsToMany('App\Commande');
    }

    public function receptions(){
        return $this->BelongsToMany('App\Reception');
    }
      public function mouvements(){
        return $this->hasMany('App\Mouvement');
    }
}
