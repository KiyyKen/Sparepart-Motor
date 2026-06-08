<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        return view('admin.orders.index', ['orders' => Order::with('user')->latest()->paginate(10)]);
    }

    public function show(Order $order): View
    {
        return view('admin.orders.show', ['order' => $order->load('user', 'items')]);
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate(['status' => ['required', 'in:'.implode(',', Order::STATUSES)]]);
        $order->update($data);

        return back()->with('success', 'Status pesanan diperbarui.');
    }
}
