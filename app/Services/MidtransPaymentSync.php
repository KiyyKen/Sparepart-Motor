<?php

namespace App\Services;

use App\Models\Order;
use App\Notifications\OrderStatusUpdated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Transaction;

class MidtransPaymentSync
{
    public static function isConfigured(): bool
    {
        return (bool) (config('services.midtrans.server_key') && config('services.midtrans.client_key'));
    }

    public static function configure(): void
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = (bool) config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Ask Midtrans directly for the current transaction status and apply it.
     * Safe to call anytime: no-ops if Midtrans isn't configured, the order
     * isn't pending, or no payment attempt has been made yet.
     */
    public static function refreshFromGateway(Order $order): bool
    {
        if (! self::isConfigured() || $order->status !== 'pending' || ! $order->snap_token) {
            return false;
        }

        self::configure();

        try {
            $status = Transaction::status($order->order_number);
        } catch (\Throwable $e) {
            Log::info('Belum ada status transaksi Midtrans untuk order ini', [
                'order' => $order->order_number,
                'message' => $e->getMessage(),
            ]);

            return false;
        }

        self::applyStatus(
            $order,
            $status->transaction_status,
            $status->fraud_status ?? null,
            $status->payment_type ?? null,
            $status->transaction_id ?? null,
        );

        return true;
    }

    public static function applyStatus(
        Order $order,
        string $transactionStatus,
        ?string $fraudStatus,
        ?string $paymentType,
        ?string $transactionId,
    ): void {
        $newStatus = match (true) {
            $transactionStatus === 'capture' && $fraudStatus === 'accept' => 'paid',
            $transactionStatus === 'settlement' => 'paid',
            in_array($transactionStatus, ['cancel', 'deny', 'expire'], true) => 'cancelled',
            default => $order->status,
        };

        DB::transaction(function () use ($order, $newStatus, $paymentType, $transactionId, $transactionStatus) {
            $order->payment_type = $paymentType ?? $order->payment_type;
            $order->midtrans_transaction_id = $transactionId ?? $order->midtrans_transaction_id;

            if ($newStatus === 'paid' && ! $order->isPaid()) {
                $order->paid_at = now();
            }

            if ($newStatus === 'cancelled' && $order->status !== 'cancelled') {
                foreach ($order->items as $item) {
                    $item->product?->increment('stock', $item->quantity);
                }
            }

            $statusChanged = $order->status !== $newStatus;
            $order->status = $newStatus;
            $order->save();

            if ($statusChanged) {
                $order->statusHistories()->create([
                    'status' => $newStatus,
                    'note' => 'Update status pembayaran: '.$transactionStatus,
                ]);

                $order->user->notify(new OrderStatusUpdated($order));
            }
        });
    }
}
