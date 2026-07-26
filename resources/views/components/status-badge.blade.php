@props(['status'])
@php
    $colors = [
        'pending' => 'text-bg-secondary',
        'paid' => 'text-bg-info',
        'processing' => 'text-bg-warning',
        'completed' => 'text-bg-success',
        'cancelled' => 'text-bg-danger',
    ];
    $labels = [
        'pending' => 'Menunggu Pembayaran',
        'paid' => 'Sudah Dibayar',
        'processing' => 'Sedang Diproses',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
    ];
@endphp
<span {{ $attributes->merge(['class' => 'badge '.($colors[$status] ?? 'text-bg-secondary')]) }}>{{ $labels[$status] ?? ucfirst($status) }}</span>
