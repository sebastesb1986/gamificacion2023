<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'admin',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Encriptar contraseña 
    public function setPasswordAttribute($password)
    {   
        
        if(!empty($password)){

            if (Hash::needsRehash($password)) {

                $this->attributes['password'] = Hash::make($password);

            }

            else {

                $this->attributes['password'] = $password;

            }
            
        }
        
    }

    // Relation hasOne with Profile
    public function profile(){
        
        return $this->hasOne(Profile::class);
      
    }

    // Relation hasMany with Question
    public function questions(){
        
        return $this->hasMany(Question::class);
      
    }

    // Relation hasMany with answers
    public function answers(){
        
        return $this->hasMany(Answer::class);
      
    }
}
