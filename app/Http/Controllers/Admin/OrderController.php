<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Notifications\OrderStatusUpdated;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        return view('admin.orders.index', ['orders' => Order::with('user')->latest()->paginate(10)]);
    }

    public function show(Order $order): View
    {
        return view('admin.orders.show', ['order' => $order->load('user', 'items', 'statusHistories')]);
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate(['status' => ['required', 'in:'.implode(',', Order::STATUSES)]]);

        if ($order->status === $data['status']) {
            return back()->with('success', 'Status pesanan diperbarui.');
        }

        DB::transaction(function () use ($order, $data) {
            if ($data['status'] === 'cancelled' && $order->status !== 'cancelled') {
                foreach ($order->items as $item) {
                    $item->product?->increment('stock', $item->quantity);
                }
            }

            $order->update($data);

            $order->statusHistories()->create([
                'status' => $data['status'],
                'note' => 'Status diubah oleh admin.',
            ]);
        });

        $order->user->notify(new OrderStatusUpdated($order));

        return back()->with('success', 'Status pesanan diperbarui.');
    }
}
