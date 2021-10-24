<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class recipe_has_tags extends Model
{
    protected $table = "recipe_has_tags";

    public function recipe()
    {
        return $this->belongsTo(recipes::class, 'recipe_id');
    }
    public function tags()
    {
        return $this->belongsTo(tags::class, 'tag_id');
    }
}
