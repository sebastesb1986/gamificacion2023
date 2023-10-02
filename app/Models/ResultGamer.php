<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultGamer extends Model
{
    use HasFactory;

    protected $table = "resultGamers";

    protected $fillable = ['value', 'gamer_id', 'category_id'];

    public $timestamps = false;

    // Relation with gamers
    public function gamer()
    {
        return $this->belongsTo(Gamer::class);
    }
}
