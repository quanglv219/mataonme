<?php

namespace App\Http\Controllers;

use App\Models\Click;
use App\Models\Link;
use App\Models\View;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class LinksController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('user_id')) {
            return Link::with(['click', 'view'])->where('user_id', $request->user_id)->orderBy('order', 'ASC')->get();
        }
        return view('links.index');
    }

    public function store(Link $link, Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required',
            'link' => 'required', 
        ]);
        // Create a new link
        $link->fill([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'link' => $request->link,
            'is_active' => $request->is_active,
            'order' => $request->order
        ])->save();
        $link = Link::where('user_id', auth()->id())->where('link', $link->link)->where('order', $link->order)->first();
        return $link;
    }

    public function update(Link $link, Request $request)
    {
        $link->update([
            'name' => $request->name,
            'link' => $request->link,
            'is_active' => $request->is_active,
        ]);
        return $link;
    }

    public function updateAll(Request $request)
    {
        foreach($request->newLinks as $link) {
            Link::where('id', $link['id'])->update(['order' => $link['order']]);
        }
        return response(Link::with(['click', 'view'])->where('user_id', auth()->id())->orderBy('order', 'ASC')->get());
    }

    public function destroy($id)
    {
        Link::find($id)->delete();
        return response()->noContent();
    }
}
