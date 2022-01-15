<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static findOrFail($id)
 */
class Review extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'content', 'rating'];

    public function getIncrementing(): bool
    {
        return false;
    }

    public function getKeyType(): string
    {
        return 'string';
    }

    public function bookable(): BelongsTo
    {
        return $this->belongsTo(Bookable::class);
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

}
