<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Order $order)
    {
    }

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $labels = [
            'pending' => 'Menunggu Pembayaran',
            'paid' => 'Sudah Dibayar',
            'processing' => 'Sedang Diproses',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        return (new MailMessage)
            ->subject('Status Order '.$this->order->order_number.' Diperbarui')
            ->greeting('Halo '.$this->order->customer_name.',')
            ->line('Status pesanan kamu telah diperbarui menjadi: '.($labels[$this->order->status] ?? $this->order->status))
            ->line('Nomor pesanan: '.$this->order->order_number)
            ->action('Lihat Pesanan', route('orders.show', $this->order));
    }
}
