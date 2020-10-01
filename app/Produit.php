<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }
}
