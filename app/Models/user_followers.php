<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_followers extends Model
{
    protected $table = "user_followers";

    public function user()
    {
        return $this->belongsTo(user::class, 'user_id');
    }
    public function follower_id()
    {
        return $this->belongsTo(user::class, 'follower_id');
    }
}
