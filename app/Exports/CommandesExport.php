<?php

namespace App\Exports;

use App\Commande;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Concerns\FromCollection;

class CommandesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if(!Gate::denies('manage-users'))
        return Commande::all()->where('deleted_at',NULL);
        else
        return Commande::all()->where('deleted_at',NULL)->where('user_id',Auth::user()->id );
    }
}
