<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    use HasFactory;
    public function tontinesC(){
        return $this->belongsTo(TontineCollective::class, 'tontine');
    }

    public function membres(){
        return $this->belongsTo(Membre::class, 'membre');
    }
}
