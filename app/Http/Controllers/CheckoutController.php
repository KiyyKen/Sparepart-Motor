<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Notifications\OrderCreated;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        $cart = $request->user()->cart?->load('items.product');

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->withErrors('Keranjang masih kosong.');
        }

        return view('cart.checkout', compact('cart'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'shipping_address' => ['required', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $cart = $request->user()->cart?->load('items.product');
        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->withErrors('Keranjang masih kosong.');
        }

        $order = DB::transaction(function () use ($cart, $data, $request) {
            $total = 0;
            foreach ($cart->items as $item) {
                if ($item->quantity > $item->product->stock) {
                    abort(422, "Stok {$item->product->name} tidak mencukupi.");
                }
                $total += $item->quantity * $item->product->price;
            }

            $order = Order::create([
                'user_id' => $request->user()->id,
                'order_number' => 'ORD-'.now()->format('YmdHis').'-'.$request->user()->id,
                'status' => 'pending',
                'total_amount' => $total,
                ...$data,
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->quantity * $item->product->price,
                ]);
                $item->product->decrement('stock', $item->quantity);
            }

            $cart->items()->delete();

            $order->statusHistories()->create([
                'status' => 'pending',
                'note' => 'Order dibuat, menunggu pembayaran.',
            ]);

            return $order;
        });

        $order->user->notify(new OrderCreated($order));

        return redirect()->route('payment.show', $order)->with('success', 'Checkout berhasil dibuat, silakan selesaikan pembayaran.');
    }
}
