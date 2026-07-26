<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransPaymentSync;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Midtrans\Notification;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function show(Request $request, Order $order): View|RedirectResponse
    {
        abort_unless($order->user_id === $request->user()->id, 403);
        abort_unless($order->status === 'pending', 404);

        $configured = MidtransPaymentSync::isConfigured();

        if ($configured && ! $order->snap_token) {
            try {
                $order->snap_token = $this->createSnapToken($order);
                $order->save();
            } catch (\Throwable $e) {
                Log::error('Gagal membuat Snap token Midtrans', ['order' => $order->order_number, 'message' => $e->getMessage()]);

                return redirect()->route('orders.show', $order)->withErrors('Gagal menghubungi payment gateway, coba lagi nanti.');
            }
        }

        return view('cart.payment', [
            'order' => $order,
            'clientKey' => $configured ? config('services.midtrans.client_key') : null,
            'isProduction' => config('services.midtrans.is_production'),
        ]);
    }

    public function sync(Request $request, Order $order): RedirectResponse
    {
        abort_unless($order->user_id === $request->user()->id || $request->user()->isAdmin(), 403);

        MidtransPaymentSync::refreshFromGateway($order);

        return back()->with('success', $order->status !== 'pending'
            ? 'Status pembayaran diperbarui: '.$order->status.'.'
            : 'Belum ada update status baru dari payment gateway.');
    }

    public function callback(Request $request): JsonResponse
    {
        MidtransPaymentSync::configure();

        try {
            $notification = new Notification();
        } catch (\Throwable $e) {
            Log::error('Midtrans callback: gagal memverifikasi notifikasi', ['message' => $e->getMessage()]);

            return response()->json(['status' => 'error'], 500);
        }

        $order = Order::where('order_number', $notification->order_id)->first();

        if (! $order) {
            Log::warning('Midtrans callback: order not found', ['order_id' => $notification->order_id]);

            return response()->json(['status' => 'ignored']);
        }

        MidtransPaymentSync::applyStatus(
            $order,
            $notification->transaction_status,
            $notification->fraud_status ?? null,
            $notification->payment_type,
            $notification->transaction_id,
        );

        return response()->json(['status' => 'ok']);
    }

    private function createSnapToken(Order $order): string
    {
        MidtransPaymentSync::configure();

        return Snap::getSnapToken([
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total_amount,
            ],
            'customer_details' => [
                'first_name' => $order->customer_name,
                'phone' => $order->phone,
            ],
            'item_details' => $order->items->map(fn ($item) => [
                'id' => (string) $item->product_id,
                'price' => (int) $item->price,
                'quantity' => $item->quantity,
                'name' => str($item->product_name)->limit(50)->value(),
            ])->all(),
            'callbacks' => [
                'finish' => route('orders.show', $order),
                'unfinish' => route('orders.show', $order),
                'error' => route('orders.show', $order),
            ],
        ]);
    }
}
