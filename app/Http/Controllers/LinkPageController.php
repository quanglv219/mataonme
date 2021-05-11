<?php

namespace App\Http\Controllers;

use App\Models\Click;
use App\Models\Link;
use App\Models\User;
use App\Models\View;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LinkPageController extends Controller
{
    public function show($username)
    {
        $user = User::with(['social', 'links', 'customization'])->where('username', $username)->first();
        abort_if(!$user, 404);
        abort_if(!$user->email_verified_at, 403, 'You have to verify your email in order to see this page.');
        return view('link', compact('user'));
    }

    public function filter(Request $request)
    {
        if ($request->from == "undefined" AND $request->to == "undefined") {
            $links = Click::where('link_id', $request->link_id)->get();
            return count($links);
        }
        if ($request->has('link_id') AND $request->has('from') AND $request->has('to')) {
            $from = Carbon::parse($request->from)->toDateString();
            $to = Carbon::parse($request->to)->toDateString();
            $links = Click::where('link_id', $request->link_id)->whereBetween('created_at', [$from, $to])->get();
            return count($links);
        }
        $links = Click::where('link_id', $request->link_id)->get();
        return count($links);
    }

    public function analytic(Request $request)
    {
        $click = new Click();
        $click->create(['link_id' => $request->id, 'clicks' => 1])->save();
        return $click;
    }

    public function countViews(Request $request)
    {
        $view = new View();
        $view->create(['link_id' => $request->id, 'views' => 1])->save();
        return $view;
    }
}
