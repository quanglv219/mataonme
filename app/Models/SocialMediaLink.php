<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMediaLink extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id', 
        'facebook', 
        'twitter', 
        'instagram', 
        'youtube', 
        'linkedin', 
        'twitch', 
        'telegram'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
