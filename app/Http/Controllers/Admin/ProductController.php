<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('admin.products.index', ['products' => Product::with('category')->latest()->paginate(10)]);
    }

    public function create(): View
    {
        return view('admin.products.form', ['product' => new Product(), 'categories' => Category::orderBy('name')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Product::create($this->data($request));

        return redirect()->route('admin.products.index')->with('success', 'Sparepart dibuat.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.form', ['product' => $product, 'categories' => Category::orderBy('name')->get()]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $product->update($this->data($request, $product));

        return redirect()->route('admin.products.index')->with('success', 'Sparepart diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return back()->with('success', 'Sparepart dihapus.');
    }

    private function data(Request $request, ?Product $product = null): array
    {
        $id = $product?->id ?? 'NULL';
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:100', 'unique:products,sku,'.$id],
            'description' => ['required', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'brand' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($product?->image) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = $request->file('image')->store('products', 'public');
        } else {
            unset($data['image']);
        }

        $data['slug'] = Str::slug($data['name']).'-'.Str::lower($data['sku']);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
