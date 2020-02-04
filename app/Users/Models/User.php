<?php

namespace App\Users\Models;

use App\Models\Helpers;
use App\Users\OwnsProjects;
use App\Contracts\ProjectOwner;
use Laravel\Airlock\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements ProjectOwner
{
    use Notifiable, HasApiTokens, Helpers, OwnsProjects;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
