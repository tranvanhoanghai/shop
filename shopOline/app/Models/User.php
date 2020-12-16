<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable. 
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'email', 'password','id_user_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles(){
        return $this->belongsToMany(Role::class, 'role_users') ;
    }

    public function hasAccess(array $permissions)
    {
        foreach ($this->roles as $role) {
            
            if($role->hasAccess($permissions)){
                return true;
            }
            return false;
        }
    }
}
