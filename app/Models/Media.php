<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'path',
        'hash_name',
        'original_name',
        'extension',
        'size',

    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
