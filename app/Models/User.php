<?php

namespace App\Models;

use App\Enums\Global\StatusEnum;
use App\Notifications\Auth\PasswordReset;
use App\Services\UploadService;
use App\Traits\SearchableTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as IAuditable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail, IAuditable
{
    use HasApiTokens, Notifiable, HasRoles, SoftDeletes, Auditable, SearchableTrait;

    protected array $auditInclude = [];

    public bool $inPermission = true;

    protected $fillable = ['name', 'email', 'phone', 'password', 'avatar', 'otp', 'last_login'];

    protected $hidden = ['password', 'remember_token', 'otp'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
        'status' => StatusEnum::class,
        'password' => 'hashed',
    ];

    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'users.name' => 10,
            'users.phone' => 10,
            'users.email' => 5,
            'model_has_roles.role_id' => 20,
            'roles.name' => 50
            // 'posts.title' => 2,
            // 'posts.body' => 1,
        ],
        'joins' => [
            // 'posts' => ['users.id','posts.user_id'],
            'model_has_roles' => ['users.id', 'model_has_roles.model_id'],
            'roles' => ['roles.id', 'model_has_roles.role_id'],
        ],
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

    public function scopeExcludeLoggedInUser(Builder $query): Builder
    {
        return $query->where('id', '!=', auth()->id());
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
    public function hasVerifiedEmail(): bool
    {
        return !is_null($this->email_verified_at);
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new PasswordReset($token));
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /*
     |--------------------------------------------------------------------------
     | Relations methods
     |--------------------------------------------------------------------------
    */
}
