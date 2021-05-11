<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    public $fillable = ['user_id', 'name', 'link', 'is_active', 'order'];

    public function user() 
    {
        return $this->belongsTo('App\Models\User');
    }

    public function click()
    {
        return $this->hasMany(Click::class);
    }

    public function view()
    {
        return $this->hasMany(View::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($link) {
            $link->click()->delete();
            $link->view()->delete();
        });
    }
}
