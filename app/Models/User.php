<?php

namespace App\Models;

use App\Enums\Global\StatusEnum;
use App\Services\UploadService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, HasRoles, SoftDeletes;

    public bool $inPermission = true;

    protected $fillable = ['name', 'email', 'phone', 'password', 'avatar', 'last_login'];

    protected $hidden = ['password', 'remember_token',];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
        'status' => StatusEnum::class,
    ];

    /*
     |--------------------------------------------------------------------------
     | Custom Attributes
     |--------------------------------------------------------------------------
    */
    public function avatar(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? UploadService::url($value) : null,
            set: fn($value) => !empty($value) ? UploadService::store($value, 'users') : $this->avatar
        );
    }

    public function password(): Attribute
    {
        return Attribute::make(
            set: fn($value) => !empty($value) ? Hash::make($value) : $this->password
        );
    }

    /*
     |--------------------------------------------------------------------------
     | Scope methods
     |--------------------------------------------------------------------------
    */
    public function scopeWithRole(Builder $query, string $role): Builder
    {
        return $query->whereHas('roles', function ($q) use ($role) {
            $q->where('name', $role);
        });
    }

    public function scopeExcludeAdmins(Builder $query): Builder
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('name', '!=', 'admin');
        });
    }

    /*
     |--------------------------------------------------------------------------
     | Helper methods
     |--------------------------------------------------------------------------
    */

         /**** write here helper methods ****/

    /*
     |--------------------------------------------------------------------------
     | Relations methods
     |--------------------------------------------------------------------------
    */

        /**** write here relations methods ****/

}
