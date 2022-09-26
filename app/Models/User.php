<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public $timestamps = false;

    protected $fillable = [
        'login',
        'mdp',
        'nom',
        'prenom'
    ];

    protected $hidden = [
        'mdp',
    ];

    protected $attributes = [
        'type' => 'client'
    ];

    public function getAuthPassword() {
        return $this->mdp;
    }
}
