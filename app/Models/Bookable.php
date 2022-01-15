<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static findOrFail($id)
 */
class Bookable extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function availableFor($from, $to): bool
    {
        return $this->bookings()->betweenDates($from, $to)->count() == 0;
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function priceFor($from, $to) : array{
        $days = (new Carbon($from))->diffInDays(new Carbon($to)) + 1;
        $price = $days * $this->price;

        return [
            'total' => $price,
            'breakdown' => [
                $this->price => $days
            ]
        ];
    }
}
