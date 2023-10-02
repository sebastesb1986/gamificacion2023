<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = "question";

    protected $fillable = ['description', 'category_id', 'user_id'];

    public $timestamps = false;

    // Relation hasMany with category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Relation hasOne with user
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    // Relation hasMany with answers
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
