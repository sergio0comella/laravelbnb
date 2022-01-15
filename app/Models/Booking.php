<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['from', 'to'];

    public function bookable(): BelongsTo
    {
        return $this->belongsTo(Bookable::class);
    }

    public function address(){
        return $this->belongsTo(Address::class);
    }

    public function scopeBetweenDates(Builder $query, $from, $to): Builder
    {
        return $query
            ->where('to', '>=', $from)
            ->where('from', '<=', $to);
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    public static function findByReviewKey(string $reviewKey): ?Booking
    {
        return static::where('review_key', $reviewKey)->with('bookable')->get()->first();
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($booking) {
            $booking->review_key = Str::uuid();
        });
    }
}
