<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membre extends Model
{
    use HasFactory;


    public function tontinesI(){
        return $this->hasMany(TontineIndividuelle::class);
    }

    public function cotisations(){
        return $this->hasMany(Cotisation::class);
    }

    public function payementIndividuelle(){
        return $this->hasMany(PayementIndividuelle::class);
    }
    // Relation avec la table pivot 'versements' via TontineCollective
    public function tontinesVersements()
    {
        return $this->belongsToMany(TontineCollective::class, 'versements', 'membre', 'tontine')
            ->withPivot('codeVersement', 'montantVersement', 'dateVersement');
    }

    // Relation avec la table pivot 'payements' via TontineCollective
    public function tontinesPayements()
    {
        return $this->belongsToMany(TontineCollective::class, 'payement_collectives', 'membre', 'tontine')
            ->withPivot('codePayementC', 'montantPayementC', 'datePayementC');
    }

    // Relation avec la table pivot 'participations' via TontineCollective
    public function tontinesParticipations()
    {
        return $this->belongsToMany(TontineCollective::class, 'participations', 'membre', 'tontine');

    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
