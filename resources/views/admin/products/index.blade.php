<x-layouts.admin title="Kelola Sparepart">
    <div class="d-flex justify-content-between mb-3"><h1>Sparepart</h1><a class="btn btn-warning" href="{{ route('admin.products.create') }}">Tambah</a></div>
    <div class="card"><div class="table-responsive"><table class="table mb-0">
        <thead><tr><th>Nama</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Status</th><th></th></tr></thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}<br><small class="text-muted">{{ $product->sku }}</small></td>
                <td>{{ $product->category->name }}</td><td>Rp {{ number_format($product->price,0,',','.') }}</td><td>{{ $product->stock }}</td><td>{{ $product->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                <td class="text-end">
                    <a class="btn btn-sm btn-dark" href="{{ route('admin.products.edit', $product) }}">Edit</a>
                    <form class="d-inline" method="POST" action="{{ route('admin.products.destroy', $product) }}">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Hapus</button></form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table></div></div>
    <div class="mt-3">{{ $products->links() }}</div>
</x-layouts.admin>
