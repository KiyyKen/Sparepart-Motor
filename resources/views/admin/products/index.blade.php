<x-layouts.admin title="Kelola Sparepart">
    <div class="d-flex justify-content-between mb-3"><h1 class="d-flex align-items-center gap-2"><i class="bi bi-box-seam-fill"></i> Sparepart</h1><a class="btn btn-warning" href="{{ route('admin.products.create') }}"><i class="bi bi-plus-lg"></i> Tambah</a></div>
    <div class="card"><div class="table-responsive"><table class="table mb-0 align-middle">
        <thead><tr><th></th><th>Nama</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Status</th><th></th></tr></thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td><x-part-art :product="$product" class="part-art--thumb" /></td>
                <td>{{ $product->name }}<br><small class="text-muted mono">{{ $product->sku }}</small></td>
                <td>{{ $product->category->name }}</td>
                <td class="mono">Rp {{ number_format($product->price,0,',','.') }}</td>
                <td class="mono">{{ $product->stock }}</td>
                <td><span class="badge {{ $product->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $product->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                <td class="text-end">
                    <a class="btn btn-sm btn-dark" href="{{ route('admin.products.edit', $product) }}"><i class="bi bi-pencil"></i></a>
                    <form class="d-inline" method="POST" action="{{ route('admin.products.destroy', $product) }}">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash3"></i></button></form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table></div></div>
    <div class="mt-3">{{ $products->links() }}</div>
</x-layouts.admin>
