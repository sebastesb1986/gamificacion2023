<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    
    protected $table = "answer";

    protected $fillable = ['question_id', 'content_id', 'gamer_id'];

    public $timestamps = false;

    // Relation with survey
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    // Relation with content
    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    // Relation with gamers
    public function gamer()
    {
        return $this->belongsTo(Gamer::class);
    }

}
