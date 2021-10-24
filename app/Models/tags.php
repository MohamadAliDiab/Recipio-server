<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tags extends Model
{
    protected $table = "tags";

    public function recipes()
    {
        return $this->hasMany(recipe_has_tags::class, 'tag_id');
    }
}
