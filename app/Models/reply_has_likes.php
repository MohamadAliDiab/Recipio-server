<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reply_has_likes extends Model
{
    protected $table = "reply_has_likes";

    public function comments()
    {
        return $this->belongsTo(comment_has_replies::class, 'reply_id');
    }
    public function user()
    {
        return $this->belongsTo(user::class, 'user_id');
    }
}
