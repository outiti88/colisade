<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caisse extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }
}
