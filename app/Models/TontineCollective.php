<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TontineCollective extends Model
{
    use HasFactory;
    public function agents(){
        return $this->belongsTo(Agent::class, 'agent');
    }

      // Relation avec la table pivot 'versements'
      public function membresVersements(){
        return $this->belongsToMany(Membre::class, 'versements', 'tontine', 'membre')
            ->withPivot('codeVersement', 'montantVersement', 'dateVersement');
    }

    // Relation avec la table pivot 'payements'
    public function membresPayements(){
        return $this->belongsToMany(Membre::class, 'payement_collectives', 'tontine', 'membre')
            ->withPivot('codePayementC', 'montantPayementC', 'datePayementC');
    }

    // Relation avec la table pivot 'participations'
    public function membresParticipations(){
        return $this->belongsToMany(Membre::class, 'participations', 'tontine', 'membre');

    }
}
