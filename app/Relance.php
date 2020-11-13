<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relance extends Model
{
    public function commande(){
        return $this->belongsTo('App\Commande');
    }
    
    public function user(){
        return $this->belongsTo('App\User');
    }
}
