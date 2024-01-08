<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function admins()
    {
        return $this->hasOne(Admin::class, 'user_id');
    }
    public function agences()
    {
        return $this->hasOne(Agence::class);
    }

    public function agents()
    {
        return $this->hasOne(Agent::class);
    }

    public function membres()
    {
        return $this->hasOne(Membre::class);
    }

    public function delegues()
    {
        return $this->hasOne(Delegue::class, 'user_id');
    }

    // Determination des roles de chaque utilisateur
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isDelegue()
    {
        return $this->role === 'delegue';
    }

    public function isAgent()
    {
        return $this->role === 'agent';
    }

    public function isMembre()
    {
        return $this->role === 'membre';
    }
}
