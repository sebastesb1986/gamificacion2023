<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = "profile";

    protected $fillable = ['name', 'lastname', 'birthdate', 'age', 'user_id'];

    public $timestamps = false;

    // Relation hasOne with users
    public function users()
    {
        return $this->belongsTo(User::class);
    }

}
