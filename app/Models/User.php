<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'photo',
        'username',
        'password',
        'is_admin',
        'description',
        'is_subscribed'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function social()
    {
        return $this->hasOne('App\Models\SocialMediaLink');
    }

    public function links()
    {
        return $this->hasMany('App\Models\Link');
    }

    public function customization()
    {
        return $this->hasOne(Customization::class);
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($user) {
            $user->social()->delete();
            $user->customization()->delete();
            
            // Delete all the clicks
            Click::with('link')->whereHas('link', function ($query) use($user) {
                return $query->where('user_id', $user->id);
            })->delete();
            // Delete all the views
            View::with('link')->whereHas('link', function ($query) use($user) {
                return $query->where('user_id', $user->id);
            })->delete();

            $user->links()->delete();
        });
    }
}
