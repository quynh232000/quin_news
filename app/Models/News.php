<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $table = 'news';
    protected $fillable = [
        'slug',
        'title',
        'subtitle',
        'image',
        'content',
        'category_id',
        'user_id',
        'type',
        'status',
        'views',
        'is_delete',
        'is_show'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function is_saved()
    {
        if (auth()->check()) {
            return Saved::where(['user_id' => auth()->id(), 'news_id' => $this->id])->exists();
        }
        return false;
    }
    public function reactions_type($type = null)
    {
        if ($type) {
            return Reaction::where(['entity_id' => $this->id, 'type' => $type, 'from' => 'news'])->count();

        } else {
            return Reaction::where(['entity_id' => $this->id, 'from' => 'news'])->count();
        }
    }
    public function is_reaction($type = null)
    {
        if (!auth()->check()) {
            return false;
        }
        if (!$type) {
            return false;
        }
        return Reaction::where(['entity_id' => $this->id, 'type' => $type, 'from' => 'news'])->exists();

    }
    public function comments()
    {
        return $this->hasMany(Comments::class, 'entity_id')->with('user')->orderBy('created_at', 'desc')->limit(5);
    }
    public function reason_deny()
    {
        $reason = denynews::where('news_id', $this->id)->first();
        if ($reason) {
            $reason->bad_words_list = json_decode($reason->bad_words_list);

        }
        return $reason;

    }
}
