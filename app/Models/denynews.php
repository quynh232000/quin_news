<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class denynews extends Model
{
    use HasFactory;
    protected $table = 'deny_news';
    protected $fillable = [
        'news_id',
        'bad_words_list',
        'bad_words_total'
    ];
}
