<?php

namespace App\Http\Controllers;

use App\Models\User;
use Error;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index() 
    {
        return view('settings.index');
    }

    public function update(Request $request) 
    {
        $user = auth()->user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'description' => $request->description
        ]);
        return $user;
    }
}
