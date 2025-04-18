<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'license_plate',
        'brand',
        'model',
        'price',
        'mileage',
        'seats',
        'doors',
        'production_year',
        'weight',
        'color',
        'image',
        'sold_at',
    ];

    protected $casts = [
        'sold_at' => 'datetime',
    ];

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'car_user')->withTimestamps();
    }

    public function isFavoritedBy($user)
    {
        return $this->favoritedBy()->where('user_id', $user->id)->exists();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopeUnsold($query)
    {
        return $query->whereNull('sold_at');
    }

    public function isSold()
    {
        return !is_null($this->sold_at);
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}
