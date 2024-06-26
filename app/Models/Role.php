<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static find(int $int)
 */
class Role extends Model
{

    use HasFactory;

    protected $table = 'role';

    public $timestamps = false;
    protected $fillable = [
        'type'
    ];
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'type');
    }

}
