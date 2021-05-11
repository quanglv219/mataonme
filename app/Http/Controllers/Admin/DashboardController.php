<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::where('is_admin', false)->get();
        $clicks = DB::table('clicks')->sum('clicks');
        // $views = DB::table('views')->sum('views');
        return view('admin.dashboard', [
            'users' => $users,
            'clicks' => $clicks
        ]);
    }

    public function settings()
    {
        $settings = Website::first();
        return view('admin.settings.index', ['settings' => $settings]);
    }

    public function update(Request $request)
    {
        $website = Website::first();
        if (!empty($website)) {
            $website->update($request->only(['name', 'description', 'keywords', 'logo']));
        } else {
            $website = new Website();
            $website->create($request->only(['name', 'description', 'keywords', 'logo']))->save();
        }
        return back()->with(['response' => 'Settings updated successfully.']);
    }
}
