<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delegue extends Model
{
    use HasFactory;

    public function agences()
    {
        return $this->belongsTo(Agence::class, 'agence_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
