<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 * @package App\Models
 * @property-read int $id ID of the user
 * @property string $name Name of the user
 * @property string $email Email of the user
 * @property string $password Password hash of the user
 * @property LearnedWord[]|Collection $learnedWords List of learned words for the user
 * @property Setting[]|Collection $settings List of user settings
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return HasMany
     */
    public function settings(): HasMany
    {
        return $this->hasMany(Setting::class);
    }

    public function checkSetting(string $alias, ?string $defaultValue = null)
    {
        $this->load('settings');
        $setting = $this->settings->where('alias', $alias)->first();
        return $setting ? $setting->value : $defaultValue;
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|self
     */
    public static function current(): \Illuminate\Contracts\Auth\Authenticatable
    {
        return Auth::user();
    }

    public function learnedWords(): HasMany
    {
        return $this->hasMany(LearnedWord::class);
    }

    public function makeAppToken(): \Laravel\Passport\PersonalAccessTokenResult
    {
        return $this->createToken( config('app.name') );
    }
}
