<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\User;
use Illuminate\Support\Facades\Hash;

class PaymentController extends Controller
{
    public function pay(Request $request){
        Stripe::setApiKey(env('STRIPE_SECRET'));//シークレットキー

        $charge = Charge::create(array(
            'amount' => 100,
            'currency' => 'jpy',
            'source'=> request()->stripeToken,
        ));

        \Log::debug(print_r(request()->name, true));
        \Log::debug(print_r(request()->email, true));

        return User::create([
            'name' => request()->name,
            'email' => request()->email,
            'password' => Hash::make(request()->password),
        ]);

        // return back();
    }
}
