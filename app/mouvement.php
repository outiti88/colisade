<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mouvement extends Model
{
    public function produit(){
        return $this->belongsTo('App\Produit');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
}
