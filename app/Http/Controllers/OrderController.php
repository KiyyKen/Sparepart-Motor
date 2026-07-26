<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransPaymentSync;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = $request->user()->orders()->latest()->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Request $request, Order $order): View
    {
        abort_unless($order->user_id === $request->user()->id || $request->user()->isAdmin(), 403);

        $order->load('items.product', 'statusHistories', 'reviews');

        if ($order->status === 'pending') {
            MidtransPaymentSync::refreshFromGateway($order);
        }

        return view('orders.show', ['order' => $order]);
    }
}
