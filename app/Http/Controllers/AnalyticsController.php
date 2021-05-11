<?php

namespace App\Http\Controllers;

use App\Models\Click;
use App\Models\View;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function analytic(Request $request) 
    {
        return [
            'labels' => [$this->getDay(7), $this->getDay(6), $this->getDay(5), $this->getDay(4), $this->getDay(3), $this->getDay(2), $this->getDay(1), $this->getDay(0)],
            'clicks' => [
                'data' => $this->getClicks($request)
            ],
            'views' => [
                'data' => $this->getViews($request)
            ]
        ];
    }
    public function getDay($toSub = 0)
    {
        return now()->subDays($toSub)->toDateString();
    }
    
    public function getClicks(Request $request)
    {
        if ($request->has('day')) {
            return Click::where('created_at', $request->day)->get();
        }
        if ($request->has('from') AND $request->has('to')) {
            return Click::whereBetween('created_at', [$request->from, $request->to])->get();
        }
        $beforeSeven = Click::whereUser()->whereDate('created_at', $this->getDay(7))->get();
        $beforeSix = Click::whereUser()->whereDate('created_at', $this->getDay(6))->get();
        $beforeFive = Click::whereUser()->whereDate('created_at', $this->getDay(5))->get();
        $beforeFour = Click::whereUser()->whereDate('created_at', $this->getDay(4))->get();
        $beforeThree = Click::whereUser()->whereDate('created_at', $this->getDay(3))->get();
        $beforeTwo = Click::whereUser()->whereDate('created_at', $this->getDay(2))->get();
        $beforeOne = Click::whereUser()->whereDate('created_at', $this->getDay(1))->get();
        $today = Click::whereUser()->whereDate('created_at', $this->getDay(0))->get();
        return [count($beforeSeven), count($beforeSix), count($beforeFive), count($beforeFour), count($beforeThree), count($beforeTwo), count($beforeOne), count($today)];
    }

    public function getViews()
    {
        $beforeSeven = View::whereUser()->whereDate('created_at', $this->getDay(7))->get();
        $beforeSix = View::whereUser()->whereDate('created_at', $this->getDay(6))->get();
        $beforeFive = View::whereUser()->whereDate('created_at', $this->getDay(5))->get();
        $beforeFour = View::whereUser()->whereDate('created_at', $this->getDay(4))->get();
        $beforeThree = View::whereUser()->whereDate('created_at', $this->getDay(2))->get();
        $beforeTwo = View::whereUser()->whereDate('created_at', $this->getDay(2))->get();
        $beforeOne = View::whereUser()->whereDate('created_at', $this->getDay(1))->get();
        $today = View::whereUser()->whereDate('created_at', $this->getDay(0))->get();
        return [count($beforeSeven), count($beforeSix), count($beforeFive), count($beforeFour), count($beforeThree), count($beforeTwo), count($beforeOne), count($today)];
    }
}
