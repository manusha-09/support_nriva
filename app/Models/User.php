<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
   protected $table='users';
    use HasApiTokens, Notifiable;

    public function isSupportAdmin()
    {
        return $this->exists && $this->getConnection()->table('role_users as membership')
            ->join('roles as role', 'role.id', '=', 'membership.role_id')
            ->where('membership.user_id', $this->getKey())
            ->where('role.slug', 'admin')
            ->exists();
    }

    public function getNameAttribute()
    {
        return trim(($this->attributes['first_name'] ?? '').' '.($this->attributes['last_name'] ?? '')) ?: $this->email;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Role','name',
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
}
