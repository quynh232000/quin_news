<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;
    protected $table = 'reactions';
    protected $fillable = [
        'user_id',
        'type',
        'entity_id',
        'from',
    ];
}
