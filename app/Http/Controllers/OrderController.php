<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
        /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();

        foreach ($orders as $index => $order) {
            $order['user'] = User::find($order['user_id'])->name;
            $order['order'] = unserialize($order->order);
            $order['orderItems'] = $order->order['products'];
        }

        return compact('orders');
    }
}
