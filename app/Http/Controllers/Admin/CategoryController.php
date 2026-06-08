<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.categories.index', ['categories' => Category::latest()->paginate(10)]);
    }

    public function create(): View
    {
        return view('admin.categories.form', ['category' => new Category()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Category::create($this->data($request));

        return redirect()->route('admin.categories.index')->with('success', 'Kategori dibuat.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.form', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $category->update($this->data($request, $category));

        return redirect()->route('admin.categories.index')->with('success', 'Kategori diperbarui.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return back()->with('success', 'Kategori dihapus.');
    }

    private function data(Request $request, ?Category $category = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,'.($category?->id ?? 'NULL')],
            'description' => ['nullable', 'string'],
        ]);
        $data['slug'] = Str::slug($data['name']);

        return $data;
    }
}
