<?php

namespace App\Http\ViewComposers;

use App\Models\Website;
use Illuminate\View\View;

class WebsiteComposer
{
    public function compose(View $view)
    {
        $website = Website::first();
        $view->with('website', $website);
    }
}