<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comment_has_likes extends Model
{
    protected $table = "comment_has_likes";

    public function user()
    {
        return $this->belongsTo(user::class, 'user_id');
    }

    public function comment()
    {
        return $this->belongsTo(user::class, 'comment_id');
    }
}
