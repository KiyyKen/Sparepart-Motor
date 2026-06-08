<x-layouts.admin :title="$category->exists ? 'Edit Kategori' : 'Tambah Kategori'">
    <h1>{{ $category->exists ? 'Edit' : 'Tambah' }} Kategori</h1>
    <form class="card card-body" method="POST" action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
        @csrf @if($category->exists) @method('PUT') @endif
        <div class="mb-3"><label class="form-label">Nama</label><input class="form-control" name="name" value="{{ old('name', $category->name) }}" required></div>
        <div class="mb-3"><label class="form-label">Deskripsi</label><textarea class="form-control" name="description">{{ old('description', $category->description) }}</textarea></div>
        <button class="btn btn-warning">Simpan</button>
    </form>
</x-layouts.admin>
