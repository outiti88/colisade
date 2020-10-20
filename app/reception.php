<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reception extends Model
{
    public function produit(){
        return $this->belongsTo('App\Produit');
    }
}
