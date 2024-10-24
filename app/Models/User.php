<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'avatar',
        'name',
        'email',
        'role',
        'email_verified_at',
        'password'
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
    ];
    public function news_count()
    {
        return News::where(['user_id' => $this->id, 'is_delete' => false, 'is_show' => true, 'status' => 'active'])->count();
    }
    public function is_followed()
    {
        if (auth()->check()) {
            return Follow::where(['from_user_id' => auth()->user()->id, 'to_user_id' => $this->id])->exists();

        } else {
            return false;
        }
    }
    public function followers_count()
    {
        return Follow::where('to_user_id', $this->id)->count();
    }
    public function followers()
    {
        return $this->hasMany(Follow::class, 'to_user_id');
    }
    public function followings()
    {
        if (auth()->check()) {
            $user_ids = Follow::where('from_user_id', auth()->user()->id)->pluck('to_user_id')->all();
            $users = User::whereIn('id', $user_ids)->get();
            return $users;
        }
        return [];
    }
    public function count_comments()
    {
        return Comments::where(['user_id' => $this->id])->count();
    }
}
