<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gamer extends Model
{
    use HasFactory;

    protected $table = "gamers";

    protected $fillable = ['name', 'grade', 'section', 'date'];

    public $timestamps = false;

    // Relation with answer
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    // Relation with resultGamers
    public function resultGamer()
    {
        return $this->hasMany(ResultGamer::class);
    }
}
