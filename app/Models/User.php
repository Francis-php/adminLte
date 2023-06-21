<?php

namespace App\Models;


use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


/**
 * @property mixed $image
 * @property mixed $type
 * @property mixed $role
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'type',
        'image',
        'gender',
        'email_verified_at'
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
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'type');
    }
    public function getNameAttribute(): string
    {
        return $this->first_name.' '.$this->last_name;
    }
    public function images(): HasMany
    {
        return $this->hasMany(Media::class,'user_id');
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailNotification());
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class,'user_id');
    }

    public function bookings(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'bookings')
            ->withPivot([
            'cost',
            'tickets'
        ]);
    }

    public function scopeAgencies(Builder $query): Builder
    {
        return $query->where('type','=','3');
    }
}
