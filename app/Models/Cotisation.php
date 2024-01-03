<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotisation extends Model
{
    use HasFactory;

    protected $fillable = ['codeCotisation', 'montantCotisation', 'dateCotisation', 'tontine', 'membre'];
    public function membres(){
        return $this->belongsTo(Membre::class, 'membre');
    }

    public function tontines(){
        return $this->belongsTo(TontineIndividuelle::class,'tontine');
    }
}
