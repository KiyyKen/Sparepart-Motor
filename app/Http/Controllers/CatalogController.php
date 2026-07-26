<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::query()
            ->with('category')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('is_active', true)
            ->when($request->search, fn ($query, $search) => $query->where('name', 'like', "%{$search}%"))
            ->when($request->category, fn ($query, $category) => $query->whereHas('category', fn ($q) => $q->where('slug', $category)))
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('catalog.index', [
            'products' => $products,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);

        $product->load(['reviews' => fn ($query) => $query->with('user')->latest()]);
        $averageRating = round($product->reviews->avg('rating') ?? 0, 1);

        return view('catalog.show', compact('product', 'averageRating'));
    }
}
