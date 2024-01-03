<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;
    protected $fillable = ['nomAgent', 'prenomAgent', 'adresseAgent', 'telAgent', 'mailAgent', 'dateAdhesion', 'agence'];
    public function agences()
    {
        return $this->belongsTo(Agence::class, 'Agence');
    }

    public function tontines(){
        return $this->hasMany(TontineCollective::class,'agent');
    }

    public function tontinesI(){
        return $this->hasMany(TontineIndividuelle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
