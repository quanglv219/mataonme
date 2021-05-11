<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Plan;
use Stripe\Stripe;

class SubscriptionController extends Controller
{
    public $stripe;

    public function __construct() 
    {
        Stripe::setApiKey(env('STRIPE_KEY'));
    }

    public function index()
    {
        return view('payments.plans');
    }

    public function subscribe(Request $request) 
    {
        $user = $request->user();
        $paymentMethod = $request->payment_method;

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $stripe->paymentMethods->attach(
            $paymentMethod, ['customer' => auth()->user()->stripe_id]
        );
        $request->user()->newSubscription(
            'PREMIUM', env('PREMIUM_PRICE')
        )->create($paymentMethod, ['email' => $user->email]);
        
        $user->update(['is_subscribed' => true]);
        return response()->json(['subscribed' => true]);
    }

    public function cancel()
    {
        $user = auth()->user();
        $user->subscription('PREMIUM')->cancel();
        return response(true);
    }
}
