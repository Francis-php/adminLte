<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable=[
        'title',
        'description',
        'price',
        'start_date',
        'tickets',
        'end_date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(Media::class, 'post_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'bookings')
            ->withPivot([
                'cost',
                'tickets'
            ]);
    }

    public function scopeTomorrowTrips(Builder $query): Builder
    {
        return $query->whereDate('start_date', now()->addDay());
    }
}
