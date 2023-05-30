<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static find(int $int)
 */
class Role extends Model
{
    protected $table='role';

    protected $fillable=[
        'id',
        'type'
    ];
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'type');
    }

}
