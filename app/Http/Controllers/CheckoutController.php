<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Stripe\Stripe;
use Stripe\Charge;
use Cart;
use Mail;
use Session;

class CheckoutController extends Controller
{
    public function checkout()
    {
        if(Cart::content()->count() == 0)
        {
            Session::flash('info', 'Your cart is still empty. do some shopping');
            return redirect()->back();
        }
        
        return view('checkout');
    }

    public function pay()
    {
      Stripe::setApiKey("sk_test_51HJwQnDhollZ1G3BlOLrvg05zP7HNEhi5Xqdk1l83J87h4POc9IyQaA4xUqEvGnax8wvauxZBe4ISJArWmvsispp00wlervTTQ");

      $token = request()->stripeToken;

      $charge = Charge::create([

        'amount' => Cart::total() * 100,
        'currency' => 'usd',
        'description' => 'Ecommerce website with laravel',
        'source' => request()->stripeToken,

      ]);

      Cart::destroy();

      Mail::to(request()->stripeEmail)->send(new \App\Mail\OrderMail);

      Session::flash('success', 'Your Order Has Been Sent, Wait For Our Mail');

      return redirect('/');
    }
}
