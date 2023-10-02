<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $table = "content";

    protected $fillable = ['description', 'value'];

    public $timestamps = false;

    // Relation hasOne with answers
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
