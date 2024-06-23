<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'usertype',
        'pgp_public_key',
        'pgp_verified_at',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            // Delete all associated messages
            $user->sentMessages()->delete();
            $user->receivedMessages()->delete();

            // Delete all associated posts and comments
            $user->posts()->delete();
            $user->comments()->delete();

            // Delete all associated keys
            $user->keys()->delete();
        });
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'recipient_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function isType(string $type)
    {
        return $this->usertype === $type;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function keys()
    {
        return $this->hasOne(UserKey::class);
    }
}
