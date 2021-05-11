<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlansController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->subscribed('PREMIUM')) {
            return redirect(route('user.settings'));
        }
        $paymentMethods = $request->user()->paymentMethods();
        $checkout = auth()->user()
                    ->newSubscription('Premium', env('PREMIUM_PRICE'))
                    ->checkout();
        $intent = $request->user()->createSetupIntent();
        return view('payments.premium', [
            'checkout' => $checkout,
            'intent' => $intent
        ]);
    }
}
