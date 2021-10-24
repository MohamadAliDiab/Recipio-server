<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class recipe_has_likes extends Model
{
    protected $table = "recipe_has_likes";

    public function recipe()
    {
        return $this->belongsTo(recipes::class, 'recipe_id');
    }
    public function user()
    {
        return $this->belongsTo(user::class, 'user_id');
    }
}
