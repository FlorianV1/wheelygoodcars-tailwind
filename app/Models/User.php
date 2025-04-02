<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
        'password' => 'hashed',
    ];

    // Add these methods to your User model
    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function getSuspiciousAttribute()
    {
        $suspiciousFlags = [];

        // No phone number
        if (empty($this->phone)) {
            $suspiciousFlags[] = 'no_phone';
        }

        // Cars with high age but low mileage
        $suspiciousCars = $this->cars()->whereRaw('(? - production_year) > 10 AND mileage < 50000', [date('Y')])->count();
        if ($suspiciousCars > 0) {
            $suspiciousFlags[] = 'suspicious_mileage';
        }

        // More than 3 cars marked as sold on the same day with price > 10,000
        $soldToday = $this->cars()
            ->whereDate('sold_at', today())
            ->where('price', '>', 10000)
            ->count();
        if ($soldToday > 3) {
            $suspiciousFlags[] = 'money_laundering';
        }

        // Only cars with price < 1000
        $cheapCarsOnly = $this->cars()->count() > 0 &&
            $this->cars()->where('price', '>=', 1000)->count() === 0;
        if ($cheapCarsOnly) {
            $suspiciousFlags[] = 'too_cheap';
        }

        // No tags used
        $noTags = $this->cars()
                ->whereDoesntHave('tags')
                ->count() === $this->cars()->count();
        if ($noTags && $this->cars()->count() > 0) {
            $suspiciousFlags[] = 'no_tags';
        }

        // No new cars offered in a year
        $latestCar = $this->cars()->latest()->first();
        if ($latestCar && $latestCar->created_at->diffInDays(now()) > 365) {
            $suspiciousFlags[] = 'inactive';
        }

        return $suspiciousFlags;
    }
}
