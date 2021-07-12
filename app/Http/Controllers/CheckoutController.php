<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $total = $request->input('total');
        \Stripe\Stripe::setApiKey(env('STRIPE_KEY'));
        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
              'price_data' => [
                'currency' => 'usd',
                'unit_amount' => (int) $total * 100,
                'product_data' => [
                  'name' => 'Your cart total',
                  'images' => ["https://i.imgur.com/EHyR2nP.png"],
                ],
              ],
              'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => env('FRONT_END_URL') . '?success=true',
            'cancel_url' => env('FRONT_END_URL') . '?canceled=true',
          ]);

          return response(['url' => $checkout_session->url], 200);
    }

}
