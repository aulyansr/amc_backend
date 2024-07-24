<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

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
    ];

    public static function singleUser($id, $value = 'name')
    {
        $user = self::find($id);
        if(!$user) {
            return null;
        }
        return $user->$value;
    }

    public static function userByRole($roleName = [])
    {
        return self::whereHas('roles', static function($query) use ($roleName) {
            return $query->whereIn('name', $roleName);
        })->get();
    }

    public static function userRoleNames($roleName = [])
    {
        return self::whereHas('roles', static function($query) use ($roleName) {
            return $query->whereIn('name', $roleName);
        })->get();
    }
}
