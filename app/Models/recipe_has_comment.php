<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class recipe_has_comment extends Model
{
    protected $table = "recipe_has_comment";

    public function recipe()
    {
        return $this->belongsTo(recipes::class, 'recipe_id');
    }
    public function comment()
    {
        return $this->belongsTo(comments::class, 'comment_id');
    }
}
