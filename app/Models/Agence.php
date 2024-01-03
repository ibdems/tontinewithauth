<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agence extends Model
{
    use HasFactory;
    protected $fillable = ['codeAgence', 'nomAgence', 'adresseAgence', 'telAgence', 'mailAgence'];
    public function agents(){
        return $this->hasMany(Agent::class);
    }

    public function delegues()
    {
        return $this->hasMany(Delegue::class);
    }
}
