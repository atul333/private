<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPasswordNotification;
use App\Models\TelegramNotification;
use App\Models\Wallet;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function telegramNotification()
    {
        return $this->hasOne(TelegramNotification::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'telegram_username',
        'password',
        'role',
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

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function publisher()
    {
        return $this->hasOne(Publisher::class);
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }

    public function advertiser()
    {
        return $this->hasOne(Advertiser::class);
    }

    /**
     * Get the wallet associated with the user.
     */
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    /**
     * Get all Instagram profiles for the user (publisher).
     */
    public function instagramProfiles()
    {
        return $this->hasMany(InstagramProfile::class);
    }

    /**
     * Get all Instagram campaigns created by the user (advertiser).
     */
    public function instagramCampaigns()
    {
        return $this->hasMany(InstagramCampaign::class, 'advertiser_id');
    }
}
