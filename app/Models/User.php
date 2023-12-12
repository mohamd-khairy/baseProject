<?php

namespace App\Models;

use App\Enums\Global\StatusEnum;
use App\Notifications\Auth\PasswordReset;
use App\Services\UploadService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail, Auditable
{
    use HasApiTokens, Notifiable, HasRoles, SoftDeletes;

    use \OwenIt\Auditing\Auditable;

    protected $auditInclude = [];

    public bool $inPermission = true;

    protected $fillable = ['name', 'email', 'phone', 'password', 'avatar', 'otp', 'last_login'];

    protected $hidden = ['password', 'remember_token', 'otp'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
        'status' => StatusEnum::class,
        'password' => 'hashed',
    ];

    /*
     |--------------------------------------------------------------------------
     | Custom Attributes
     |--------------------------------------------------------------------------
    */
    public function avatar(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? UploadService::url($value) : null,
            set: fn ($value) => !empty($value) ? UploadService::store($value, 'users') : $this->avatar
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

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /*
     |--------------------------------------------------------------------------
     | Helper methods
     |--------------------------------------------------------------------------
    */

    public function hasVerifiedEmail(): bool
    {
        return !is_null($this->email_verified_at);
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new PasswordReset($token));
    }

    /*
     |--------------------------------------------------------------------------
     | Relations methods
     |--------------------------------------------------------------------------
    */

    /**** write here relations methods ****/
}
