<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = "categories";

    protected $fillable = ['name', 'description'];

    // Relation inverse hasMany with Question
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    // Relation with resultGamers
    public function resultGamer()
    {
        return $this->hasMany(ResultGamer::class);
    }

}
