<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $order = $request->user()->orders()
            ->where('status', 'completed')
            ->whereHas('items', fn ($query) => $query->where('product_id', $product->id))
            ->whereDoesntHave('reviews', fn ($query) => $query->where('product_id', $product->id))
            ->latest()
            ->first();

        abort_unless($order, 403, 'Kamu hanya bisa mengulas sparepart dari pesanan yang sudah selesai.');

        $order->reviews()->create([
            'product_id' => $product->id,
            'user_id' => $request->user()->id,
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
        ]);

        return back()->with('success', 'Terima kasih, ulasan kamu sudah ditambahkan.');
    }
}
