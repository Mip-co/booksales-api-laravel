<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'last_access',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password'    => 'hashed',
            'last_access' => 'datetime',
        ];
    }

    // Identitas user yang disimpan di dalam token JWT
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // Data tambahan (klaim) di payload token
    public function getJWTCustomClaims()
    {
        return [
            'role' => $this->role,
        ];
    }
}