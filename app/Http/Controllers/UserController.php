<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function update(Request $request) 
    {
        $file = $request->photo;
        // Name the file
        $name = Str::random(20) . uniqid('', true) . Str::random(20) . '.' . $request->photo->extension();
        // Upload the file
        $path = Storage::putFileAs('public/profiles', $file, $name);
        // Update the profile image of the authenticated user
        auth()->user()->update(['photo' => 'storage/profiles/' . $name]);
        return auth()->user();
    }
}
