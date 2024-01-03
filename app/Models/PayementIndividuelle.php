<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayementIndividuelle extends Model
{
    use HasFactory;

    public function tontines(){
        return $this->belongsTo(TontineIndividuelle::class);
    }

    public function membres(){
        return $this->belongsTo(Membre::class);
    }
}
