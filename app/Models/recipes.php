<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class recipes extends Model
{
    protected $table = "recipes";

    public function user()
    {
        return $this->belongsTo(user::class, 'posted_by');
    }
    public function comments()
    {
        return $this->hasMany(recipe_has_comment::class, 'recipe_id');
    }
    public function likes()
    {
        return $this->hasMany(recipe_has_likes::class, 'recipe_id');
    }
    public function tags()
    {
        return $this->hasMany(recipe_has_tags::class, 'recipe_id');
    }
}
