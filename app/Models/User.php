<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getFullNameAttribute(){
        return implode(' ', [$this->first_name, $this->last_name]);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function recipes()
    {
        return $this->hasMany(recipes::class, 'user_id');
    }
    public function followers()
    {
        return $this->hasMany(user_followers::class, 'user_id');
    }
    public function follower_user()
    {
        return $this->hasMany(user_followers::class, 'follower_id');
    }
    public function blocking_user()
    {
        return $this->hasMany(blocked::class, 'user_id');
    }
    public function blocked_user()
    {
        return $this->hasMany(blocked::class, 'blocked_user_id');
    }
    public function comments()
    {
        return $this->hasMany(comments::class, 'posted_by');
    }
    public function recipe_likes()
    {
        return $this->hasMany(recipe_has_likes::class, 'user_id');
    }
    public function comment_likes()
    {
        return $this->hasMany(comment_has_likes::class, 'user_id');
    }
    public function replies()
    {
        return $this->hasMany(comment_has_replies::class, 'user_id');
    }
    public function replie_likes()
    {
        return $this->hasMany(reply_has_likes::class, 'user_id');
    }
    public function requested_user()
    {
        return $this->hasMany(follow_request::class, 'user_id');
    }
    public function follow_requester()
    {
        return $this->hasMany(follow_request::class, 'follower_id');
    }
}
