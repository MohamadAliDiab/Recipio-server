<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class blocked extends Model {
    protected $table = "blocked";

    public function user()
    {
        return $this->belongsTo(user::class, 'user_id');
    }
    public function blocked_user()
    {
        return $this->belongsTo(user::class, 'blocked_user_id');
    }
}

?>