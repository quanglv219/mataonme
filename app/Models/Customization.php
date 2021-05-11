<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customization extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'fontSize', 
        'fontWeight', 
        'fontColor', 
        'fontColorHover', 
        'pageBackground', 
        'buttonBackground', 
        'buttonBackgroundHover', 
        'buttonBorderSize', 
        'buttonBorderSizeHover', 
        'buttonBorder', 
        'buttonBorderHover',
        'borderRadius',
        'iconColor'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
