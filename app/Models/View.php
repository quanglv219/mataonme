<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;

    public $fillable = ['link_id', 'views'];

    public function link()
    {
        return $this->belongsTo(Link::class);
    }

    public function scopeWhereUser($query)
    {
        return $query->whereHas('link', function ($q) {
            $q->where('user_id', auth()->id());
        });
    }
}
