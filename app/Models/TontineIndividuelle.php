<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TontineIndividuelle extends Model
{
    use HasFactory;

    protected $fillable = ['codeTontineI', 'nomTontineI', 'debuTontineI', 'montantTontineI', 'statutTontineI', 'membre', 'agent'];
    public function membres(){
        return $this->belongsTo(Membre::class,"membre");
    }

    public function agents(){
        return $this->belongsTo(Agent::class,"agent");
    }

    public function cotisations(){
        return $this->hasMany(Cotisation::class, 'tontine');
    }

    public function payementIndividuelles(){
        return $this->hasMany(PayementIndividuelle::class, 'tontine', 'id');

    }

   
}
