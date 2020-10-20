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

    public function receptions()
    {
        return $this->hasMany('App\Reception');
    }

      public function mouvements(){
        return $this->hasMany('App\Mouvement');
    }
}
