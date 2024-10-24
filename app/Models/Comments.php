<?php

namespace App\Models;

use Egulias\EmailValidator\Parser\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $fillable = [
        'comment',
        'type',
        'user_id',
        'entity_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function likes()
    {
        return Reaction::where(['entity_id' => $this->id, 'from' => 'comment'])->count();

    }
    public function parent_comment()
    {
        return Comments::where(['id' => $this->entity_id])->first();
    }
    public function news()
    {
        $parent_comment = $this->parent_comment();
        while ($parent_comment->type == 'reply') {
            $parent_comment = $parent_comment->parent_comment();
        }
        return News::where(['id' => $parent_comment->entity_id])->first();
    }
    public function is_like()
    {
        if (auth()->check()) {
            return Reaction::where(['entity_id' => $this->id, 'user_id' => auth()->id(), 'from' => 'comment'])->exists();

        }
        return false;
    }
    public function replies()
    {
        return Comments::where(['entity_id' => $this->id, 'type' => 'reply'])->paginate(10);
    }
    public function replies_count()
    {
        return Comments::where(['entity_id' => $this->id, 'type' => 'reply'])->count();
    }
    

}
