<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreated extends Notification implements ShouldQueue
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
        return (new MailMessage)
            ->subject('Order '.$this->order->order_number.' Diterima')
            ->greeting('Halo '.$this->order->customer_name.',')
            ->line('Terima kasih, pesanan kamu sudah kami terima dan sedang menunggu pembayaran.')
            ->line('Nomor pesanan: '.$this->order->order_number)
            ->line('Total tagihan: Rp'.number_format((float) $this->order->total_amount, 0, ',', '.'))
            ->action('Lihat Pesanan', route('orders.show', $this->order))
            ->line('Segera selesaikan pembayaran agar pesananmu dapat diproses.');
    }
}
