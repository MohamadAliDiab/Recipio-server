<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class follow_request extends Model
{
    protected $table = "follow_request";

    public function user()
    {
        return $this->belongsTo(user::class, 'user_id');
    }
    public function follower()
    {
        return $this->belongsTo(user::class, 'follower_id');
    }
}
