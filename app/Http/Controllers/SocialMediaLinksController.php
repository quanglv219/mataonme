<?php

namespace App\Http\Controllers;

use App\Models\SocialMediaLink;
use Illuminate\Http\Request;

class SocialMediaLinksController extends Controller
{
    public function update(Request $request)
    {
        $links = SocialMediaLink::where('user_id', auth()->id())->first();
        $links->fill($request->all())->save();
        return $links;
    }
}
