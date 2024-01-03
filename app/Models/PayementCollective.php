<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayementCollective extends Model
{
    use HasFactory;

    public function tontines()
    {
        return $this->belongsTo(TontineCollective::class, 'tontine');
    }

    public function membres()
    {
        return $this->belongsTo(Membre::class,'membre');
    }
}
