<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'device_token',
        'full_name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'deleted_at',
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    public function settings()
    {
        return $this->hasMany(UserSetting::class) ?? 0;
    }

    public function getSetting($key)
    {
        return $this->settings()->where('key', $key)->first()?->value ?? __('locale.None');
    }

    public function sale()
    {
        return $this->hasMany(Sale::class);
    }

    public function purchase()
    {
        return $this->hasMany(Purchase::class);
    }
}
