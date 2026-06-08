<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cart = $this->cart($request)->load('items.product');

        return view('cart.index', compact('cart'));
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        abort_unless($product->is_active && $product->stock > 0, 404);

        $data = $request->validate(['quantity' => ['required', 'integer', 'min:1', 'max:'.$product->stock]]);
        $cart = $this->cart($request);
        $item = $cart->items()->firstOrNew(['product_id' => $product->id]);
        $item->quantity = min(($item->quantity ?? 0) + $data['quantity'], $product->stock);
        $item->save();

        return redirect()->route('cart.index')->with('success', 'Sparepart ditambahkan ke keranjang.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate(['quantity' => ['required', 'integer', 'min:1', 'max:'.$product->stock]]);
        $this->cart($request)->items()->where('product_id', $product->id)->update(['quantity' => $data['quantity']]);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $this->cart($request)->items()->where('product_id', $product->id)->delete();

        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    private function cart(Request $request): Cart
    {
        return Cart::firstOrCreate(['user_id' => $request->user()->id]);
    }
}
