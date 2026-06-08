<x-layouts.admin :title="$product->exists ? 'Edit Sparepart' : 'Tambah Sparepart'">
    <h1>{{ $product->exists ? 'Edit' : 'Tambah' }} Sparepart</h1>
    <form class="card card-body" method="POST" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf @if($product->exists) @method('PUT') @endif
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Nama</label><input class="form-control" name="name" value="{{ old('name', $product->name) }}" required></div>
            <div class="col-md-6"><label class="form-label">SKU</label><input class="form-control" name="sku" value="{{ old('sku', $product->sku) }}" required></div>
            <div class="col-md-6"><label class="form-label">Kategori</label><select class="form-select" name="category_id" required>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id', $product->category_id)==$category->id)>{{ $category->name }}</option>@endforeach</select></div>
            <div class="col-md-6"><label class="form-label">Brand</label><input class="form-control" name="brand" value="{{ old('brand', $product->brand) }}"></div>
            <div class="col-md-6"><label class="form-label">Harga</label><input class="form-control" type="number" name="price" value="{{ old('price', $product->price) }}" required></div>
            <div class="col-md-6"><label class="form-label">Stok</label><input class="form-control" type="number" name="stock" value="{{ old('stock', $product->stock) }}" required></div>
            <div class="col-12">
                <label class="form-label">Upload Gambar</label>
                <input class="form-control" type="file" name="image" accept="image/png,image/jpeg,image/webp">
                <div class="form-text">Format: JPG, PNG, atau WEBP. Maksimal 2 MB.</div>
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="img-thumbnail mt-3" style="max-height: 160px">
                @endif
            </div>
            <div class="col-12"><label class="form-label">Deskripsi</label><textarea class="form-control" name="description" rows="4" required>{{ old('description', $product->description) }}</textarea></div>
            <div class="col-12"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true))><label class="form-check-label">Aktif</label></div></div>
        </div>
        <button class="btn btn-warning mt-4">Simpan</button>
    </form>
</x-layouts.admin>
