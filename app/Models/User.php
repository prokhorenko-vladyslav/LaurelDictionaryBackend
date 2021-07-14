<?php

namespace App\Models;

use App\Traits\PaginationFromLimit;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 * @package App\Models
 * @property-read int $id ID of the user
 * @property string $name Name of the user
 * @property string $email Email of the user
 * @property string $password Password hash of the user
 * @property DailyDictionary[]|Collection $dailyDictionaries List of daily dictionaries for the user
 * @property DailyWord[]|Collection $dailyWords List of daily words from all daily dictionaries for the user
 * @property Setting[]|Collection $settings List of user settings
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    use PaginationFromLimit;

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
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    /**
     * @return HasMany
     */
    public function dailyDictionaries(): HasMany
    {
        return $this->hasMany(DailyDictionary::class);
    }

    /**
     * @return HasManyThrough
     */
    public function dailyWords(): HasManyThrough
    {
        return $this->hasManyThrough(DailyWord::class, DailyDictionary::class);
    }

    /**
     * @return HasMany
     */
    public function settings(): HasMany
    {
        return $this->hasMany(Setting::class);
    }

    public function checkSetting(string $alias, ?string $defaultValue = null)
    {
        $this->loadMissing('settings');
        $setting = $this->settings->where('alias', $alias)->first();
        return $setting ? $setting->value : $defaultValue;
    }

    /**
     * @return static
     */
    public static function current(): self
    {
        return Auth::user();
    }
}
